@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    /* Seu arquivo CSS personalizado */
    .payment-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding-top: 20px;
    }

    #modalContainer {
    display: none;
    position: fixed;
    top: 60%; /* Ajuste o valor aqui para descer ou subir o modal */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    background-color: #050914;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 300px; /* Mantenha a largura máxima se desejar */
    overflow-y: auto;
    border: 2px solid #4CAF50;
    text-align: center;
}



    #pixQRCode {
        max-width: 100%;
        height: auto;
        border: 1px solid #4CAF50;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #pixCode {
        color: #fff;
        font-size: 12px;
        word-break: break-all;
        margin-bottom: 20px; /* Aumento do espaçamento entre o pixCode e a imagem do QR */
    }

    #copyPixCode {
        background-color: #4CAF50;
        color: #FFF;
        border: none;
        cursor: pointer;
        padding: 10px 20px;
        box-sizing: border-box;
        border-radius: 20px;
        font-size: 14px;
    }

    #closeModal {
        background-color: #f44336;
        color: #FFF;
        border: none;
        cursor: pointer;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 5px;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #closeModal:hover {
        background-color: #d32f2f;
    }
</style>

<div class="payment-section">
    <div id="modalContainer">
        <span id="closeModal">&#10006;</span>
        <img id="pixQRCode" src="" alt="QR Code PIX">
        <p id="pixCode"></p>
        <button id="copyPixCode" class="btn btn--md btn--success">@lang('Copiar')</button>
    </div>
</div>

<script>
    function showPixCode(pixCode, qrCodeImageUrl) {
        document.getElementById('pixQRCode').src = qrCodeImageUrl;
        document.getElementById('pixCode').textContent = pixCode;
        document.getElementById('modalContainer').style.display = 'block';

        document.getElementById('copyPixCode').addEventListener('click', function () {
            var pixCode = document.getElementById('pixCode').textContent;
            copyToClipboard(pixCode);
        });

        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('modalContainer').style.display = 'none';
            location.reload();
        });
    }

    function copyToClipboard(text) {
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert('@lang('Código copiado. \nVá até seu banco, selecione Pix e depois selecione a opção Pagar com Pix copia e cola e cole o código. \nFinalizando o pagamento Atualize esta Pagina')');
    }

    // Ajuste a chamada da função showPixCode conforme as variáveis passadas para a view
    showPixCode('{{$data->pixCode}}', '{{$data->qrCodeImageUrl}}');
</script>

@endsection
