@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 col-md-12">
                @if(Auth::user()->ts)
                    <div class="card custom--card h-100">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                        </div>
                        <div class="card-body">
                            <div class="two-factor-content">
                                <h6 class="subtitle">
                                    @lang('SUA VERIFICAÇÃO 2FA ESTÁ ATIVADA. SE VOCÊ DESEJA DESATIVAR A VERIFICAÇÃO 2FA, VOCÊ PRECISA DO CÓDIGO AUTENTICADOR DO GOOGLE')
                                </h6>
                            </div>
                            <div class="form-group mx-auto text-center">
                                <a href="#0" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#disableModal">
                                    @lang('Desative o autenticador de dois fatores')</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card custom--card h-100">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Autenticador de dois fatores')</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form-control form--control form-control-lg" id="referralURL" readonly>
                                    <span class="input-group-text copytext bg--base" id="copyBoard">
                                        <i class="fa fa-copy"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="two-factor-scan text-center my-4">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                            </div>
                            <div class="form-group mx-auto text-center">
                                <a href="#0" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Habilitar Autenticador de Dois Fatores')</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card custom--card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Google Authenticator')</h5>
                    </div>
                    <div class="card-body">
                        <div class="two-factor-content">
                            <h6 class="subtitle">
                                @lang('USE O AUTENTICADOR DO GOOGLE PARA VERIFICAR O CÓDIGO QR OU USAR O CÓDIGO')
                            </h6>
                            <p>@lang('O Google Authenticator é um aplicativo multifatorial para dispositivos móveis. Ele gera códigos cronometrados usados ​​durante o processo de verificação em duas etapas. Para usar o Google Authenticator, instale o aplicativo Google Authenticator')</p>
                            <a class="cmn--btn" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('BAIXAR APLICATIVO')
                            </a>
                        </div>
                    </div>
                </div><!-- //. single service item -->
            </div>
        </div>
    </div>


    <!--Enable Modal -->
    <div id="enableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verifique seu OTP')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Digite o código do autenticador do Google')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--md btn--success">@lang('Verificar')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--md btn--success">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


