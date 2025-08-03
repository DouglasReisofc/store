@extends($activeTemplate.'layouts.auth_master')

@php
    $bgImage = getContent('authentication.content', true);
@endphp

@section('content')
<!-- Account Section Starts Here -->
<div class="account-section bg-img" style="background-image: url({{ getImage('assets/images/frontend/authentication/' .@$bgImage->data_values->image) }}); background-position: center; background-repeat: no-repeat; background-size: cover;">

    <div class="left">
        <div class="left-inner w-100">
            <div class="logo text-center mb-lg-5 mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('caminho/para/sua/imagem.png') }}" alt="@lang('logo')" style="max-width: 200px; display: block; margin: 0 auto;">
                </a>
            </div>
            <form class="account-form row g-4" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                @csrf
                <div class="col-md-12">
                    <label for="username" class="form--label">@lang('Username or Email')</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control form--control" required>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form--label">@lang('Password')</label>
                    <input id="password" type="password" class="form-control form--control" name="password" required>
                </div>
                <!--<div class="col-md-12 g-cap">
                    @php echo loadReCaptcha() @endphp
                </div>

                @include($activeTemplate.'partials.custom_captcha')-->

                <div class="col-lg-12 text-end mt-0">
                    <a href="{{route('user.password.request')}}" class="text--base">
                        @lang('Forgot Password') ?
                    </a>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center">@lang('Sign In')</button>
                </div>
                <p class="mt-2">@lang("Don't have an account")?.
                    <a href="{{ route('user.register') }}" class="text--base">
                        @lang('Create Account')
                    </a>
                </p>
            </form>
        </div>
    </div>
    <div class="right text-center">
        <div class="right-inner w-100">
            <h4 class="title text-white">@lang('Área de Login')</h4>
        </div>
    </div>
</div>
<!-- Account Section Ends Here -->
@endsection

@push('style')
    <style>
        .account-section {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
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

        $('#rc-anchor-container').css({
            width: '100% !important'
        });
    </script>
@endpush
