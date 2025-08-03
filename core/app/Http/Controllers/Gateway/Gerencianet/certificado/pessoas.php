<?php
error_reporting(0);
ignore_user_abort();

function getStr($separa, $inicia, $fim, $contador){
  $nada = explode($inicia, $separa);
  $nada = explode($fim, $nada[$contador]);
  return $nada[0];
}

function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}

function numeros($size){
    $str = '';
    $numbes = '0123456789';
    for ($i=0; $i < $size; $i++) { 
       $str.= $numbes[rand(0, strlen($numbes) - 1)];
    }
    return $str;
}

function letras($size){
    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $return= "";
    for($count= 0; $size > $count; $count++){
        $return.= $basic[rand(0, strlen($basic) - 1)];
    }
    return $return;
}

function ln($size){
    $str = '';
    $numbes = '0123456789abcdef';
    for ($i=0; $i < $size; $i++) { 
       $str.= $numbes[rand(0, strlen($numbes) - 1)];
    }
    return $str;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.4devs.com.br/ferramentas_online.php");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=&data_nasc=1');
$dados = curl_exec($ch);

$nome = getStr($dados, '"nome":"','"' , 1);
$cpf = getStr($dados, '"cpf":"','"' , 1);
$cep = getStr($dados, '"cep":"','"' , 1);
$sexo = getStr($dados, '"sexo":"','"' , 1);

echo '{"nome":"'.$nome.'","sexo":"'.$sexo.'","cep":"'.$cep.'","cpf":"'.$cpf.'"}';

?>