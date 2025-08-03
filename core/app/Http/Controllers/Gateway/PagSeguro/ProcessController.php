<?php

namespace App\Http\Controllers\Gateway\PagSeguro;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        try {
            $gatewayCurrency = $deposit->gatewayCurrency();
            $alias = $deposit->gateway->alias;
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);
            $user = auth()->user();

            if (!empty($deposit->admin_feedback)) {
                Log::info('Pix já gerado para este depósito.', ['depositId' => $deposit->id]);
                $send = [
                    'paymentId' => $deposit->trx,
                    'pixCode' => $deposit->admin_feedback,
                    'urlpix' => '', 
                    'view' => 'user.payment.' . $alias,
                ];

                return json_encode($send);
            }

            $apiUrl = 'https://api.pagseguro.com/orders';

            $body = [
            "reference_id" => $deposit->trx,
            "customer" => [
                "name" => $user->firstname,
                "email" => $user->email,
                "tax_id" => "06206036235",
                "phones" => [
                    [
                        "country" => "55",
                        "area" => "92",
                        "number" => "995333643",
                        "type" => "MOBILE"
                    ]
                ]
            ],
            "items" => [
                [
                    "name" => "Saldo na Store",
                    "quantity" => 1,
                    "unit_amount" => number_format(floatval($deposit->final_amo) * 100, 0, '.', '') // Multiplica por 100 para converter em centavos
                ]
            ],
            "qr_codes" => [
                [
                    "amount" => [
                        "value" => number_format(floatval($deposit->final_amo) * 100, 0, '.', '') // Multiplica por 100 para converter em centavos
                    ],
                    "expiration_date" => date('c', strtotime('+3 day')),
                ]
            ],
            "shipping" => [
                "address" => [
                    "street" => "Rua Exemplo",
                    "number" => "123",
                    "complement" => "Apto 4",
                    "locality" => "Cidade Exemplo",
                    "city" => "São Paulo",
                    "region_code" => "SP",
                    "country" => "BRA",
                    "postal_code" => "01234567"
                ]
            ],
            "notification_urls" => [
                "https://pagseguro.enviodigital.shop/webhook.php"
            ]
        ];

            Log::info('Iniciando requisição para criação de pedido com Pix.', ['URL' => $apiUrl, 'Body' => $body]);

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $gatewayAcc->access_token,
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                Log::error('Falha ao tentar gerar Pix via API.', ['CURL Error' => curl_error($ch)]);
                curl_close($ch);
                throw new \Exception('Erro ao gerar o código PIX.');
            }

            curl_close($ch);
            $data = json_decode($response, true);
            Log::info('Resposta da API PagSeguro após tentativa de criação de pedido.', ['Response' => $data]);

            if (isset($data['qr_codes']) && is_array($data['qr_codes']) && !empty($data['qr_codes'])) {
                $pixCode = $data['qr_codes'][0]['text'];
                $urlpix = $data['qr_codes'][0]['links'][0]['href'];
                $trx = $data['id'];

                $deposit->admin_feedback = $urlpix;
                $deposit->trx = $trx;
                $deposit->save();

                Log::info('Pix gerado com sucesso.', ['PixCode' => $pixCode, 'URLPix' => $urlpix, 'TransactionID' => $trx]);

                $send = [
                    'paymentId' => $trx,
                    'pixCode' => $pixCode,
                    'urlpix' => $urlpix,
                    'view' => 'user.payment.' . $alias,
                ];

                return json_encode($send);
            } else {
                Log::error('Não foi possível gerar o Pix. Propriedade qr_codes não encontrada na resposta.', ['Response' => $data]);
                return json_encode(['error' => 'Ops! Não conseguimos gerar o Pix neste momento. Tente novamente mais tarde.']);
            }
        } catch (\Exception $e) {
            Log::error('Exceção capturada durante o processamento do depósito.', ['Exception' => $e->getMessage()]);
        }
    }
    public function ipn(Request $request)
    {
        $status = $request->input('status');
        $transactionCode = $request->input('transactionCode');

        if ($status === '1') { // Código '3' representa pagamento confirmado
            $deposit = Deposit::where('trx', $transactionCode)->first();

            if ($deposit && $deposit->status == Status::PAYMENT_INITIATE) {
                PaymentController::userDataUpdate($deposit);
                return redirect()->route(gatewayRedirectUrl(true))->with(['success' => 'Pagamento confirmado com sucesso.']);
            }
        }

        return redirect()->route(gatewayRedirectUrl())->with(['error' => 'Ops! Algo deu errado.']);
    }
}
