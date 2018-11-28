<?php

require('./dao/ColabDAO.class.php');

$colabDAO = new ColabDAO();

//cria o array associativo
$dados = array("dados"=>$colabDAO->dados());

//converte o conteúdo do array associativo para uma string JSON
$json_str = json_encode($dados);

//imprime a string JSON
echo $json_str;