@extends($activeTemplate.'layouts.auth_master')

@php
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
            <form class="account-form row g-4" method="POST" action="{{ route('user.password.email') }}">
                @csrf
                <div class="col-md-12">
                    <label for="type" class="form--label">@lang('Select One')</label>

                    <div class="select-item">
                        <select name="type" id="type" class="form--control select-bar m-0">
                            <option value="">@lang('Select An Option')</option>
                            <option value="email">@lang('E-Mail Address')</option>
                            <option value="username">@lang('Username')</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-12">
                    <label for="input" class="form--label my_value"></label>
                    <input id="input" type="text" class="form-control form--control @error('value') is-invalid @enderror" name="value" required autofocus="off">

                    @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center">@lang('Send Password Code')</button>
                </div>

                <div class="col-md-12">
                    @lang('Enter your email and we’ll help you create a new password')
                </div>

            </form>
        </div>
    </div>

</div>
<!-- Account Section Ends Here -->

@endsection
@push('script')
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush
