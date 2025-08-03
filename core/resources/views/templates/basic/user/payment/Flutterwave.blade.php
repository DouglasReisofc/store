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
                    <button class="cmn--btn w-100 justify-content-center" id="btn-confirm" onClick="payWithRave()">
                        @lang('Pay Now')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush
