@extends($activeTemplate.'layouts.master')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="redeem-giftcard-container bg--section">
                <h6 class="title">@lang('Resgatar Saldo')</h6>
                <div class="money-penguin-gif"></div> <!-- GIF de erro -->
                <form method="POST" action="{{ route('user.redeemGiftcard.post') }}">
                    @csrf
                    <div class="form-group">
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="@lang('Código de Resgate')" value="{{ old('code') }}" required autocomplete="code" autofocus>
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="cmn--btn">
                        @lang('Resgatar')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal para mensagens --}}
@if(session('success') || session('error'))
    <div id="messageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ session('success') ? 'Success' : 'Error' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalButton">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
@if(session('success'))
    <div class="success-gif"></div> <!-- GIF de sucesso -->
    <p>{{ session('success') }}</p>
    <p>Valor do Resgate: {{ session('giftcard_amount') }}</p>
    <p>Seu saldo após o resgate: {{ session('balance') }}</p>
@else
    <div class="error-gif"></div> <!-- GIF de erro -->
    <p>{{ session('error') }}</p>
@endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalFooterButton">@lang('Close')</button> <!-- Corrigido aqui -->
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            // Abra o modal quando a página carregar
            $('#messageModal').modal('show');

            // Feche o modal quando o botão "Close" no canto superior for clicado
            $('#closeModalButton').on('click', function() {
                $('#messageModal').modal('hide');
            });

            // Feche o modal quando o botão na parte de baixo for clicado
            $('#closeModalFooterButton').on('click', function() {
                $('#messageModal').modal('hide');
            });
        });
    </script>
    @endpush
@endif

@endsection
