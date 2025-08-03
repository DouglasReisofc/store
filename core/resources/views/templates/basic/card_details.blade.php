@extends($extends)

@section('content')
<style>
    @keyframes colorChange {
        0% { color: rgb(255, 0, 0); }
        50% { color: rgb(0, 255, 0); }
        100% { color: rgb(255, 0, 0); }
    }
</style>

<div class="{{ Auth::user() ? '' : 'pt-80 pb-80' }}">
    <div class="deposit-preview bg--section">
        <div class="deposit-thumb">
            <img src="{{ getImage(imagePath()['sub_category']['path'].'/'.$subCategory->image) }}" alt="payment">
        </div>
        <div class="deposit-content text-center">
            <form action="{{ route('user.card.purchase') }}" method="post" class="form">
                @csrf
                <input type="hidden" required name="id" value="{{ $subCategory->id }}">
                <ul>
                    <li>
                        @lang('Category'): <span class="text--success">
                            {{ __($subCategory->category->name) }}
                        </span>
                    </li>
                    <li>
                        @lang('Sub Category'): <span class="text--success">
                            {{ __($subCategory->name) }}
                        </span>
                    </li>
                    <li>
                        @lang('Price'): <span class="text--success">
                            {{ showAmount($subCategory->price) }} {{ __($general->cur_text) }}
                        </span>
                    </li>
                    <li>
                        @lang('Available'): <span class="text--success">
                          @php
$totalDisponiveis = 0;
@endphp

@foreach ($subCategory->card as $singleCard)
    {{-- Adiciona 1 para venda individual --}}
    @if ($singleCard->user_id == 0 && $singleCard->revender == 0)
        @php $totalDisponiveis++; @endphp
    @endif

    {{-- Adiciona ao total os disponíveis para revenda --}}
    @if ($singleCard->revender == 1)
        @php $totalDisponiveis += intval($singleCard->disponivel); @endphp
    @endif
@endforeach

{{-- Exibindo o resultado final --}}
{{ $totalDisponiveis }}
                        </span>
                    </li>
                    <li>
                        <span class="d-block mb-2">@lang('Quantity'):</span>
                        <div class="quantity quantity-wrapper">
                            <input type="number" name="quantity" value="1" min="1" class="text--base text-center bg-transparent border-0">
                        </div>
                    </li>
                </ul>
                <input type="hidden" name="client_ip" id="client_ip" value="">
                <button type="submit" class="cmn--btn w-100 justify-content-center mt-3">@lang('Comprar')</button>
            </form>
            <div class="sub-category-details mt-5 text-center">
                <h5 class="mb-2 text-sm" style="color: rgb(255, 0, 0); animation: colorChange 8s infinite; margin-bottom: 1.5rem;">@lang('DESCRIÇÃO DO ANÚNCIO')</h5>
                <br>
                <p class="text-sm" style="font-size: 0.8rem;">{!! nl2br(e($subCategory->detalhes)) !!}</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cmn--modal" id="confirm" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">@lang('Confirmation')</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            @lang('Você tem certeza que deseja comprar este item ?')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
            <div class="prevent-double-click">
                <button type="submit" class="btn btn--success confirmBtn">@lang('Confirm')</button>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>

    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="fa fa-plus"></i></div><div class="quantity-button quantity-down"><i class="fa fa-minus"></i></div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function () {
        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.on('click', function () {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.on('click', function () {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });
    });

    $('.form').on('submit', function(e){
        e.preventDefault();
        $('#confirm').modal('show');

        $('.confirmBtn').on('click', function(){
            e.currentTarget.submit();
        });
    });
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('client_ip').value = data.ip;
        })
        .catch(err => {
            console.error('Erro ao obter IP:', err);
        });
    </script>
@endpush