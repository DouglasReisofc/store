@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.sms.template.setting') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="mb-4">@lang('Mensagem método de envio')</label>
                                <select name="sms_method" class="form-control" >
                                <option value="infobip" @if(@$general->sms_config->name == 'infobip') selected @endif>@lang('Easyzap')</option>
                                    <option value="clickatell" @if(@$general->sms_config->name == 'clickatell') selected @endif>@lang('Whatsapp api')</option>
                                    <option value="messageBird" @if(@$general->sms_config->name == 'messageBird') selected @endif>@lang('Message Bird')</option>
                                    <option value="nexmo" @if(@$general->sms_config->name == 'nexmo') selected @endif>@lang('Nexmo')</option>
                                    <option value="smsBroadcast" @if(@$general->sms_config->name == 'smsBroadcast') selected @endif>@lang('Sms Broadcast')</option>
                                    <option value="twilio" @if(@$general->sms_config->name == 'twilio') selected @endif>@lang('Twilio')</option>
                                    <option value="textMagic" @if(@$general->sms_config->name == 'textMagic') selected @endif>@lang('Text Magic')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <h6 class="mb-4">&nbsp;</h6>
                                <button type="button" data-target="#testSMSModal" data-toggle="modal" class="btn btn--info">@lang('Enviar Teste Api')</button>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="clickatell">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('whatsapp Configuração')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Chave de autorização') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="clickatell_api_key" value="{{ @$general->sms_config->clickatell_api_key }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="infobip">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Configuração Easyzap')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('appkey') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('appkey')" name="infobip_username" value="{{ @$general->sms_config->infobip_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('authkey') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('authkey')" name="infobip_password" value="{{ @$general->sms_config->infobip_password }}"/>
                            </div>
                            <h7 class="mb-2">@lang('Para este método funcionar você deve pegar suas credenciais de api com o admin')</h6>
                            <div class="form-group col-md-12">
                                <button type="button" id="infobipTestButton" class="btn btn--info">@lang('Escanear')</button>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="messageBird">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Message Bird Configuration')</h7>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Api Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="message_bird_api_key" value="{{ @$general->sms_config->message_bird_api_key }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="nexmo">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Nexmo Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Api Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="nexmo_api_key" value="{{ @$general->sms_config->nexmo_api_key }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Api Secret') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Secret')" name="nexmo_api_secret" value="{{ @$general->sms_config->nexmo_api_secret }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="smsBroadcast">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Sms Broadcast Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Username') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Username')" name="sms_broadcast_username" value="{{ @$general->sms_config->sms_broadcast_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Password') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Password')" name="sms_broadcast_password" value="{{ @$general->sms_config->sms_broadcast_password }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="twilio">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Twilio Configuration')</h6>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Account SID') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Account SID')" name="account_sid" value="{{ @$general->sms_config->account_sid }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Auth Token') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Auth Token')" name="auth_token" value="{{ @$general->sms_config->auth_token }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('From Number') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('From Number')" name="from" value="{{ @$general->sms_config->from }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="textMagic">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Text Magic Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Username') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Username')" name="text_magic_username" value="{{ @$general->sms_config->text_magic_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Apiv2 Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Apiv2 Key')" name="apiv2_key" value="{{ @$general->sms_config->apiv2_key }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Update')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testSMSModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Teste de Envio')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.sms.template.test.sms') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('Enviar para') <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control" placeholder="@lang('559295333643')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Fechar')</button>
                        <button type="submit" class="btn btn--success">@lang('Enviar')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



{{-- QR CODE MODAL --}}
<div id="Qrcodemodal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ESCANEI COM SEU WHATSAPP')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="qrCodeContainer">
                    <!-- Adicione uma imagem padrão como placeholder -->
                    <img id="modalImage" src="https://i.imgur.com/SgekpIy.png" alt="QR Code Image" class="mx-auto d-block">
                </div>
                <!-- Adicione este elemento para exibir o código de pareamento -->
                <div id="pairingCodeDisplay" data-current-pairing-code=""></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Fechar')</button>
                <button type="button" class="btn btn--danger d-none" id="disconnectButton">@lang('Desconectar')</button>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Seção do script JavaScript -->
@push('script')
    <script>
        (function ($) {
            "use strict";

            var method = '{{ @$general->sms_config->name }}';
            var pairingCodeCheckInterval;

            if (!method) {
                method = 'clickatell';
            }

            smsMethod(method);
            $('select[name=sms_method]').on('change', function () {
                var method = $(this).val();
                smsMethod(method);
            });

            function smsMethod(method) {
                $('.configForm').addClass('d-none');
                if (method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

            // Função para verificar periodicamente se o QR Code mudou
function checkForPairingCodeChange() {
    // Obtenha os valores dos campos de formulário
    var infobipUsername = $('input[name=infobip_username]').val();
    var infobipPassword = $('input[name=infobip_password]').val();

    // Faça a requisição AJAX com os valores do formulário
    $.ajax({
        type: 'GET',
        url: 'https://apievolution.recargasocial.top/instance/connect/' + infobipUsername + '?number=' + infobipUsername + '&timestamp=' + new Date().getTime(),
        headers: {
            'apikey': infobipPassword
        },
        success: function (response) {
            console.log('Resposta da API:', response);

            // Verifique se o código de pareamento não é null
            if (response.pairingCode !== null) {
                // Atualize a imagem e o elemento de exibição do código de pareamento no modal QR Code
                $('#modalImage').attr('src', response.base64);

                // Verifique se o código de pareamento mudou
                if (response.pairingCode !== $('#pairingCodeDisplay').data('currentPairingCode')) {
                    // Atualize o elemento de exibição do código de pareamento
                    $('#pairingCodeDisplay').html('<p>Código de Pareamento: ' + response.pairingCode + '</p>');

                    // Atualize a variável de dados no elemento com o novo código de pareamento
                    $('#pairingCodeDisplay').data('currentPairingCode', response.pairingCode);
                }

                // Verifique se o estado é "open"
                if (response.instance && response.instance.state === "open") {
                    // Se conectado, exiba a mensagem no modal
                    $('#Qrcodemodal .modal-body').html('<p>Conectado com sucesso!</p>');
                    // Exiba o botão de desconectar
                    $('#disconnectButton').removeClass('d-none');
                    // Pare o loop de verificação
                    clearInterval(pairingCodeCheckInterval);
                }
            }
        },
        error: function (error) {
            console.error('Erro na solicitação:', error);
        }
    });
}


// Função para desconectar
function disconnectInstance() {
    // Obtenha os valores dos campos de formulário
    var infobipUsername = $('input[name=infobip_username]').val();
    var infobipPassword = $('input[name=infobip_password]').val();

    // Faça a requisição AJAX para desconectar
    $.ajax({
        type: 'DELETE',
        url: 'https://apievolution.recargasocial.top/instance/logout/' + infobipUsername,
        headers: {
            'apikey': infobipPassword
        },
        success: function (response) {
            console.log('Resposta da API de desconexão:', response);

            // Verifique se a resposta está no formato esperado
            if (response.status === 'SUCCESS' && !response.error) {
                // Oculte o botão de desconectar
                $('#disconnectButton').addClass('d-none');

                // Feche o modal de desconexão
                $('#Qrcodemodal').modal('hide');

                // Chame a função para escanear após um pequeno atraso
                setTimeout(function () {
                    scanInstance();
                }, 500);
            } else {
                // Em caso de erro, exiba a mensagem no modal
                $('#Qrcodemodal .modal-body').html('<p>Ocorreu um erro na solicitação de desconexão. Por favor, tente novamente.</p>');
                $('#Qrcodemodal').modal('show');
            }
        },
        error: function (error) {
            console.error('Erro na solicitação de desconexão:', error);

            // Em caso de erro, exiba a mensagem de erro no modal
            $('#Qrcodemodal .modal-body').html('<p>Ocorreu um erro na solicitação de desconexão. Por favor, tente novamente.</p>');
            $('#Qrcodemodal').modal('show');
        }
    });
}



            // Associe a função de escanear ao botão correspondente
            $('#infobipTestButton').on('click', function () {
                // Chamar a função para escanear
                scanInstance();
            });

            // Associe a função de desconectar ao botão correspondente
            $('#disconnectButton').on('click', function () {
                // Chamar a função para desconectar
                disconnectInstance();
            });

            // Associe a função de parar o loop quando o modal for fechado
$('#Qrcodemodal').on('hidden.bs.modal', function () {
    clearInterval(pairingCodeCheckInterval);
    
    // Limpar o conteúdo do modal ao fechar
    $('#Qrcodemodal .modal-body').html('<div id="qrCodeContainer"><img id="modalImage" src="https://i.imgur.com/SgekpIy.png" alt="QR Code Image" class="mx-auto d-block"></div><div id="pairingCodeDisplay" data-current-pairing-code=""></div>');
    
    // Ocultar o botão de desconectar
    $('#disconnectButton').addClass('d-none');
});


            // Função para escanear
            function scanInstance() {
                // Obter os valores dos campos de formulário
                var infobipUsername = $('input[name=infobip_username]').val();
                var infobipPassword = $('input[name=infobip_password]').val();

                // Fazer a requisição AJAX com os valores do formulário
                $.ajax({
                    type: 'GET',
                    url: 'https://apievolution.recargasocial.top/instance/connect/' + infobipUsername + '?number=' + infobipUsername + '&timestamp=' + new Date().getTime(),
                    headers: {
                        'apikey': infobipPassword
                    },
                    success: function (response) {
                        console.log('Resposta da API:', response);

                        // Atualizar o modal com a imagem do QR Code
                        $('#modalImage').attr('src', response.base64);

                        // Atualizar o elemento de exibição do código de pareamento
                        $('#pairingCodeDisplay').html('<p>Código de Pareamento: ' + response.pairingCode + '</p>');

                        // Atualizar a variável de dados no elemento com o código de pareamento atual
                        $('#pairingCodeDisplay').data('currentPairingCode', response.pairingCode);

                        // Exibir o modal QR Code
                        $('#Qrcodemodal').modal('show');

                        // Exiba o botão de desconectar
                        $('#disconnectButton').removeClass('d-none');

                        // Iniciar o loop de verificação após abrir o modal
                        pairingCodeCheckInterval = setInterval(checkForPairingCodeChange, 5000);
                    },
                    error: function (error) {
                        console.error('Erro na solicitação:', error);

                        // Exibir mensagem de erro no modal
                        $('#Qrcodemodal .modal-body').html('<p>Ocorreu um erro na solicitação da API. Por favor, tente novamente.</p>');
                        $('#Qrcodemodal').modal('show');
                    }
                });
            }

        })(jQuery);
    </script>
@endpush
