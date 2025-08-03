@extends($activeTemplate.'layouts.frontend')

@php
    $contact = getContent('contact_us.content', true);
@endphp

@section('content')
<!-- Contact Section Starts Here -->
    <section class="contact-section pt-120 pb-60">
        <div class="container">
            <div class="d-flex flex-wrap">
                <div class="contact__wrapper__1 bg--section">
                    <div class="section__header mb-0">
                        <h3 class="section__title">@lang('Send Us Message Now')</h3>
                        <div class="section__shape">
                            <div class="progress-bar progress-bar-striped bg--base progress-bar-animated w-100"></div>
                        </div>
                    </div>
                    <form class="contact-form row g-4" method="post" action="">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name" class="form--label">@lang('Name')</label>
                                <input name="name" id="name" type="text" class="form--control form-control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @endif required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="form--label">@lang('Email')</label>
                                <input name="email" id="email" type="text" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" @if(auth()->user()) readonly @endif required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="subject" class="form--label">@lang('Subject')</label>
                                <input name="subject" id="subject" type="text" class="form-control form--control" value="{{old('subject')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message" class="form--label">@lang('Message')</label>
                                <textarea name="message" id="message" wrap="off" class="form-control form--control">{{old('message')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                        @php echo loadReCaptcha() @endphp
                    </div>

                    @include($activeTemplate.'partials.custom_captcha')
                        <div class="col-sm-12">
                            <div class="form-group m-0 pt-3">
                                <button type="submit" class="cmn--btn">@lang('Send Message')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="contact__wrapper__2">
                    <div class="contact__wrapper__2_inner bg--section p-4 p-xxl-5 h-100">
                        <div class="maps rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Contact Section Ends Here -->

<!-- Branch Section Starts Here -->
    <section class="contact-section pt-60 pb-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-phone"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title">@lang('Phone')</h6>
                            <ul class="contact__info">
                                <li>
                                    <a href="Tel:{{ @$contact->data_values->phone }}">
                                        {{ @$contact->data_values->phone }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-envelope"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title">@lang('Email')</h6>
                            <ul class="contact__info">
                                <li>
                                    <a href="mailto:{{ @$contact->data_values->email }}">
                                        {{ @$contact->data_values->email }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item bg--section">
                        <div class="contact__icon">
                            <i class="las la-map-marker"></i>
                        </div>
                        <div class="contact__body">
                            <h6 class="contact__title">@lang('Address')</h6>
                            <ul class="contact__info">
                                <li>
                                    <a href="javascript:void(0)">
                                        {{ __(@$contact->data_values->address) }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Brance Section Ends Here -->
@endsection

@push('script')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCo_pcAdFNbTDCAvMwAD19oRTuEmb9M50c"></script>
<script src="{{ asset($activeTemplateTrue.'js/map.js') }}"></script>

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
    "use strict";

    var mapOptions = {
        center: new google.maps.LatLng({{ @$contact->data_values->map_latitude }}, {{ @$contact->data_values->map_longitude }}),
        zoom: 10,
        styles: styleArray,
        scrollwheel: false,
        backgroundColor: '#e5ecff',
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
        mapOptions);
        var myLatlng = new google.maps.LatLng({{ @$contact->data_values->map_latitude }}, {{ @$contact->data_values->map_longitude }});
        var focusplace = {lat: 55.864237, lng: -4.251806};
        var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: {
            url: "{{ asset($activeTemplateTrue.'images/map-marker.png') }}"
        }
    })
</script>

@endpush
