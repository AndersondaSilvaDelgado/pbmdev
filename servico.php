<?php

require('./dao/ServicoDAO.class.php');

$servicoDAO = new ServicoDAO();

$dados = array("dados"=>$servicoDAO->dados());

$json_str = json_encode($dados);

echo $json_str;
