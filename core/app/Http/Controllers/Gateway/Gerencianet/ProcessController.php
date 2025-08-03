<?php

namespace App\Http\Controllers\Gateway\Gerencianet;

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
        try {
            $gatewayCurrency = $deposit->gatewayCurrency();
            $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

            $user = auth()->user();

            // Solicita um novo token
            $token = self::requestAccessToken($gatewayAcc->client_id, $gatewayAcc->client_secret);

            // Obtém um CPF aleatório
            $cpf = self::getRandomCPF();

            // URL da API da Gerencianet para criar um PIX
            $apiUrl = 'https://api-pix.gerencianet.com.br/v2/cob';

            // Dados da solicitação para criar o PIX
            $data = [
                'calendario' => ['expiracao' => strtotime('+1 hour')], // Tempo de expiração do PIX
                'devedor' => ['cpf' => $cpf, 'nome' => $user->username], // Nome do pagador
                'valor' => ['original' => number_format($deposit->final_amo, 2, '.', '')], // Valor do pagamento PIX
                'chave' => $gatewayAcc->key_pix, // Chave PIX
                'solicitacaoPagador' => 'Pagamento #' . uniqid() // Descrição da solicitação de pagamento
            ];

            // Realiza a solicitação para criar o PIX
            $response = Http::withOptions([
                'cert' => base_path('app/Http/Controllers/Gateway/Gerencianet/certificado/cert.pem'),
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($apiUrl, $data);

            // Verifica se houve algum erro na solicitação
            if ($response->failed()) {
                throw new \Exception('Erro ao gerar o código PIX. Detalhes: ' . json_encode($response->json()));
            }

            // Extrai os dados relevantes do PIX da resposta
            $responseData = $response->json();
            $paymentId = $responseData['txid']; // ID do pagamento PIX
            $locationId = $responseData['loc']['id']; // ID de localização do PIX

            // Obter QRCode
            $qr_url = "https://api-pix.gerencianet.com.br/v2/loc/$locationId/qrcode";
            $qr_response = Http::withOptions([
                'cert' => base_path('app/Http/Controllers/Gateway/Gerencianet/certificado/cert.pem'),
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->get($qr_url);

            // Verifica se houve algum erro na solicitação do QRCode
            if ($qr_response->failed()) {
                throw new \Exception('Erro ao obter o QRCode. Detalhes: ' . json_encode($qr_response->json()));
            }

            // Extrai o QRCode decodificado da resposta
            $qrData = $qr_response->json();

            // Verifica se o QRCode foi obtido com sucesso
            if (isset($qrData['imagemQrcode'])) {
                $pixCode = $qrData['qrcode'] ?? ''; // Código PIX
                $base64 = substr($qrData['imagemQrcode'], strpos($qrData['imagemQrcode'], ",") + 1);
                $urlpix = $qrData['linkVisualizacao'] ?? '';

                // Atualiza os dados do depósito no banco de dados
                $deposit->admin_feedback = $urlpix; // Salva o código QR do PIX como feedback do administrador
                $deposit->trx = $paymentId; // Salva o ID do pagamento PIX
                $deposit->save();

                // Envia notificações para o usuário
                notify($user, 'DEPOSIT_PIX', [
                    'urlpix' => $urlpix, // URL do PIX, se necessário
                    'trx' => $paymentId, // ID do pagamento PIX
                    'amount' => number_format($deposit->final_amo, 2, '.', '') // Formata o valor com duas casas decimais e ponto como separador decimal
                ]);
                
                notify($user, 'PIXCOPIA_ECOLA', [
                    'copiaecola' => $pixCode,
                ]);

                // Dados a serem retornados para a view
                $send['paymentId'] = $paymentId; // ID do pagamento PIX
                $send['pixCode'] = $pixCode; // Código QR do PIX
                $send['base64'] = $base64;
                $send['token'] = $token;
                // Imagem base64 do código QR do PIX
                $send['view'] = 'user.payment.' . $deposit->gateway->alias; // View a ser renderizada após o processamento do pagamento

                return json_encode($send); // Retorna os dados em formato JSON
            } else {
                throw new \Exception('Erro ao obter imagem do QRCode');
            }
        } catch (\Exception $e) {
            Log::error('Erro no processamento depositConfirm: ' . $e->getMessage());
            throw $e;
        }
    }

    // Método para processar notificações de IPN (Instant Payment Notification)
    public function ipn(Request $request)
    {
        try {
            $paymentId = $request->input('data.id'); // ID do pagamento PIX
            $deposit = Deposit::where('trx', $paymentId)->orderBy('id', 'DESC')->first(); // Busca o depósito pelo ID do pagamento

            if (!$deposit) {
                throw new \Exception('Depósito não encontrado para o ID de pagamento fornecido.');
            }

            // Restante do seu código...
        } catch (\Exception $e) {
            Log::error('Erro no processamento depositConfirm: ' . $e->getMessage());
            throw $e;
        }
    }

    private static function requestAccessToken($clientId, $clientSecret)
    {
        try {
            $url = "https://api-pix.gerencianet.com.br/oauth/token";
            $credentials = base64_encode("$clientId:$clientSecret");

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSLCERT, base_path('app/Http/Controllers/Gateway/Gerencianet/certificado/cert.pem'));
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Authorization: Basic $credentials",
                "Content-Type: application/x-www-form-urlencoded"
            ]);

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                throw new \Exception('Erro na solicitação do token: ' . curl_error($curl));
            }
            curl_close($curl);
            $response = json_decode($response, true);
            if (isset($response['access_token'])) {
                $token = $response['access_token'];
            } else {
                throw new \Exception('Erro ao obter o token: ' . json_encode($response));
            }

            return $token;
        } catch (\Exception $e) {
            Log::error('Erro no processamento depositConfirm: ' . $e->getMessage());
            throw $e;
        }
    }

    private static function getRandomCPF()
    {
        // Generate a random CPF number
        $cpf = '';

        for ($i = 0; $i < 9; $i++) {
            $cpf .= mt_rand(0, 9);
        }

        $sum = 0;
        for ($i = 10, $j = 0; $i >= 2; $i--, $j++) {
            $sum += $cpf[$j] * $i;
        }

        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        $cpf .= $digit1;

        $sum = 0;
        for ($i = 11, $j = 0; $i >= 2; $i--, $j++) {
            $sum += $cpf[$j] * $i;
        }

        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        $cpf .= $digit2;

        return $cpf;
    }
}
