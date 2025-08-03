@extends($activeTemplate.'layouts.master')

@section('content')
<div class="container">
    <div class="row gy-4 justify-content-center">
        @if($cardDetail->image)
            <div class="col-lg-4">
                <div class="card custom--card h-100">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Card Image')</h4>
                    </div>
                    <div class="card-body">
                        <div class="two-factor-content">
                            <div class="two-factor-scan text-center my-4">
                                <img src="{{ getImage(imagePath()['vencimento']['path'].'/'.$cardDetail->image, imagePath()['vencimento']['size']) }}" alt="@lang('Image')" class="img-fluid" width="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-8">
            <div class="card custom--card h-100">
                <div class="card-header">
                    <h4 class="card-title">@lang('Card Details')</h4>
                </div>
                <div class="card-body">
                    <div class="two-factor-content">
                        <h6 class="subtitle text-center">
                            @lang('Category'): {{ __($cardDetail->subCategory->category->name) }}
                            <br>
                            @lang('Sub Category'): {{ __($cardDetail->subCategory->name) }}
                        </h6>
                        <p class="two__fact__text" id="cardDetails">
                            {!! nl2br(__($cardDetail->details)) !!}
                        </p>
                        <button onclick="copyToClipboard('#cardDetails')" class="btn btn-primary">
                            <i class="fa fa-copy"></i> @lang('Copiar')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(element) {
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    alert("@lang('Copiado para area de transferência')"); // Ou utilize uma notificação mais sofisticada se preferir
}
</script>

@endsection
