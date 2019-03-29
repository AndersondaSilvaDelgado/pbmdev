<?php

require('./dao/EquipDAO.class.php');

$equipDAO = new EquipDAO();

$dados = array("dados"=>$equipDAO->dados());

$json_str = json_encode($dados);

echo $json_str;
