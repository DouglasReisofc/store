@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card custom--card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Stripe Payment')</h5>
                    </div>
                    <div class="card-body">

                        <div class="card-wrapper"></div>
                        <br><br>

                        <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                            @csrf
                            <input type="hidden" value="{{$data->track}}" name="track">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form--label">@lang('Name on Card')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form--control custom-input" name="name" autocomplete="off" autofocus/>
                                        <span class="input-group-text bg--base"><i class="fa fa-font"></i></span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form--label">@lang('Card Number')</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form--control custom-input" name="cardNumber" autocomplete="off" required autofocus/>
                                        <span class="input-group-text bg--base"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="cardExpiry" class="form--label">@lang('Expiration Date')</label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardExpiry" autocomplete="off" required/>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="cardCVC" class="form--label">@lang('CVC Code')</label>
                                    <input type="tel" class="form-control form--control input-sz custom-input" name="cardCVC" autocomplete="off" required/>
                                </div>
                            </div>
                            <br>
                            <button class="cmn--btn w-100 text-center d-block" type="submit">
                                @lang('PAY NOW')
                            </button>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script src="{{ asset('assets/global/js/card.js') }}"></script>

    <script>
        (function ($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
@endpush
