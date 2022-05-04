<?php

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

require_once('../control/MecanicoCTR.class.php');

if (isset($info)):

    $mecanicoCTR = new MecanicoCTR();
    echo $mecanicoCTR->salvarBolMecan($info);

endif;