<?php

require('./dao/ParadaDAO.class.php');

$paradaDAO = new ParadaDAO();

$dados = array("dados"=>$paradaDAO->dados());

$json_str = json_encode($dados);

echo $json_str;
