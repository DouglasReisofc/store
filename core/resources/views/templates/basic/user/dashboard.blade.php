@extends($activeTemplate.'layouts.master')
@section('content')
<!-- Dashboard -->
<div class="container">
    <div class="pb-80">
        <div class="row justify-content-center g-4">
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-wallet"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <h6 class="title">@lang('Olá') {{ $user->username }} <br>@lang('seu saldo Atual é de') </h6>
<h4 class="title">{{ $general->cur_sym }} {{ number_format($user->balance, 2) }}</h4>
                        </div>
                        <br>
                        <a href="{{ route('user.deposit') }}" class="btn btn-custom"><font color="#fff">Adicionar Saldo</font></a>
                        <!--<a href="{{ route('user.redeemGiftcard') }}" class="btn btn-custom"><font color="#fff">Resgatar</font></a>-->
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="fas fa-cart-arrow-down"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="{{ route('user.card') }}">
                            <h6 class="title">@lang('total de contas compradas') </h6>
                            <br>
                                <h3 class="title rafcounter" data-counter-end="{{ $countCard }}">0</h3>
                            </a>
                        </div>
                        <br>
                        <a href="{{ route('card') }}" class="btn btn-custom"><font color="#fff">@lang('Comprar Conta')</font></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-exchange-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="{{ route('user.trx.log') }}">
                            <h6 class="title">@lang('Você tem Um histórico de') </h6>
                            <br>
                                <h3 class="title rafcounter" data-counter-end="{{ $countTrx }}">0</h3>
                            </a>
                        </div>
                        <a href="{{ route('user.trx.log') }}"><h6 class="title">@lang('Transaction')</a></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-ticket-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="{{ route('ticket') }}">
                    <h6 class="title">@lang('Ticket') </h6>
                    <br>
                                <h3 class="title rafcounter" data-counter-end="{{ $countTicket }}">0</h3>
                            </a>
                        </div>
                        <br>
                    <a href="{{ route('ticket.open')}}" class="btn btn-custom"><font color="#fff">@lang('Solicitar suporte')</font></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="title mb-3">@lang('Latest Transaction Logs')</h5>
    <table class="table cmn--table">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Trx')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Post Balance')</th>
                <th>@lang('Details')</th>
            </tr>
        </thead>
        <tbody>
        @forelse($latestTrxs as $trx)
            <tr>
                <td data-label="@lang('Date')">
                   {{ showDateTime($trx->created_at) }}
                </td>
                <td data-label="@lang('Trx')">
                   {{ $trx->trx }}
                </td>
                <td data-label="@lang('Amount')">
                    <strong>
                        {{ showAmount($trx->amount, 2) }}
                        {{ __($general->cur_text) }}
                    </strong>
                </td>
                <td data-label="@lang('Post Balance')">
                    <strong>
                        {{ showAmount($trx->post_balance, 2) }}
                        {{ __($general->cur_text) }}
                    </strong>
                </td>
                <td data-label="@lang('Details')">
                    {{ __($trx->details) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%">@lang('Data Not Found')</td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>
<!-- Dashboard -->
@endsection
