@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    /* Seu arquivo CSS personalizado */
    .payment-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        padding-top: 20px; /* Ajuste o espaçamento do topo conforme necessário */
    }

    #pixCodeContainer {
        /* Outros estilos existentes aqui */
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1; /* Coloca o código PIX abaixo do formulário */
        display: none; /* Inicialmente oculta o código PIX */
        background-color: #050914; /* Cor de fundo desejada */
        padding: 20px; /* Espaçamento interno */
        border-radius: 10px; /* Borda arredondada */
        width: 400px; /* Ajuste a largura conforme necessário */
        max-height: 80%; /* Limite a altura para evitar uma altura excessiva */
        overflow-y: auto; /* Adicione uma barra de rolagem vertical caso necessário */
    }

    #pixQRCodeDiv {
        max-width: 200px;
        margin: 0 auto;
    }

    #pixQRCode {
        max-width: 100%;
        height: auto;
        display: none; /* Inicialmente oculta a imagem do QR Code */
    }

    #pixCode {
       font-size: 13px;
        color: #fff;
        text-align: center; /* Centralizado o texto */
    }

    #copyPixCode {
        margin-top: 10px;
        background-color: #4CAF50;
        color: #FFF;
        border: none;
        cursor: pointer;
        display: block; /* Para centralizar o botão */
        margin: 0 auto; /* Centralizado horizontalmente */
    }

    /* Estilo para o texto de aviso RGB animado */
    #textoaviso {
        font-size: 20px;
        text-align: center;
        margin-top: 20px;
        animation: colorChange 3s infinite;
    }
    
    @keyframes colorChange {
        0% { color: red; }
        25% { color: green; }
        50% { color: blue; }
        75% { color: yellow; }
        100% { color: red; }
    }

    #atualizarPagina {
        text-align: center;
    }
</style>

<div class="payment-section">
    <div id="pixCodeContainer">
        <div id="pixQRCodeDiv">
            <img id="pixQRCode" src="" alt="QR Code PIX">
        </div>
        <p id="textoaviso">@lang('PAGUE O PIX ABAIXO')</p>
        <p id="atualizarPagina">@lang('Após o pagamento, atualize esta página.')</p>
        <br>
        <br>
        <p id="pixCode" style="word-break: break-all;"></p>
        <button id="copyPixCode" class="btn btn--md btn--success">@lang('Copiar')</button>
    </div>
</div>

<script>
    // Função para exibir código Pix e URL Pix
    function showPixCode(pixCode, pixQRCodeURL) {
        // Se a URL Pix estiver disponível, exibe a imagem
        if (pixQRCodeURL) {
            document.getElementById('pixQRCode').src = pixQRCodeURL;
            document.getElementById('pixQRCode').style.display = 'block';
        }

        // Exibe o código Pix e outros elementos
        document.getElementById('pixCode').textContent = pixCode;
        document.getElementById('pixCodeContainer').style.display = 'block';

        // Adiciona evento de clique para copiar o código Pix
        document.getElementById('copyPixCode').addEventListener('click', function () {
            var pixCode = document.getElementById('pixCode').textContent;
            copyToClipboard(pixCode);
        });
    }

    // Função para copiar texto para a área de transferência
    function copyToClipboard(text) {
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert('@lang('Código copiado. \nVá até seu banco, selecione Pix e depois selecione a opção Pagar com Pix copia e cola e cole o código. \nFinalizando o pagamento Atualize esta Pagina')');
    }

    // Exemplo de chamada da função showPixCode com valores de exemplo
    showPixCode('{{$data->pixCode}}', '{{$data->urlpix}}');
</script>
@endsection
