<?php

namespace App\Http\Controllers\Gateway\openpix;

use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        //Log::info('Iniciando processamento de pagamento OpenPix', ['depositId' => $deposit->id]);

        $gatewayCurrency = $deposit->gatewayCurrency();
        $alias = $deposit->gateway->alias;
        $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
        $user = auth()->user();

        $correlationID = sprintf('%s-%s', $deposit->id, time());
        $webhookUrl = route('ipn.'.$alias); // Gera a URL do webhook dinamicamente
        //Log::info('Webhook URL', ['webhookUrl' => $webhookUrl]);

        $payload = [
            "correlationID" => $correlationID,
            "value" => intval($deposit->final_amo * 100),
            "customer" => [
                "name" => $user->username,
                "email" => $user->email,
            ],
            "webhookUrl" => $webhookUrl,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $gatewayAcc->access_token,
                'Content-Type' => 'application/json',
            ])->post('https://api.openpix.com.br/api/v1/charge', $payload); // Ajustado conforme documentação da OpenPix

            if ($response->failed()) {
                //Log::error('Falha na solicitação à API OpenPix', ['response' => $response->body()]);
                throw new \Exception('Erro ao criar a cobrança PIX: ' . $response->body());
            }

            $responseData = $response->json();
            //Log::info('Resposta da API OpenPix para criação de cobrança recebida', ['response' => $responseData]);

            $qrCodeImageUrl = $responseData['charge']['qrCodeImage'] ?? '';

            $deposit->admin_feedback = $responseData['charge']['paymentLinkUrl'] ?? '';
            $deposit->trx = $correlationID;
            $deposit->save();

            notify($user, 'DEPOSIT_PIX', [
                'urlpix' => $responseData['charge']['paymentLinkUrl'] ?? '',
                'trx' => $correlationID,
                'amount' => floatval($deposit->final_amo),
            ]);

            notify($user, 'PIXCOPIA_ECOLA', [
                'copiaecola' => $responseData['charge']['brCode'] ?? '',
            ]);

            $send = [
                'paymentId' => $responseData['charge']['paymentLinkID'] ?? '',
                'pixCode' => $responseData['charge']['brCode'] ?? '',
                'base64' => $qrCodeImageUrl,
                'urlpix' => $responseData['charge']['paymentLinkUrl'] ?? '',
                'trx' => $correlationID,
                'amount' => $deposit->final_amo,
                'email' => $user->email,
                'qrCodeImageUrl' => $qrCodeImageUrl,
                'view' => 'user.payment.' . $alias,
            ];

            return json_encode($send);

        } catch (\Exception $e) {
            //Log::error('Erro ao processar pagamento OpenPix', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Falha no processamento do pagamento OpenPix.'], 500);
        }
    }

public function ipn(Request $request)
{
    //Log::info('IPN OpenPix recebido', ['request' => $request->all()]);
    try {
        $event = $request->input('event');
        $data = json_decode($request->getContent(), true);
        // Verifica se 'charge' existe e possui 'correlationID', senão tenta de 'pix'
        $correlationID = isset($data['charge']['correlationID']) ? $data['charge']['correlationID'] : ($data['pix']['correlationID'] ?? null);

        if (!$correlationID) {
            throw new \Exception('correlationID não fornecido.');
        }

        $deposit = Deposit::where('trx', $correlationID)->orderBy('id', 'DESC')->first();

        if (!$deposit) {
            throw new \Exception("Depósito não encontrado para o correlationID: {$correlationID}.");
        }

        // Evento OPENPIX:CHARGE_COMPLETED indica que o pagamento foi concluído com sucesso
        if ($event === 'OPENPIX:CHARGE_COMPLETED') {
            PaymentController::userDataUpdate($deposit->trx);

            $notify[] = ['success', 'Pagamento via OpenPix concluído com sucesso.'];
            return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
        } else {
            $notify[] = ['error', 'Evento OpenPix não reconhecido ou não tratado.'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

    } catch (\Exception $e) {
        //Log::error('Erro ao processar IPN OpenPix', ['error' => $e->getMessage()]);
        $notify[] = ['error' => 'Falha ao processar IPN OpenPix.'];
        return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
    }
}



}
