<?php

require('./dao/ServicoDAO.class.php');

$servicoDAO = new ServicoDAO();

//cria o array associativo
$dados = array("dados"=>$servicoDAO->dados());

//converte o conteúdo do array associativo para uma string JSON
$json_str = json_encode($dados);

//imprime a string JSON
echo $json_str;
