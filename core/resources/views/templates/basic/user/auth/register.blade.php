@extends($activeTemplate.'layouts.auth_master')

@php
    $policyPages = getContent('policy_pages.element');
    $bgImage = getContent('authentication.content', true);
@endphp

@section('content')
    <!-- Account Section Starts Here -->
    <div class="account-section bg-img" style="background-image: url( {{ getImage('assets/images/frontend/authentication/' .@$bgImage->data_values->image, '1920x1080') }} );">
        <div class="left">
            <div class="left-inner w-100">
                <div class="logo text-center mb-lg-5 mb-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('caminho/para/sua/imagem.png') }}" alt="@lang('logo')" style="max-width: 200px; display: block; margin: 0 auto;">
                    </a>
                </div>
                <form class="account-form row g-4" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="col-md-6">
                        <label for="firstname" class="form--label">@lang('First Name')</label>
                        <input id="firstname" type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form--label">@lang('Last Name')</label>
                        <input id="lastname" type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                    </div>
                    {{-- Ocultar visualmente o campo de seleção de país --}}
                    <div class="col-md-6 visually-hidden">
                        <label for="country" class="form--label">@lang('Country')</label>
                        <div class="select-item">
                            <select name="country" id="country" class="form--control select-bar m-0">
                                @foreach($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
<div class="col-md-6">
    <label for="mobile" class="form--label">@lang('Mobile')
        <small class="text-danger mobileExist"></small>
    </label>
    <div class="input-group">
        <span class="input-group-text visually-hidden" id="basic-addon1"></span>
        <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" placeholder="@lang('11 97129-XXXX')">
    </div>
    <input type="hidden" name="mobile_code">
    <input type="hidden" name="country_code">
</div>



                    <div class="col-md-6">
                        <label for="username" class="form--label">@lang('Username')
                            <small class="text-danger usernameExist"></small>
                        </label>
                        <input id="username" type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form--label">@lang('E-Mail Address')</label>
                        <input id="email" type="email" class="form-control form--control checkUser" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 hover-input-popup">
                        <label for="password" class="form--label">@lang('Password')</label>
                        <input id="password" type="password" class="form-control form--control" name="password" required>
                        @if($general->secure_password)
                            <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="password-confirm" class="form--label">@lang('Confirm Password')</label>
                        <input id="password-confirm" type="password" class="form-control form--control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <!--<div class="col-md-12">
                        @php echo loadReCaptcha() @endphp
                    </div>

                    @include($activeTemplate.'partials.custom_captcha')-->

                    <div class="col-md-12">
                        <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center">@lang('Sign Up')</button>
                    </div>
                    <p class="mt-2">@lang('Already have an account')?
                        <a href="{{ route('user.login') }}" class="text--base">
                            @lang('Sign In')
                        </a></p>
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between">
                            @if($general->agree)
                                <div class="form-check form--check">
                                    <input class="form-check-input" type="checkbox" name="agree" id="tos">
                                    <label class="form-check-label" for="tos">
                                        @lang('I accept all')
                                        @foreach ($policyPages as $singlepage)
                                            <a href="{{ route('policy.page', ['slug'=>slug($singlepage->data_values->title), 'id'=>$singlepage->id]) }}" class="text--base" target="_blank">
                                                {{ __($singlepage->data_values->title) }}
                                            </a>
                                            {{ $loop->last ? '' : ', ' }}
                                        @endforeach
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="right text-center">
            <div class="right-inner w-100">
                <h4 class="title text-white">@lang('Área de Cadastro')</h4>
            </div>
        </div>
    </div>
    <!-- Account Section Ends Here -->

    <div class="modal fade cmn--modal" id="existModalCenter" tabindex="-1" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('You are with us')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @lang('You already have an account please Sign in')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--success">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .hover-input-popup {
            position: relative;
        }

        .hover-input-popup:hover .input-popup {
            opacity: 1;
            visibility: visible;
        }

        .input-popup {
            position: absolute;
            bottom: 130%;
            left: 50%;
            width: 280px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .input-popup::after {
            position: absolute;
            content: '';
            bottom: -19px;
            left: 50%;
            margin-left: -5px;
            border-width: 10px 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #1a1a1a transparent;
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .input-popup p {
            padding-left: 20px;
            position: relative;
        }

        .input-popup p::before {
            position: absolute;
            content: '';
            font-family: 'Line Awesome Free';
            font-weight: 900;
            left: 0;
            top: 4px;
            line-height: 1;
            font-size: 18px;
        }

        .input-popup p.error {
            text-decoration: line-through;
        }

        .input-popup p.error::before {
            content: "\f057";
            color: #ea5455;
        }

        .input-popup p.success::before {
            content: "\f058";
            color: #28c76f;
        }
        
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        (function ($) {
            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });
            @endif

            $('.checkUser').on('focusout', function (e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile: mobile, _token: token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email: value, _token: token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username: value, _token: token}
                }
                $.post(url, data, function (response) {
                    if (response['data'] && response['type'] == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} Já Existe !!`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);

        document.addEventListener('DOMContentLoaded', function () {
            // Seletor do input de número de telefone
            var mobileInput = document.getElementById('mobile');

            // Adiciona um listener para o evento 'input'
            mobileInput.addEventListener('input', function () {
                // Remove todos os caracteres não numéricos
                mobileInput.value = mobileInput.value.replace(/\D/g, '');
            });
        });

    </script>
@endpush
