<?php

require('./dao/ComponenteDAO.class.php');

$componenteDAO = new ComponenteDAO();

//cria o array associativo
$dados = array("dados"=>$componenteDAO->dados());

//converte o conteúdo do array associativo para uma string JSON
$json_str = json_encode($dados);

//imprime a string JSON
echo $json_str;
