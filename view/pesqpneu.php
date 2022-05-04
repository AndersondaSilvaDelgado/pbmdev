<?php

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

require_once('../control/BaseDadosCTR.class.php');

$baseDadosCTR = new BaseDadosCTR();

if (isset($info)):

    echo $baseDadosCTR->dadosPneu($info);

endif;