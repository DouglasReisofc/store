<?php

// app/Http/Controllers/CronController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Transaction;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Http;
use App\Lib\CurlRequest;
use App\Models\Gateway;

class CronController extends Controller
{
    public function verificarPagamentos()
    {
        try {
            $deposits = Deposit::where('status', 2)->where('method_code', 119)->get();

            foreach ($deposits as $deposit) {
                $gatewayCurrency = $deposit->gatewayCurrency();
                $gatewayAcc = json_decode($gatewayCurrency->gateway_parameter);

                $paymentId = $deposit->trx;
                $statusPagamento = $this->checkPaymentStatus($paymentId, $gatewayAcc);

                if ($statusPagamento === "approved") {
                    $this->processarPagamentoAprovado($deposit, $gatewayAcc);
                } elseif ($statusPagamento === "pending") {
                    $this->processarPagamentoPendente($deposit);
                } elseif ($statusPagamento === "cancelled") {
                    $this->processarPagamentoCancelado($deposit);
                } else {
                    echo "Status de pagamento desconhecido: $statusPagamento";
                }
            }

            return '<html><body><h1>Verificação de pagamentos concluída!</h1></body></html>';
        } catch (\Exception $e) {
            \Log::error('Erro na verificação de pagamentos: ' . $e->getMessage());
            return '<html><body><h1>Ocorreu um erro na verificação de pagamentos. Consulte os logs para mais informações.</h1></body></html>';
        }
    }

    private function checkPaymentStatus($paymentId, $gatewayAcc)
    {
        $accessToken = $gatewayAcc->access_token;
        $url = "https://api.mercadopago.com/v1/payments/$paymentId";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($url);

        $data = $response->json();

        if (isset($data['status'])) {
            return $data['status'];
        }

        return "unknown";
    }

    private function processarPagamentoAprovado($deposit, $gatewayAcc)
    {
        $general = GeneralSetting::first();
        $user = User::find($deposit->user_id);

        if ($deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            $user->balance += $deposit->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Pagamento Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Pagamento bem-sucedido via ' . $deposit->gatewayCurrency()->name;
            $adminNotification->click_url = urlPath('admin.deposit.successful');
            // Construa a mensagem para notificação
            $notificationMessage = urlencode("🛍️ *{$user->username}* acabou de adicionar saldo na {$general->sitename}");
            $notificationMessage .= urlencode("\nVenha você também Comprar em nossa Store");
            $notificationMessage .= urlencode("\n\nAinda não conhece nosso site?");
            $notificationMessage .= urlencode("\nAcesse " . route('home'));

    // Salve a notificação antes do CURL
    $adminNotification->save();

    // Construa o link para notificar o administrador com a mensagem
    $notificationUrl = 'http://aapanel.gestorvip.shop:8080/notificar?message=' . $notificationMessage;

    // Faça uma solicitação CURL para a URL
    $ch = curl_init($notificationUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

            notify($user, 'DEPOSIT_COMPLETE', [
                'method_name' => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount' => showAmount($deposit->final_amo),
                'amount' => showAmount($deposit->amount),
                'charge' => showAmount($deposit->charge),
                'currency' => $general->cur_text,
                'rate' => showAmount($deposit->rate),
                'trx' => $deposit->trx,
                'post_balance' => showAmount($user->balance)
            ]);
        }
    }

    private function processarPagamentoPendente($deposit)
    {
        $deposit->status = 2;
        $deposit->save();
    }

    private function processarPagamentoCancelado($deposit)
    {
        $deposit->status = 3;
        $deposit->save();
    }
}

