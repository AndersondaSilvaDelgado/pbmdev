<?php

require('./control/ServicoCTR.class.php');

$servicoCTR = new ServicoCTR();

echo $servicoCTR->dados();
