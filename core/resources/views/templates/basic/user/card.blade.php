@extends($activeTemplate.'layouts.master')
@section('content')

<div class="container">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead class="thead-dark">
                        <tr>
                            <th>@lang('Produto')</th>
                            <th>@lang('Vencimento')</th>
                            <th>@lang('Trx')</th>
                            <th>@lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $index => $data)
                        <tr>
                            <td data-label="@lang('Produto')">
                                {{ __($data->subCategory->name) }}
                            </td>
                            <td data-label="@lang('Vencimento')">
                                @php
                                    // Certifique-se que card_validity é uma instância de Carbon ou converta usando Carbon::parse()
                                    $hoje = \Carbon\Carbon::now();
                                    $dataVencimento = \Carbon\Carbon::parse($data->card_validity);
                                    $diasRestantes = $hoje->diffInDays($dataVencimento, false);
                                    $isExpired = $diasRestantes < 0;
                                    $isCloseToExpire = $diasRestantes >= 0 && $diasRestantes <= 5;
                                @endphp
                                <span class="{{ $isCloseToExpire || $isExpired ? 'text-danger' : 'text-primary' }}">
                                    {{ $isExpired ? '0' : $diasRestantes }} @lang('dias')
                                </span>
                            </td>
                            <td data-label="@lang('Trx')">
                                {{ $data->trx }}
                            </td>
                            <td data-label="@lang('Details')">
                                <a href="{{ route('user.card.details', $data->id) }}" class="bg--primary text-white btn-sm">
                                    <i class="fas fa-folder-open"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">@lang('Data Not Found')!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cards->count() > 0)
                {{ $cards->links() }}
            @endif

        </div>
    </div>
</div>

@endsection
