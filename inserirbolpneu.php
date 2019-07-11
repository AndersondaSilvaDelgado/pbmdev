<?php

require_once('./control/InserirDadosPneuCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    $inserirDadosPneuCTR = new InserirDadosPneuCTR();
    echo $inserirDadosPneuCTR->salvarDadosPneu($info, "inserirapont");
    
endif;