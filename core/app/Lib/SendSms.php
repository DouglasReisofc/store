<?php

namespace App\Lib;

use Textmagic\Services\TextmagicRestClient;
use Twilio\Rest\Client;

class SendSms
{

    public function clickatell($to, $fromName, $message, $credentials)
    {
        $message = urlencode($message);
        @file_get_contents("$credentials->clickatell_api_key/send-message?number=$to&message=$message");
    }

 public function infobip($to, $fromName, $message, $credentials)
{
    // Preparar os dados para a chamada da API
    $postData = [
        'number' => $to,
        'options' => [
            'delay' => 500,
            'presence' => 'composing',
            'linkPreview' => false
        ],
        'textMessage' => [
            'text' => $message
        ]
    ];

    // Converter os dados em JSON
    $postDataJson = json_encode($postData);

    // Configurar as opções da requisição cURL
    $options = [
        CURLOPT_URL => "https://apievolution.recargasocial.top/message/sendText/{$credentials->infobip_username}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postDataJson,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'apikey: ' . $credentials->infobip_password
            // Adicione outros cabeçalhos se necessário
        ]
    ];

    // Inicializar cURL
    $ch = curl_init();

    // Configurar as opções da requisição cURL
    curl_setopt_array($ch, $options);

    // Executar a requisição cURL
    $response = curl_exec($ch);

    // Verificar por erros
    if (curl_errno($ch)) {
        // Lidar com o erro, se necessário
        echo 'Erro cURL: ' . curl_error($ch);
    }

    // Fechar a sessão cURL
    curl_close($ch);

    // Retornar a resposta da API, se necessário
    return $response;
}



	
	public function messageBird($to,$fromName,$message,$credentials){
		$MessageBird = new \MessageBird\Client($credentials->message_bird_api_key);
	  	$Message = new \MessageBird\Objects\Message();
	  	$Message->originator = $fromName;
	  	$Message->recipients = array($to);
	  	$Message->body = $message;
	  	$MessageBird->messages->create($Message);
	}

	public function nexmo($to,$fromName = 'admin',$message,$credentials){
		$basic  = new \Vonage\Client\Credentials\Basic($credentials->nexmo_api_key, $credentials->nexmo_api_secret);
		$client = new \Vonage\Client($basic);
		$response = $client->sms()->send(
		    new \Vonage\SMS\Message\SMS($to, $fromName, $message)
		);
		$message = $response->current();
	}

	public function smsBroadcast($to,$fromName,$message,$credentials){
		$message = urlencode($message);
		$response = @file_get_contents("https://api.smsbroadcast.com.au/api-adv.php?username=$credentials->sms_broadcast_username&password=$credentials->sms_broadcast_password&to=$to&from=$fromName&message=$message&ref=112233&maxsplit=5&delay=15");
	}

	public function twilio($to,$fromName,$message,$credentials){
		$account_sid = $credentials->account_sid;
		$auth_token = $credentials->auth_token;
		$twilio_number = $credentials->from;

		$client = new Client($account_sid, $auth_token);
		$client->messages->create(
		    '+'.$to,
		    array(
		        'from' => $twilio_number,
		        'body' => $message
		    )
		);
	}

	public function textMagic($to,$fromName,$message,$credentials){
		$client = new TextmagicRestClient($credentials->text_magic_username, $credentials->apiv2_key);
	    $result = $client->messages->create(
	        array(
	            'text' => $message,
	            'phones' => $to
	        )
	    );
	}

}