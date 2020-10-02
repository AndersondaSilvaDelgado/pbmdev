<?php

require_once('../control/MecanicoCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    $mecanicoCTR = new MecanicoCTR();
    echo $mecanicoCTR->salvarBolAberto($info, "inserirbolaberto");

endif;