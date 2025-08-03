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
    }

    #payButton {
        margin-top: 10px;
        background-color: #4CAF50;
        color: #FFF;
        border: none;
        cursor: pointer;
        display: block; /* Para centralizar o botão */
        margin: 0 auto; /* Centralizado horizontalmente */
        text-decoration: none; /* Removido sublinhado padrão de links */
        padding: 10px 20px;
        border-radius: 5px;
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

    /* Adicionado estilo para a animação do relógio na data de expiração */
    #formattedDataExpiracao {
        font-size: 18px;
        color: #fff;
    }

    /* Adicionado estilo para o valor do pagamento */
    #formattedValorPagamento {
        font-size: 18px;
        color: #fff;
    }
</style>

<div class="payment-section">
    <div id="pixCodeContainer">
        <div id="pixQRCodeDiv">
            <img id="pixQRCode" src="" alt="QR Code PIX">
        </div>
        <p id="textoaviso">@lang('PAGUE COM PICPAY')</p>
        <p id="atualizarPagina">@lang('Após o pagamento, atualize esta página.')</p>
        <br>
        <!-- Adicionado texto para Valor do pagamento -->
        <p id="valorPagamento">@lang('Valor do pagamento'): <span id="formattedValorPagamento"></span></p>
        <!-- Adicionado texto para Data de expiração -->
        <p id="dataExpiracao">@lang('Data de expiração'): <span id="formattedDataExpiracao"></span></p>
        <br>
        <p id="pixCode" style="word-break: break-all;"></p>
        <!-- Alteração: Adicionado ID ao botão e href com javascript -->
        <a id="payButton" class="btn btn--md btn--success" href="javascript:void(0)">@lang('Pagar')</a>
    </div>
</div>

<script>
    function showPixCode(pixCode, pixQRCodeBase64, valor, dataExpiracao) {
        document.getElementById('pixQRCode').src = '{{$data->base64}}';
        document.getElementById('pixCodeContainer').style.display = 'block';

        // Adição: Formatar e exibir a data de expiração
        var formattedDataExpiracao = new Date(dataExpiracao).getTime();
        document.getElementById('formattedDataExpiracao').textContent = formattedDataExpiracao;

        // Adição: Formatar e exibir o valor do pagamento
        var formattedValorPagamento = parseFloat(valor).toFixed(2);
        document.getElementById('formattedValorPagamento').textContent = formattedValorPagamento;

        // Adição: Adicionado evento de clique ao botão
        document.getElementById('payButton').addEventListener('click', function () {
            // Adição: Redireciona para a URL de pagamento
            window.location.href = pixCode;
        });

        // Adição: Animar o relógio na data de expiração
        animateExpiryDate(formattedDataExpiracao);
    }

    function animateExpiryDate(expiryTimestamp) {
        setInterval(function () {
            var now = new Date().getTime();
            var distance = expiryTimestamp - now;

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('formattedDataExpiracao').textContent = minutes + 'm ' + seconds + 's';
        }, 1000);
    }

    // Exemplo de chamada da função showPixCode com valores de exemplo
    showPixCode('{{$data->pixCode}}', '{{$data->base64}}', '{{$data->valor}}', '{{$data->dataExpiracao}}');
</script>
@endsection
