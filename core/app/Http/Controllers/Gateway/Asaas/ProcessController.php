<?php

namespace App\Http\Controllers\Gateway\Asaas;

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

        $data = [
            'description' => 'Pagamento Pedido ' . $deposit->trx,
            'value' => $deposit->final_amo,
            'format' => 'ALL',
            'allowsMultiplePayments' => true,
        ];

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'access_token' => $gatewayAcc->access_token,
        ])->post('https://www.asaas.com/api/v3/pix/qrCodes/static', $data);

        if ($response->failed()) {
            throw new \Exception('Erro ao gerar PIX: ' . $response->body());
        }

        $responseData = $response->json();

        $paymentId = $responseData['id'] ?? null;
        $pixCode = $responseData['payload'] ?? null;
        $encodedImage = $responseData['encodedImage'] ?? null;

        if (!$paymentId || !$pixCode || !$encodedImage) {
            throw new \Exception('Dados insuficientes retornados pela API Asaas.');
        }

        $deposit->admin_feedback = $pixCode;
        $deposit->trx = $paymentId;
        $deposit->save();

        $send['data'] = [
            'paymentId' => $paymentId,
            'pixCode' => $pixCode,
            'base64' => $encodedImage,
        ];
        $send['view'] = 'user.payment.' . $alias;

        return json_encode($send);
    }

    /**
     * Webhook IPN do Asaas
     */
    public function ipn(Request $request)
    {
        try {
            $payment = $request->input('payment');

            $pixQrCodeId = $payment['pixQrCodeId'] ?? null;
            $paymentStatus = strtoupper($payment['status'] ?? '');
            $customerId = $payment['customer'] ?? null;

            if (!$pixQrCodeId) {
                return response()->json(['error' => 'pixQrCodeId não encontrado.'], 400);
            }

            $deposit = Deposit::where('trx', $pixQrCodeId)->orderBy('id', 'DESC')->first();

            if (!$deposit) {
                return response()->json(['error' => 'Depósito não encontrado para este QRCode.'], 404);
            }

            $gatewayCurrency = $deposit->gatewayCurrency();
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

            // 🔍 Consulta o cliente na API Asaas
            $payerName = 'Não informado';
            $payerCpfCnpj = null;

            if ($customerId) {
                $customerResponse = Http::withHeaders([
                    'accept' => 'application/json',
                    'access_token' => $gatewayAcc->access_token,
                ])->get('https://www.asaas.com/api/v3/customers/' . $customerId);

                if ($customerResponse->successful()) {
                    $customerData = $customerResponse->json();
                    $payerName = $customerData['name'] ?? 'Não informado';
                    $payerCpfCnpj = $customerData['cpfCnpj'] ?? null;
                    $payerCpfCnpj = $payerCpfCnpj ? preg_replace('/[^0-9]/', '', $payerCpfCnpj) : null;
                }
            }

            // 🔧 Atualiza CPF e Nome no usuário
            $user = $deposit->user;
            $dadosAlterados = false;

            if (!empty($payerCpfCnpj) && $payerCpfCnpj !== $user->cpf) {
                $user->cpf = $payerCpfCnpj;
                $dadosAlterados = true;
            }

            if (!empty($payerName) && $payerName !== $user->nomecompleto) {
                $user->nomecompleto = $payerName;
                $dadosAlterados = true;
            }

            if ($dadosAlterados) {
                $user->save();
            }

            // ✔️ Processa pagamento se status for RECEIVED ou PAID
            if (in_array($paymentStatus, ['RECEIVED', 'PAID'])) {
                PaymentController::userDataUpdate($deposit->trx);
                return response()->json(['message' => 'Pagamento confirmado com sucesso.'], 200);
            } else {
                return response()->json(['message' => 'Pagamento não está confirmado.'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro no processamento do webhook.'], 500);
        }
    }
}
