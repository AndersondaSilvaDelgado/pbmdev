<?php

require_once('./control/InserirDadosMecanCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    $inserirDadosMecanCTR = new InserirDadosMecanCTR();
    echo $inserirDadosMecanCTR->salvarDadosBolFechadoMecan($info, "inserirbolaberto");

endif;