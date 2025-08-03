<?php

namespace App\Http\Controllers\Gateway\PicPay;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Gateway\PaymentController;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        try {
            $gatewayCurrency = $deposit->gatewayCurrency();
            $alias = $deposit->gateway->alias;
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
            $user = auth()->user();

            // Verificar se o Pix já foi gerado para este depósito
            if (!empty($deposit->admin_feedback)) {
                $send['paymentId'] = $deposit->trx;
                $send['view'] = 'user.payment.' . $alias;

                if (!$request->ajax()) {
                    return redirect()->route('user.home');
                }

                return json_encode($send);
            }

            $apiUrl = 'https://appws.picpay.com/ecommerce/public/payments';

            $referenceId = $deposit->trx;
            $value = $deposit->final_amo;
            $expiresAt = now()->addDays(3)->toIso8601String(); // Expira em 3 dias

            $firstName = $user->firstname;
            $lastName = $user->lastname;
            $document = "524.310.702-63"; // Substitua pelo CPF do usuário
            $email = $user->email;
            $phone = $user->mobile;

            $dados = [
                "referenceId" => $referenceId,
                "callbackUrl" => route('ipn.'.$alias), // Use o mesmo endpoint para IPN como callback
                "returnUrl" => route('user.home'), // Certifique-se de ajustar conforme necessário
                "value" => $value,
                "expiresAt" => $expiresAt,
                "buyer" => [
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "document" => $document,
                    "email" => $email,
                    "phone" => $phone
                ]
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-picpay-token: ' . $gatewayAcc->access_token]);

            $res = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($res);

            if ($responseData && isset($responseData->qrcode->base64)) {
                $paymentId = $responseData->referenceId;
                $base64 = $responseData->qrcode->base64;
                $pixCode = $responseData->paymentUrl;

                $send['paymentId'] = $paymentId;
                $send['base64'] = $base64;
                $send['pixCode'] = $pixCode;
                $send['valor'] = $deposit->final_amo;
                $send['dataExpiracao'] = $expiresAt; // Adicionando a data de expiração
                $send['view'] = 'user.payment.' . $alias;

                // Atualizar o valor no banco de dados
                $deposit->admin_feedback = $pixCode;
                $deposit->trx = $paymentId;
                $deposit->save();

                return json_encode($send);
            } else {
                throw new \Exception('Ops! Não conseguimos gerar o Pix neste momento. Tente novamente mais tarde.');
            }

        } catch (\Exception $e) {
            // Retorne uma resposta de erro ou realize outras ações necessárias
            return json_encode(['error' => 'Ops! Algo deu errado. Tente novamente mais tarde.']);
        }
    }

    public function ipn(Request $request)
    {
        try {
            // Recupere os dados necessários do $request
            $paymentId = $request->input('referenceId');

            // Obtém o depósito associado ao paymentId
            $deposit = Deposit::where('trx', $paymentId)->orderBy('id', 'DESC')->first();

            if (!$deposit) {
                // Se o depósito não for encontrado, trate conforme necessário
                throw new \Exception('Depósito não encontrado para o ID de pagamento fornecido.');
            }

            // Use a API para verificar o status do pagamento
            $gatewayCurrency = $deposit->gatewayCurrency();
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
            $apiUrl = "https://appws.picpay.com/ecommerce/public/payments/$paymentId/status";
            
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-picpay-token: ' . $gatewayAcc->access_token]);

            $res = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($res);

            // Verifique se o pagamento foi aprovado
            if ($responseData && isset($responseData->status) && $responseData->status == 'paid') {
                // Pagamento aprovado
                PaymentController::userDataUpdate($deposit->trx);

                $notify[] = ['success', 'Payment captured successfully.'];
                return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
            } else {
                // Pagamento não aprovado ou não encontrado
                $notify[] = ['error', 'Unable to process the payment.'];
                return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
            }

        } catch (\Exception $e) {
            // Retorne uma resposta de erro ou realize outras ações necessárias
            return redirect()->route(gatewayRedirectUrl())->with(['error' => 'Ops! Algo deu errado.']);
        }
    }
}
