@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Subcategoria')</th>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Comprador')</th>
                                    <th>@lang('Dias Restantes')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vencimentos as $vencimento)
                                <tr>
                                    <td data-label="@lang('Subcategoria')">{{ $vencimento->subCategory->name ?? 'N/A' }}</td>
                                    <td data-label="@lang('ID')">{{ $vencimento->trx ?? __('N/A') }}</td>
                                    <td data-label="@lang('Comprador')">{{ optional($vencimento->user)->email ?? 'N/A' }}</td>
                                    <td data-label="@lang('Dias Restantes')">
                                        @php
                                            $hoje = \Carbon\Carbon::now();
                                            $diasRestantes = $hoje->diffInDays($vencimento->card_validity, false);
                                        @endphp
                                        @if($diasRestantes > 0)
                                            {{ $diasRestantes }} @lang('dias')
                                        @else
                                            @lang('Vencido')
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">@lang('Nenhuma venda encontrada.')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
