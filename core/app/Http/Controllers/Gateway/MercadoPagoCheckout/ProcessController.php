<?php

namespace App\Http\Controllers\Gateway\MercadoPagoCheckout;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class ProcessController extends Controller
{
    private static function getAccessToken()
    {
        // Assumindo que você tenha uma lógica para obter a configuração do gateway corretamente
        $gatewayCurrency = GatewayCurrency::where('gateway_alias', 'MercadoPagoCheckout')->first();
        $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
        return $gatewayAcc->access_token;
    }

    public static function process($deposit)
    {
        $accessToken = self::getAccessToken();
        $alias = $deposit->gateway->alias; // Supondo que você possa obter o alias assim
        $user = auth()->user();
        $preferenceData = [
            'items' => [
                [
                    'id' => $deposit->trx,
                    'title' => 'Deposit',
                    'description' => 'Deposit from ' . $user->username,
                    'quantity' => 1,
                    'currency_id' => $deposit->gatewayCurrency()->currency,
                    'unit_price' => (float) $deposit->final_amo,
                ],
            ],
            'payer' => [
                'email' => $user->email,
            ],
            'back_urls' => [
                'success' => route(gatewayRedirectUrl(true)),
                'failure' => route(gatewayRedirectUrl()),
            ],
            'notification_url' => route('ipn.' . $alias),
            'auto_return' => 'approved',
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->post("https://api.mercadopago.com/checkout/preferences?access_token={$accessToken}", $preferenceData);

        if ($response->successful() && $response->json('init_point')) {
            $send['redirect'] = true;
            $send['redirect_url'] = $response->json('init_point');
        } else {
            $send['error'] = true;
            $send['message'] = 'Some problem occurred with the API.';
        }

        return json_encode($send);
    }

    public function ipn(Request $request)
{
    try {
        // Recebe o ID do pagamento da solicitação IPN
        $paymentId = $request->input('data.id');
        $apiUrl = "https://api.mercadopago.com/v1/payments/{$paymentId}";
        
        // Obter o token de acesso de forma segura (recomendado usar variáveis de ambiente ou configuração)
        $accessToken = 'APP_USR-5577540338885233-051517-4b097d07ad034e7dfdb43ea1fc0dc226-1151558635';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($apiUrl);

        $responseData = $response->json();
        //Log::info('Detalhes do Pagamento MercadoPago', ['response' => $responseData]);

        // Verifica se o ID da transação (trx) está presente na resposta
        if (isset($responseData['additional_info']['items'][0]['id'])) {
            $trx = $responseData['additional_info']['items'][0]['id'];

            // Busca o depósito correspondente usando o trx
            $deposit = Deposit::where('trx', $trx)->orderBy('id', 'DESC')->first();

            if (!$deposit) {
                Log::error('Depósito não encontrado', ['trx' => $trx]);
                throw new \Exception('Depósito não encontrado para o trx ID fornecido.');
            }

            // Aqui segue a lógica de verificação e processamento baseada no status do pagamento
            if ($responseData['status'] == 'approved') {
                // Atualiza os dados do usuário conforme necessário
                PaymentController::userDataUpdate($deposit->trx);

                //Log::info('Pagamento aprovado', ['depositId' => $deposit->id]);
                $notify[] = ['success', 'Pagamento capturado com sucesso.'];
                
                // Redireciona com a notificação de sucesso
                return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
            } else {
                //Log::warning('Pagamento não aprovado', ['depositId' => $deposit->id, 'status' => $responseData['status']]);
                $notify[] = ['error', 'Não foi possível processar o pagamento.'];

                // Redireciona com a notificação de erro
                return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
            }
        } else {
            throw new \Exception('ID da transação (trx) não encontrado nos detalhes do pagamento.');
        }
    } catch (\Exception $e) {
        //Log::error('Erro ao processar IPN', ['exception' => $e->getMessage()]);
        // Possível redirecionamento para uma rota de erro ou exibição de uma mensagem de erro genérica
        return redirect()->route(gatewayRedirectUrl())->with(['error' => 'Ops! Algo deu errado.']);
    }
}
}
