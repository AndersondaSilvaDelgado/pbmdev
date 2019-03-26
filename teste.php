<?php

$dados[] = array(
    "idGrafProdFrente" => 1,
    "prodFrenteMetaDia" => "teste"
);

$dados[] = array(
    "idGrafProdFrente" => 2,
    "prodFrenteMetaDia" => "teste2"
);

$json_str = json_encode(array("dados" => $dados));

echo $json_str;
