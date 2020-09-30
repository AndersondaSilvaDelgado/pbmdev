<?php

require_once('../control/AtualAplicCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$versao = filter_input(INPUT_GET, 'versao', FILTER_DEFAULT);

if (isset($info)):

   $atualAplicCTR = new AtualAplicCTR();
   echo $atualAplicCTR->atualAplic($versao, $info);

endif;