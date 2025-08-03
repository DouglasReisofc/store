<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\Card;
use App\Models\SupportTicket;
use Carbon\Carbon;
use App\Models\GiftCard;
use App\Models\Vencimento;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
{
    $pageTitle = 'Dashboard';
    $user = Auth::user();

    $latestTrxs = Transaction::where('user_id', $user->id)->latest()->limit(10)->get();

    $countCard = Vencimento::where('user_id', $user->id)->count();

    $countTrx = Transaction::where('user_id', $user->id)->count();


    $countTicket = SupportTicket::where('user_id', $user->id)->count();


    return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'latestTrxs', 'countCard', 'countTrx', 'countTicket'));
}


    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'O campo do nome é obrigatório',
            'lastname.required'=>'O campo do sobrenome é obrigatório'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Perfil atualizado com sucesso .'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'A senha foi alterada com sucesso.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'A senha não corresponde!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'Nenhum histórico encontrado.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }
     
    private function configureMail()
{
    $settings = GeneralSetting::first();
    if ($settings->mail_config) {
        Config::set('mail.mailers.smtp.host', $settings->mail_config->host);
        Config::set('mail.mailers.smtp.port', $settings->mail_config->port);
        Config::set('mail.mailers.smtp.encryption', $settings->mail_config->enc);
        Config::set('mail.mailers.smtp.username', $settings->mail_config->username);
        Config::set('mail.mailers.smtp.password', $settings->mail_config->password);
    }

    Config::set('mail.from.address', $settings->email_from);
    Config::set('mail.from.name', $settings->sitename);
}


public function notifyAdminAboutPurchase($transactionId, $username, $userEmail, $sku)
{
    if (is_null($sku)) {
        return;
    }

    try {
        $this->configureMail();
        
        $admin = Admin::first();
        
        if (!$admin) {
            return;
        }

        $adminEmail = $admin->email;
        $subject = "Novo Pedido Pago $transactionId";
        $message = "Pedido $transactionId | Nome: $username | E-mail: $userEmail | SKU: $sku,<br>"; // Conteúdo HTML

        Mail::send([], [], function ($mail) use ($adminEmail, $subject, $message) {
            $mail->to($adminEmail)
                 ->subject($subject)
                 ->setBody($message, 'text/html');
        });

    } catch (\Exception $e) {
    }
}



private function sendPurchaseToN8N(Request $request, $transaction, $user, $sku, $subCategoryName, $categoryName, $quantity, $price)
{
    $clientIp = $request->input('client_ip') ?? 'UNKNOWN';
    $payload = [
        'transaction_id' => $transaction->trx,
        'sku' => $sku,
        'category' => $categoryName,
        'sub_category' => $subCategoryName,
        'quantity' => $quantity,
        'price' => number_format($price, 2, '.', ''),
        'currency' => 'BRL',
        'date' => now()->format('Y-m-d H:i:s'),
        'ip' => $clientIp,
        'customer' => [
            'id' => $user->id,
            'username' => $user->username,
            'firstname' => $user->firstname ?? 'Não informado',
            'lastname' => $user->lastname ?? 'Não informado',
            'nome' => $user->nomecompleto ?? ($user->firstname . ' ' . $user->lastname),
            'cpf' => $user->cpf ?? 'Não informado',
            'email' => $user->email,
            'phone' => $user->mobile ?? 'Não informado',
        ]
    ];


    try {
        $response = Http::timeout(20)->post('https://safe-orders-n8n.icnxgr.easypanel.host/webhook/clubinho', $payload);
        if ($response->successful()) {
        } else {
            Log::warning('⚠️ Falha ao enviar dados para o N8N.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
    } catch (\Exception $e) {
        Log::error('❌ Erro ao enviar dados para o N8N: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
    }
}






    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'O valor solicitado é menor que o valor mínimo.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'O valor solicitado é maior que o valor máximo.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'Você não tem saldo suficiente para sacar.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id;
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Código de verificação errado'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'O valor solicitado é maior que seu saldo atual.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
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
                                    $notify[] = ['error', 'Não foi possível enviar seu ' . $request[$inKey]];
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
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Retirar via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Nova solicitação de retirada de '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Solicitação de retirada enviada com sucesso'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $data['emptyMessage'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws'));
    }



    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Autenticador do Google ativado com sucesso'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Código de verificação errado'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Autenticador de dois fatores desativado com sucesso'];
        } else {
            $notify[] = ['error', 'Código de verificação errado'];
        }
        return back()->withNotify($notify);
    }

    public function trxLog(){
        $pageTitle = 'Transaction Logs';
        $logs  = Transaction::where('user_id', Auth::user()->id)->latest()->paginate(getPaginate());
        $emptyMessage = 'Data Not Found';
        return view($this->activeTemplate.'user.trx_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }
    




    public function purchaseCard(Request $request) {
        $request->validate([
            'id' => 'required|exists:sub_categories,id',
            'quantity' => 'required|gt:0|integer'
        ]);
    
        $user = Auth::user();
        $quantity = $request->quantity;
        $general = GeneralSetting::first();
    
        $findSubCat = SubCategory::where('id', $request->id)
                        ->whereHas('category', function($q) {
                            $q->where('status', 1);
                        })->firstOrFail();
    
        $cardsAvailableForPurchase = Card::where('sub_category_id', $request->id)
                                          ->where('revender', 0)
                                          ->where('user_id', 0)
                                          ->count();
    
        $cardsAvailableForResell = Card::where('sub_category_id', $request->id)
                                        ->where('revender', 1)
                                        ->count();
    
        if ($cardsAvailableForPurchase + $cardsAvailableForResell < $quantity) {
            $notify[] = ['error', 'Desculpe, não temos estoque suficiente disponível para processar sua solicitação.'];
            return back()->withNotify($notify);
        }
    
        $price = $findSubCat->price * $quantity;
    
        if ($price > $user->balance) {
            $notify[] = ['error', 'Desculpe, você não tem saldo suficiente para fazer esta compra.'];
            return back()->withNotify($notify);
        }
    
        $user->balance -= $price;
        $user->save();
    
        $trx = getTrx();
        $totalPurchased = 0;
        $cardsPurchased = collect();
    
        // Compra de cartões revender=0
        if ($cardsAvailableForPurchase > 0) {
            $cards = Card::where('sub_category_id', $request->id)
                         ->where('revender', 0)
                         ->where('user_id', 0)
                         ->take(min($quantity, $cardsAvailableForPurchase))
                         ->get();
            foreach ($cards as $card) {
                $card->user_id = $user->id;
                $card->trx = $trx;
                $card->purchase_at = now();
                $card->save();
                $cardsPurchased->push($card);
                $totalPurchased++;
    
            
                $this->registerVencimento($user->id, $request->id, $card->details, $trx, 1, now()->addDays($card->card_validity));
            }
        }
    
        $quantity -= $totalPurchased;
    
 
        if ($quantity > 0) {
            $resellCards = Card::where('sub_category_id', $request->id)
                               ->where('revender', 1)
                               ->take($quantity)
                               ->get();
            foreach ($resellCards as $card) {
                $card->user_id = $user->id;
                $card->trx = $trx;
                $card->purchase_at = now();
                $card->disponivel -= 1;
                $card->save();
                $cardsPurchased->push($card);
                $totalPurchased++;
    
      
                $this->registerVencimento($user->id, $request->id, $card->details, $trx, 1, now()->addDays($card->card_validity));
            }
        }
    
        
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $price;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = 'Comprado ' . $totalPurchased . ' ' . $findSubCat->name . ' com sucesso';
        $transaction->trx = $trx;
        $transaction->save();
    
       
        notify($user, 'CARD_BUY', [
            'trx' => $trx,
            'price' => $price,
            'currency' => $general->cur_text,
            'purchase_at' => now(),
            'category' => $findSubCat->category->name,
            'sub_category' => $findSubCat->name,
            'quantity' => $totalPurchased,
            'post_balance' => $user->balance,
            'card' => implode('; ', $cardsPurchased->pluck('details')->toArray())
        ]);

       $this->notifyAdminAboutPurchase($transaction->trx, $user->username, $user->email, $findSubCat->sku);
    $this->sendPurchaseToN8N(
    $request,
    $transaction,
    $user,
    $findSubCat->sku,
    $findSubCat->name,
    $findSubCat->category->name,
    $totalPurchased,
    $price
);


        $notify[] = ['success', 'Compra Realizada 😊'];
        return redirect()->route('user.card')->withNotify($notify);
    }
    
    private function registerVencimento($userId, $subCategoryId, $details, $trx, $quantity, $validity) {
        $vencimento = new Vencimento();
        $vencimento->user_id = $userId;
        $vencimento->sub_category_id = $subCategoryId;
        $vencimento->details = $details;
        $vencimento->trx = $trx;
        $vencimento->purchase_at = now();
        $vencimento->card_quantity = $quantity;
        $vencimento->card_validity = $validity;
        $vencimento->save();
    }








    public function card() {
    $userId = Auth::user()->id;

    $cards = Vencimento::where('user_id', $userId)
                    ->with(['subCategory.category']) 
                    ->latest('purchase_at') 
                    ->paginate(getPaginate()); 

    $pageTitle = 'Minhas Contas';
    
    return view($this->activeTemplate.'user.card', compact('pageTitle', 'cards'));
}



    public function cardDetails($id) {
    $userId = Auth::user()->id;

  
    $cardDetail = Vencimento::where('id', $id)
                    ->where('user_id', $userId)
                    ->with(['subCategory.category']) 
                    ->firstOrFail(); 

    $pageTitle = 'Detalhes da conta';

   
    return view($this->activeTemplate.'user.card_details', compact('pageTitle', 'cardDetail'));
}





public function showRedeemGiftcardForm()
{
    $pageTitle = 'Resgatar Saldo';
    return view($this->activeTemplate.'user.redeem_giftcard', compact('pageTitle'));
}


public function redeemGiftcard(Request $request)
{
    $messages = [
        'code.required' => 'O campo Código de Resgate é obrigatório.',
        'code.exists' => 'O código de Resgate não foi encontrado ou é inválido.',
    ];

    $request->validate([
        'code' => 'required|exists:gift_cards,code',
    ], $messages);

    $giftcard = GiftCard::where('code', $request->code)->first();

    if (!$giftcard) {
        return back()->with('error', 'Código de Resgate não encontrado.');
    }

    if ($giftcard->user_id != null) {
        return back()->with('error', 'Este Código já foi Resgatado.');
    }

    $user = Auth::user();
    $user->balance += $giftcard->amount;
    $user->save();

    $giftcard->user_id = $user->id;
    $giftcard->save();


    $transactionDate = now()->format('d/m/Y H:i:s');


    notify($user, 'GIFT_CARD', [
        'code' => $giftcard->code,
        'amount' => $giftcard->amount,
        'date' => $transactionDate,
        'balance' => $user->balance,
    ]);

    return back()->with('success', 'Saldo Resgatado com sucesso')->with('balance', $user->balance)->with('giftcard_amount', $giftcard->amount);
}





}





