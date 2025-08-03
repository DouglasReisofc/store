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

                <div class="">
                    <form action="{{$data->url}}" method="{{$data->method}}">
                        @csrf
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <script src="{{$data->checkout_js}}"
                                @foreach($data->val as $key=>$value)
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
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("ml-4 mt-4");
            $('.razorpay-payment-button').addClass("cmn--btn w-100 justify-content-center").removeClass('razorpay-payment-button');
        })(jQuery);
    </script>
@endpush
