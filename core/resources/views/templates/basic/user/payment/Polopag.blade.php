@extends($activeTemplate.'layouts.master')

@section('content')
<div class="modal fade show d-flex align-items-center justify-content-center" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="qrCodeModalLabel">Finalize seu pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="container">
                    <p id="textoaviso" class="mb-2">@lang('PAGUE O PIX ABAIXO')</p>
                    <img id="pixQRCode" src="data:image/png;base64,{{ $data->data->base64 }}" class="img-fluid mb-2" alt="QR Code" style="max-width: 80%; height: auto;">
                    <div id="pixCodeContainer" class="mb-2">
                        <p id="pixCode" class="fs-6" style="overflow-y: auto; max-height: 80px; margin-bottom: 0;">{{ $data->data->pixCode }}</p>
                    </div>
                    <div class="alert alert-info mt-2 mb-2">
                        Para pagar, utilize o código acima em seu aplicativo de banco. Você pode copiá-lo clicando no botão abaixo.
                    </div>
                    <a id="copyPixCode" class="btn btn-custom" data-pixcode="{{ $data->data->pixCode }}">@lang('Copiar Pix')</a>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Pagamento -->
<div class="modal fade" id="paymentConfirmationModal" tabindex="-1" aria-labelledby="paymentConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentConfirmationModalLabel">Pagamento Confirmado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="success-gif"></div>
        Seu pagamento foi confirmado com sucesso. Obrigado por sua compra!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.href='{{ route('user.home') }}';">Ok</button>
      </div>
    </div>
  </div>
</div>


<script>
    window.onload = function() {
        $('#qrCodeModal').modal('show');
    }

    // Atualizado para usar o valor diretamente do atributo data-pixcode
    document.getElementById('copyPixCode').addEventListener('click', function () {
        var pixCode = this.getAttribute('data-pixcode');
        navigator.clipboard.writeText(pixCode).then(function() {
            alert('Pix Code copiado: ' + pixCode);
        }, function(err) {
            console.error('Não foi possível copiar o Pix Code: ', err);
        });
    });

    function checkPaymentStatus() {
        const paymentId = '{{ $data->data->paymentId }}';
        const checkStatus = () => {
            const url = new URL('{{ route('user.deposit.status', ['trx' => ':trxId']) }}'.replace(':trxId', paymentId));
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 1) {
                        console.log("Pagamento confirmado");
                        clearInterval(interval);
                        $('#qrCodeModal').modal('hide');
                        $('#paymentConfirmationModal').modal('show');
                    }
                })
                .catch(error => console.error('Erro ao verificar o status do pagamento:', error));
        };

        checkStatus();
        const interval = setInterval(checkStatus, 5000);
    }

    checkPaymentStatus();
</script>
@endsection

