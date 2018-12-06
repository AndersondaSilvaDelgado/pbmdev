<?php

require('./dao/ComponenteDAO.class.php');

$componenteDAO = new ComponenteDAO();

$dados = array("dados"=>$componenteDAO->dados());

$json_str = json_encode($dados);

echo $json_str;
