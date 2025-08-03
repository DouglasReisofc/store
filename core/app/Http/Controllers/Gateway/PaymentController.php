<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 2;
        $data->save();
        session()->put('Track', $data->trx);
        return redirect()->route('user.deposit.preview');
    }

    public function depositPreview()
    {
        $track = session()->get('Track');
        $data = Deposit::where('trx', $track)->where('status', 2)->orderBy('id', 'DESC')->first();

        if (!$data) {
            return redirect()->route('user.home');
        }

        $pageTitle = 'Detalhes do Pagamento';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'pageTitle'));
    }


    public function depositConfirm()
{
    try {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', 2)->orderBy('id', 'DESC')->with('gateway')->first();

        // Verifique se o depósito não foi encontrado
        if (!$deposit) {
            return redirect()->route('user.home');
        }

        // Log de todos os dados da transação
        //Log::info('Dados da Transação: ' . json_encode($deposit));

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        // Log de todos os dados do processo
        //Log::info('Dados do Processo: ' . json_encode($data));

        // Verifique se ocorreu um erro durante o processamento
        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route('user.home');
        }
        // Verifique se há um redirecionamento
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Finalize o Pagamento';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    } catch (\Exception $e) {
        // Log do erro
        //Log::error('Erro no processamento depositConfirm: ' . $e->getMessage());

        // Redirecione para user.home em caso de exceção
        return redirect()->route('user.home')->with(['error' => 'Ops! Algo deu errado.']);
    }
}





    public static function userDataUpdate($trx)
{
    try {
        $general = GeneralSetting::first();
        $data = Deposit::where('trx', $trx)->first();

        if (!$data) {
            return;
        }

        if ($data->status == 2) {
            $data->status = 1;
            $data->save();

            $user = User::find($data->user_id);

            if (!$user) {
                return;
            }

            $user->balance += $data->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $data->user_id;
            $transaction->amount = $data->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $data->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via ' . $data->gatewayCurrency()->name;
            $transaction->trx = $data->trx;
            $transaction->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Pagamento bem-sucedido via ' . $data->gatewayCurrency()->name;
            $adminNotification->click_url = urlPath('admin.deposit.successful');
            $adminNotification->save();

            notify($user, 'DEPOSIT_COMPLETE', [
                'method_name' => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => showAmount($data->final_amo),
                'amount' => showAmount($data->amount),
                'charge' => showAmount($data->charge),
                'currency' => $general->cur_text,
                'rate' => showAmount($data->rate),
                'trx' => $data->trx,
                'post_balance' => showAmount($user->balance)
            ]);

            // Redirecione para a página de depósito
            return redirect()->route('user.home')->with(['redirect' => true]);
        }
    } catch (\Exception $e) {
        Log::error('Erro no processamento userDataUpdate: ' . $e->getMessage());
        return;
    }
}



public function checkPaymentStatus($trx) {
    // Busca o registro na tabela 'deposits' usando 'trx' como chave
    $deposit = Deposit::where('trx', $trx)->first();

    if (!$deposit) {
        // Se não encontrar o depósito, retorna um erro
        return response()->json(['error' => 'Depósito não encontrado'], 404);
    }

    // Se encontrar, retorna o status do depósito
    return response()->json(['status' => $deposit->status]);
}



    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 2)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {
            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'pageTitle', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 2)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gatewayCurrency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $custom) {
                $rules[$key] = [$custom->validation];
                if ($custom->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
                }
                if ($custom->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($custom->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }

        $data->status = 2; // pending
        $data->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from '.$data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();

        $general = GeneralSetting::first();
        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);

        $notify[] = ['success', 'Seu pedido de pagamento foi atendido.'];
        return redirect()->route('user.deposit.history')->withNotify($notify);
    }


    // ... (Outras funções, se houver)

}
