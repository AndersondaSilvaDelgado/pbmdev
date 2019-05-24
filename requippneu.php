<?php

require('./dao/REquipPneuDAO.class.php');

$rEquipPneuDAO = new REquipPneuDAO();

$dados = array("dados"=>$rEquipPneuDAO->dados());

$json_str = json_encode($dados);

echo $json_str;