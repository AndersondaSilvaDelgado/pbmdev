<?php

require('./dao/InserirApontDAO.class.php');
require('./dao/InserirDadosDAO.class.php');

$inserirApontDAO = new InserirApontDAO();
$inserirDadosDAO = new InserirDadosDAO();
$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (isset($info)):

    $dados = $info['dado'];
    $inserirDadosDAO->salvarDados($dados, "inseriraponta");
  
    $jsonObjAponta = json_decode($dados);
    $dadosAponta = $jsonObjAponta->aponta;
    
    $inserirApontDAO->salvarDados($dadosAponta);

    echo 'GRAVOUAPONTA';

endif;