<?php

require('./dao/ColabDAO.class.php');

$colabDAO = new ColabDAO();

$dados = array("dados"=>$colabDAO->dados());

$json_str = json_encode($dados);

echo $json_str;