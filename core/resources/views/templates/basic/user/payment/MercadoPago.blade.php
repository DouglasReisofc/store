@extends($activeTemplate.'layouts.master')

@section('content')
<div class="modal fade show d-flex align-items-center justify-content-center" id="mercadoPagoModal" tabindex="-1" aria-labelledby="mercadoPagoModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="mercadoPagoModalLabel">Finalize seu pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='{{ route('user.home') }}'"></button>
            </div>
            <div class="modal-body text-center">
                <div class="container">
                    <p id="textoaviso" class="mb-2">@lang('PAGUE O PIX ABAIXO')</p>
                    <img id="mercadoPagoQRCode" src="data:image/png;base64,{{ $data->base64 }}" class="img-fluid mb-2" alt="QR Code" style="max-width: 80%; height: auto;">
                    <div id="pixCodeContainer" class="mb-2">
                        <p id="mercadoPagoCode" class="fs-6" style="overflow-y: auto; max-height: 80px; margin-bottom: 0;">{{ $data->pixCode }}</p>
                    </div>
                    <div class="alert alert-info mt-2 mb-2">
                        Para pagar, utilize o código acima em seu aplicativo de banco ou app do Mercado Pago. Você pode copiá-lo clicando no botão abaixo.
                    </div>
                    <a id="copyMercadoPagoCode" class="btn btn-custom">@lang('Copiar Pix')</a>
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
    $('#mercadoPagoModal').modal('show');
    checkPaymentStatus('{{ $data->paymentId }}');
}

function showPixCode(pixCode, pixQRCodeBase64) {
    document.getElementById('mercadoPagoQRCode').src = 'data:image/png;base64,' + pixQRCodeBase64;
    document.getElementById('mercadoPagoCode').textContent = pixCode;
}

document.getElementById('copyMercadoPagoCode').addEventListener('click', function () {
    var mercadoPagoCode = document.getElementById('mercadoPagoCode').textContent;
    copyToClipboard(mercadoPagoCode);
});

function copyToClipboard(text) {
    var tempInput = document.createElement("textarea");
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    alert('Código copiado: ' + text);
}

function checkPaymentStatus(paymentId) {
    const checkStatus = () => {
        const url = '{{ route('user.deposit.status', ['trx' => ':trxId']) }}'.replace(':trxId', paymentId);
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === 1) {
                clearInterval(interval);
                // Fechando o modal de pagamento antes de abrir o de confirmação
                $('#mercadoPagoModal').modal('hide');
                // Aguarda um momento para garantir que o modal de pagamento seja fechado
                setTimeout(function() {
                    $('#paymentConfirmationModal').modal('show');
                }, 500); // Ajuste este tempo conforme necessário
            }
        })
        .catch(error => console.error('Error checking payment status:', error));
    };

    const interval = setInterval(checkStatus, 5000); // Verifica o status a cada 5 segundos.
}
</script>

@endsection
