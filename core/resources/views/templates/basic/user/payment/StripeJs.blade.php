@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center g-4">
        <div class="col-lg-4 col-xl-3 col-sm-6">
            <div class="deposit-item d-block">
                <div class="deposit-thumb w-100">
                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" alt="@lang('Image')">
                </div>

                <div class="mt-4">
                    <p>
                        @lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}
                    </p>
                    <p class="my-3">
                        @lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}
                    </p>
                </div>

                <div class="mt-4">
                    <form action="{{$data->url}}" method="{{$data->method}}">
                        @csrf
                        <script src="{{$data->src}}"
                            class="stripe-button"
                            @foreach($data->val as $key=> $value)
                            data-{{$key}}="{{$value}}"
                            @endforeach
                        >
                        </script>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("cmn--btn w-100 justify-content-center").removeClass('stripe-button-el');
        })(jQuery);
    </script>
@endpush
