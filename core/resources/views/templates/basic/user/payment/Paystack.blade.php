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
                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        @csrf
                        <button class="cmn--btn w-100 justify-content-center" id="btn-confirm">
                            @lang('Pay Now')
                        </button>
                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                            >
                            </script>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
