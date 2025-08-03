@php
    $header = getContent('header.content', true);
    $socialMedias = getContent('social_icon.element');
@endphp
<!-- Header Section -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <ul class="header-top-area">
                    <li class="me-auto">
                        <ul class="social">
                            @foreach($socialMedias as $media)
                                <li>
                                    <a href="{{ $media->data_values->url }}" target="_blank">
                                        @php
                                            echo $media->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <!--<li class="mail">
                        <i class="las la-phone-alt"></i>
                        <a href="Tel:{{ @$header->data_values->phone }}">{{ @$header->data_values->phone }}</a>
                    </li>
                    <li class="mail">
                        <i class="las la-envelope"></i>
                        <a href="Mailto:{{ @$header->data_values->email }}">{{ @$header->data_values->email }}</a>
                    </li>-->
                </ul>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="" alt="@lang('logo')">
                        </a>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                        </li>
                        <li>
                            <a href="#0">@lang('Deposit')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('user.deposit') }}">@lang('Deposit')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.redeemGiftcard') }}">@lang('Resgate')</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('card') }}">@lang('Cards')</a>
                        </li>
                        <li>
                            <a href="{{ route('user.card') }}">@lang('My Cards')</a>
                        </li>
                        <li>
                            <a href="#0">@lang('Support')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('ticket.open') }}">@lang('New Ticket')</a>
                                </li>
                                <li>
                                    <a href="{{ route('ticket') }}">@lang('My Tickets')</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#0">@lang('Account')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('user.profile.setting') }}">@lang('Profile')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.twofactor') }}">@lang('Two Factor')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.trx.log') }}">@lang('Transaction Logs')</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                                </li>
                            </ul>
                        </li>
                        <li class="d-md-none">
                            <a href="{{ route('user.logout') }}" class="cmn--btn py-0 m-1">@lang('Logout')</a>
                        </li>
                    </ul>
                    <div class="select-bar">
                        <select class="langSel">
                            @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>
                                    {{ __($item->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="right-area d-none d-md-flex">
                        <a href="{{ route('user.logout') }}" class="cmn--btn py-0 m-1">@lang('Logout')</a>
                    </div>
                    <div class="header-bar ms-3 me-0">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section -->
