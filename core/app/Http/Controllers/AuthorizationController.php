<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AuthorizationController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }
    public function checkValidCode($user, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$user->ver_code_send_at) return false;
        if ($user->ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->ver_code !== $code) return false;
        return true;
    }


    public function authorizeForm()
    {

        if (auth()->check()) {
            $user = auth()->user();
            if (!$user->status) {
                Auth::logout();
            }elseif (!$user->ev) {
                if (!$this->checkValidCode($user, $user->ver_code)) {
                    $user->ver_code = verificationCode(6);
                    $user->ver_code_send_at = Carbon::now();
                    $user->save();
                    sendEmail($user, 'EVER_CODE', [
                        'code' => $user->ver_code
                    ]);
                }
                $pageTitle = 'Email verification form';
                return view($this->activeTemplate.'user.auth.authorization.email', compact('user', 'pageTitle'));
            }elseif (!$user->sv) {
                if (!$this->checkValidCode($user, $user->ver_code)) {
                    $user->ver_code = verificationCode(6);
                    $user->ver_code_send_at = Carbon::now();
                    $user->save();
                    sendSms($user, 'SVER_CODE', [
                        'code' => $user->ver_code
                    ]);
                }
                $pageTitle = 'SMS verification form';
                return view($this->activeTemplate.'user.auth.authorization.sms', compact('user', 'pageTitle'));
            }elseif (!$user->tv) {
                $pageTitle = 'Google Authenticator';
                return view($this->activeTemplate.'user.auth.authorization.2fa', compact('user', 'pageTitle'));
            }else{
                return redirect()->route('user.home');
            }

        }

        return redirect()->route('user.login');
    }

// Atualize a função sendVerifyCode para sempre enviar um novo código
public function sendVerifyCode(Request $request)
{
    $user = Auth::user();

    $user->ver_code = verificationCode(6);
    $user->ver_code_send_at = Carbon::now();
    $user->save();

    // Determine o tipo de notificação (e-mail ou SMS) baseado no request (pode precisar de ajustes conforme sua implementação)
    $notificationType = ($request->type === 'email') ? 'EVER_CODE' : 'SVER_CODE';

    // Envie a notificação
    if ($notificationType === 'EVER_CODE') {
        sendEmail($user, $notificationType, [
            'code' => $user->ver_code
        ]);
    } elseif ($notificationType === 'SVER_CODE') {
        sendSms($user, $notificationType, [
            'code' => $user->ver_code
        ]);
    }

    // Adicione um notify
    $notify[] = ['success', 'Novo código de verificação enviado com sucesso'];

    // Adicione um notify e redirecione de volta
    return back()->withNotify($notify);
}

// Adicione este método para atualizar o número de telefone
public function updateMobile(Request $request)
{
    $user = auth()->user();

    // Valide os dados conforme necessário
    $request->validate([
        'new_mobile' => 'required|numeric', // Adicione outras regras de validação conforme necessário
    ]);

    $oldMobile = $user->mobile;

    // Se o novo número for diferente do antigo, atualize e envie sempre um novo código de verificação
    if ($user->mobile !== $request->new_mobile) {
        // Concatene "55" ao novo número
        $newMobile = '55' . $request->new_mobile;

        $user->mobile = $newMobile;
        $user->save();

        // Envie sempre um novo código de verificação
        $user->ver_code = verificationCode(6);
        $user->ver_code_send_at = Carbon::now();
        $user->save();

        // Determine o tipo de notificação (e-mail ou SMS) baseado no request (pode precisar de ajustes conforme sua implementação)
        $notificationType = ($request->type === 'email') ? 'EVER_CODE' : 'SVER_CODE';

        // Envie a notificação
        if ($notificationType === 'EVER_CODE') {
            sendEmail($user, $notificationType, [
                'code' => $user->ver_code
            ]);
        } elseif ($notificationType === 'SVER_CODE') {
            sendSms($user, $notificationType, [
                'code' => $user->ver_code
            ]);
        }

        // Adicione um notify
        $notify[] = ['success', 'Número de telefone alterado com sucesso. Um novo código de verificação foi enviado.'];
    } else {
        // Se o novo número for igual ao antigo, apenas adicione um notify
        $notify[] = ['info', 'O número de telefone não foi alterado.'];
    }

    // Adicione um notify e redirecione de volta
    return back()->withNotify($notify);
}





    public function emailVerification(Request $request)
    {
        $request->validate([
            'email_verified_code'=>'required'
        ]);


        $email_verified_code = str_replace(' ','',$request->email_verified_code);
        $user = Auth::user();

        if ($this->checkValidCode($user, $email_verified_code)) {
            $user->ev = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->route('user.home');
        }
        throw ValidationException::withMessages(['email_verified_code' => 'O código de verificação não corresponde!']);
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'sms_verified_code' => 'required',
        ]);


        $sms_verified_code =  str_replace(' ','',$request->sms_verified_code);

        $user = Auth::user();
        if ($this->checkValidCode($user, $sms_verified_code)) {
            $user->sv = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->route('user.home');
        }
        throw ValidationException::withMessages(['sms_verified_code' => 'O código de verificação não corresponde!']);
    }
    public function g2faVerification(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'code' => 'required',
        ]);
        $code = str_replace(' ','',$request->code);
        $response = verifyG2fa($user,$code);
        if ($response) {
            $notify[] = ['success','Verificação concluida'];
        }else{
            $notify[] = ['error','Código de verificação errado'];
        }
        return back()->withNotify($notify);
    }
}
