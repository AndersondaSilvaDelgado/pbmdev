<?php

require_once('../control/PneuCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    $pneuCTR = new PneuCTR();
    echo $pneuCTR->salvarDadosPneu($info);
    
endif;