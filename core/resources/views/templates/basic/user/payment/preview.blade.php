@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    .deposit-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 2px solid #ddd;
        padding: -300px;
        border-radius: 15px;
        margin: -100px 0 300%; /* Ajuste este valor conforme necessário */
    }

    #deposit-thumb {
        max-width: 100%;
        height: auto;
        overflow: hidden;
        border-radius: 50%;
        margin-bottom: 15px; /* Ajuste este valor conforme necessário */
    }

    .deposit-thumb img {
    max-width: 100%;
        height: auto;
        height: auto; /* Ajuste para altura automática para manter a proporção */
        object-fit: contain; /* Alterado para 'contain' para ajustar a imagem mantendo a proporção */
        border-radius: 0%; /* Para garantir que a imagem seja circular */
    }

    .deposit-content {
        margin-top: 15px;
    }

    .deposit-content ul {
        list-style: none;
        padding: 0;
    }

    .deposit-content li {
        margin-bottom: 10px;
    }

    .mt-3 {
        margin-top: 15px;
    }
</style>

<!-- Restante do seu código -->

<div class="container">
    <div class="row justify-content-center g-4">
        <div class="col-xxl-6 col-xl-8 col-lg-6">
            <div class="deposit-item">
                <div class="deposit-thumb">
                    <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('image')" class="custom-image">
                </div>
                <div class="deposit-content fs-sm">
                    <ul>
                        <li>
                            @lang('Valor'):
                            <strong>{{showAmount($data->amount)}} </strong> {{__($general->cur_text)}}
                        </li>
                        <li>
                            @lang('Taxa'):
                            <strong>{{showAmount($data->charge)}}</strong> {{__($general->cur_text)}}
                        </li>
                        <li>
                            @lang('A pagar'):
                            <strong> {{showAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}
                        </li>
                        <li>
                            @lang('Taxa de conversão'):
                            <strong>1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</strong>
                        </li>
                        <li>
                            @lang('Valor Final') {{$data->baseCurrency()}}:
                            <strong>{{showAmount($data->final_amo)}}</strong>
                        </li>
                    </ul>
                    <div class="mt-30">
                        @if( 1000 >$data->method_code)
                            <a href="{{route('user.deposit.confirm')}}" class="cmn--btn w-100 justify-content-center">
                                @lang('Pay Now')
                            </a>
                        @else
                            <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn w-100 justify-content-center">
                                @lang('Pay Now')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
