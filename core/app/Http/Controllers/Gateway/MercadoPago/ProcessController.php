<?php

namespace App\Http\Controllers\Gateway\MercadoPago;

use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        // Geração aleatória de CPF usando a lógica fornecida
        $cpf_gerado = self::gerarCPF();

        // Restante do código continua igual
        $gatewayCurrency = $deposit->gatewayCurrency();
        $alias = $deposit->gateway->alias;
        $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

        $user = auth()->user();

        $apiUrl = 'https://api.mercadopago.com/v1/payments';

        // Aqui você faz a solicitação curl e inclui o CPF gerado aleatoriamente
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'transaction_amount' => floatval($deposit->final_amo),
            'payment_method_id' => 'pix',
            'payer' => [
                'email' => $user->email,
                'identification' => [
                    'type' => 'CPF',
                    'number' => $cpf_gerado, // Usando CPF gerado aleatoriamente
                ],
            ],
            'binary_mode' => true,
            'statement_descriptor' => 'STORE DIGITAL',
            'notification_url' => route('ipn.'.$alias),
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $gatewayAcc->access_token,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Erro ao gerar o código PIX: ' . curl_error($ch));
        }

        curl_close($ch);

        // Extrair a URL do Pix da resposta
        $responseData = json_decode($response, true);
        $paymentId = $responseData['id'];
        $pixCode = $responseData['point_of_interaction']['transaction_data']['qr_code'];
        $base64 = $responseData['point_of_interaction']['transaction_data']['qr_code_base64'];
        $urlpix = $responseData['point_of_interaction']['transaction_data']['ticket_url'];
        $trx = $paymentId;

        // Atualizar o valor no banco de dados
        $deposit->admin_feedback = $urlpix;
        $deposit->trx = $trx;
        $deposit->save();

        // Notificações
        notify($user, 'DEPOSIT_PIX', [
            'urlpix' => $urlpix,
            'trx' => $paymentId,
            'amount' => floatval($deposit->final_amo),
        ]);

        notify($user, 'PIXCOPIA_ECOLA', [
            'copiaecola' => $pixCode,
        ]);

        // Dados para a view
        $send['paymentId'] = $paymentId;
        $send['pixCode'] = $pixCode;
        $send['base64'] = $base64;
        $send['view'] = 'user.payment.' . $alias;

        return json_encode($send);
    }

    public function ipn(Request $request)
    {
        try {
            $paymentId = $request->input('data.id');
            $deposit = Deposit::where('trx', $paymentId)->orderBy('id', 'DESC')->first();

            if (!$deposit) {
                throw new \Exception('Depósito não encontrado para o ID de pagamento fornecido.');
            }

            $gatewayCurrency = $deposit->gatewayCurrency();
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
            $apiUrl = "https://api.mercadopago.com/v1/payments/$paymentId";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $gatewayAcc->access_token,
            ])->get($apiUrl);

            $responseData = $response->json();

            if ($responseData && isset($responseData['status']) && $responseData['status'] == 'approved') {
                PaymentController::userDataUpdate($deposit->trx);

                $notify[] = ['success', 'Pagamento capturado com sucesso.'];
                return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
            } else {
                $notify[] = ['error', 'Não foi possível processar o pagamento.'];
                return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
            }

        } catch (\Exception $e) {
            return redirect()->route(gatewayRedirectUrl())->with(['error' => 'Ops! Algo deu errado.']);
        }
    }

    // Função para extrair uma substring entre dois delimitadores
    private static function getStr($separa, $inicia, $fim, $contador){
        $nada = explode($inicia, $separa);
        $nada = explode($fim, $nada[$contador]);
        return $nada[0];
    }

    // Função para gerar CPF aleatório usando a lógica fornecida
    private static function gerarCPF()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.4devs.com.br/ferramentas_online.php");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=&data_nasc=1');
        $dados = curl_exec($ch);

        $cpf = self::getStr($dados, '"cpf":"','"' , 1);

        curl_close($ch);

        return $cpf;
    }
}
