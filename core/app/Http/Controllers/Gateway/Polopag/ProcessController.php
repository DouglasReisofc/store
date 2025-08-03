<?php

namespace App\Http\Controllers\Gateway\Polopag;

use App\Models\Deposit;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProcessController extends Controller
{
    /**
     * Gera o PIX para pagamento
     */
    public static function process($deposit)
    {
        $gatewayCurrency = $deposit->gatewayCurrency();
        $alias = $deposit->gateway->alias;
        $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

        if (!$gatewayAcc) {
            throw new \Exception('Parâmetros do gateway não encontrados ou mal formatados.');
        }

        if (empty($gatewayAcc->access_token)) {
            throw new \Exception('Access Token do PoloPag não encontrado.');
        }

        $data = [
            'valor' => number_format($deposit->final_amo, 2, '.', ''),
            'calendario' => [
                'expiracao' => 3600
            ],
            'referencia' => $deposit->trx,
            'solicitacaoPagador' => 'Pagamento - Pedido ' . $deposit->trx,
            'isDeposit' => true,
            'webhookUrl' => route('ipn.' . $alias),
        ];

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Api-Key' => $gatewayAcc->access_token,
        ])
        ->timeout(60)
        ->post('https://api.polopag.com/v1/cobpix', $data);

        if ($response->failed()) {
            throw new \Exception('Erro na criação do PIX: ' . $response->body());
        }

        $responseData = $response->json();

        if (empty($responseData['txid']) || empty($responseData['pixCopiaECola']) || empty($responseData['qrcodeBase64'])) {
            throw new \Exception('Dados incompletos retornados pela API PoloPag.');
        }

        $deposit->admin_feedback = $responseData['pixCopiaECola'];
        $deposit->trx = $responseData['txid'];
        $deposit->save();

        $send['data'] = [
            'paymentId' => $responseData['txid'],
            'pixCode' => $responseData['pixCopiaECola'],
            'base64' => $responseData['qrcodeBase64'],
        ];
        $send['view'] = 'user.payment.' . $alias;

        return json_encode($send);
    }

    /**
     * Webhook de retorno IPN da PoloPag
     */
    public function ipn(Request $request)
    {
        try {
            $txid = $request->input('txid');
            $status = strtoupper($request->input('status'));

            if (!$txid) {
                return response()->json(['error' => 'TXID não encontrado no webhook.'], 400);
            }

            $deposit = Deposit::where('trx', $txid)->orderBy('id', 'DESC')->first();

            if (!$deposit) {
                return response()->json(['error' => 'Depósito não encontrado'], 404);
            }

            $gatewayCurrency = $deposit->gatewayCurrency();
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

            $checkResponse = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Api-Key' => $gatewayAcc->access_token,
            ])->get('https://api.polopag.com/v1/check-pix/' . $txid);

            if ($checkResponse->failed()) {
                throw new \Exception('Erro ao consultar o status do PIX: ' . $checkResponse->body());
            }

            $pixData = $checkResponse->json();

            $payerName = $pixData['pagador']['nome'] ?? 'Não informado';
            $payerCpf = $pixData['pagador']['cpfCnpj'] ?? null;
            $payerCpf = $payerCpf ? preg_replace('/[^0-9]/', '', $payerCpf) : null;

            $user = $deposit->user;
            $dadosAlterados = false;

            if (!empty($payerCpf) && $payerCpf !== $user->cpf) {
                $user->cpf = $payerCpf;
                $dadosAlterados = true;
            }

            if (!empty($payerName) && $payerName !== $user->nomecompleto) {
                $user->nomecompleto = $payerName;
                $dadosAlterados = true;
            }

            if ($dadosAlterados) {
                $user->save();
            }

            if ($status === 'APROVADO') {
                PaymentController::userDataUpdate($deposit->trx);
                return response()->json(['message' => 'Pagamento confirmado com sucesso.'], 200);
            } else {
                return response()->json(['message' => 'Pagamento não aprovado.'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro no processamento do webhook.'], 500);
        }
    }
}
