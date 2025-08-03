@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="profile-wrapper bg--section">
        <div class="profile-user mb-lg-0">
            <div class="thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('user')">
            </div>
            <div class="content">
                <h6 class="title">@lang('Name'): {{ __($user->fullname) }}</h6>
                <span class="subtitle">@lang('Username'): {{ __($user->username) }}</span>
            </div>
            <div class="remove-image">
                <i class="las la-times"></i>
            </div>
        </div>
        <div class="profile-form-area">
            <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form--group col-md-6">
                    <label class="form--label" for="InputFirstname">@lang('First Name')</label>
                    <input type="text" class="form-control form--control" id="InputFirstname" name="firstname"
                     value="{{$user->firstname}}" minlength="3">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="lastname">@lang('Last Name')</label>
                    <input type="text" class="form-control form--control" id="lastname" name="lastname" value="{{$user->lastname}}" required>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="email">@lang('E-mail Address')</label>
                    <input class="form-control form--control" id="email" value="{{$user->email}}" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="phone">@lang('Mobile Number')</label>
                    <input class="form-control form--control" id="phone" value="{{$user->mobile}}" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="address">@lang('Address')</label>
                    <input type="text" class="form-control form--control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="state">@lang('State')</label>
                    <input type="text" class="form-control form--control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="zip">@lang('Zip Code')</label>
                    <input type="text" class="form-control form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="city">@lang('City')</label>
                    <input type="text" class="form-control form--control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="country">@lang('Country')</label>
                    <input class="form-control form--control" id="country" value="{{@$user->address->country}}" disabled>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="profile-image">Alterar foto do perfil</label>
                    <input type="file" class="form-control form--control" name="image" id="profile-image" accept="image/*">
                </div>
                <div class="form--group w-100 col-md-6 mb-0 text-end">
                    <button type="submit" class="cmn--btn">@lang('Update Profile')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('style-lib')
    <link href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
@endpush
