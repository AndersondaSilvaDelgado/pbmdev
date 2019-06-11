<?php

require('./control/PneuCTR.class.php');

$pneuCTR = new PneuCTR();
$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    echo $retorno = $pneuCTR->dados($info);

endif;
