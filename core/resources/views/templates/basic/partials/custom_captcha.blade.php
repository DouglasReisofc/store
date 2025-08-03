@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="col-md-12 captha">
        @php echo $captcha @endphp
    </div>
    <div class="col-md-12">
        <input type="text" name="captcha" class="form-control form--control">
    </div>
@endif

@push('style')
<style>
    .captha div{
        width: 100% !important;
    }
</style>
@endpush
