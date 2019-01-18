<?php

require('./dao/EscalaTrabDAO.class.php');

$escalaTrabDAO = new EscalaTrabDAO();

$dados = array("dados"=>$escalaTrabDAO->dados());

$json_str = json_encode($dados);

echo $json_str;
