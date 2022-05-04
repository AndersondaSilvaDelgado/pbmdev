<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/dao/BoletimMecanDAO.class.php');
require_once('../model/dao/ApontMecanDAO.class.php');

/**
 * Description of InserirDadosMecan
 *
 * @author anderson
 */
class MecanicoCTR {

    public function salvarBolMecan($info) {

        $dados = $info['dado'];
        $array = explode("_",$dados);

        $jsonObjBoletim = json_decode($array[0]);
        $jsonObjAponta = json_decode($array[1]);

        $dadosBoletim = $jsonObjBoletim->boletim;
        $dadosAponta = $jsonObjAponta->aponta;

        $boletimMecanDAO = new BoletimMecanDAO();
        $idBolArray = array();
        $statusBol = 0;
        foreach ($dadosBoletim as $bol) {
            if($bol->statusBolMecan == 1){
                $statusBol = 1;
                $v = $boletimMecanDAO->verifBolMecan($bol);
                if ($v == 0) {
                    $boletimMecanDAO->insBolMecanAberto($bol);
                }
                $idBol = $boletimMecanDAO->idBolMecan($bol);
                $retApont = $this->salvarApontMecan($idBol, $bol->idBolMecan, $dadosAponta);
                $idBolArray[] = array("idBolMecan" => $bol->idBolMecan, "idExtBolMecan" => $idBol);
            } else {
                $statusBol = 2;
                $v = $boletimMecanDAO->verifBolMecan($bol);
                if ($v == 0) {
                    $boletimMecanDAO->insBolMecanFechado($bol);
                } else {
                    $boletimMecanDAO->updBolMecanFechado($bol);
                }
                $idBol = $boletimMecanDAO->idBolMecan($bol);
                $retApont = $this->salvarApontMecan($idBol, $bol->idBolMecan, $dadosAponta);
                $idBolArray[] = array("idBolMecan" => $bol->idBolMecan);
            }
        }
        $dadoBol = array("boletim"=>$idBolArray);
        $retBol = json_encode($dadoBol);
        $retorno = "BOLETIMMECAN_" . $retBol . "_" . $retApont;
        return $retorno;
    }

    private function salvarApontMecan($idBolBD, $idBolCel, $dadosAponta) {
        $apontMecanDAO = new ApontMecanDAO();
        $idApontArray = array();
        foreach ($dadosAponta as $apont) {
            if ($idBolCel == $apont->idBolApontMecan) {
                $v = $apontMecanDAO->verifApontMecan($idBolBD, $apont);
                if ($v == 0) {
                    if($apont->statusApontMecan == 1){
                        $apontMecanDAO->insApontMecanAberto($idBolBD, $apont);
                    } else if($apont->statusApontMecan == 3){
                        $apontMecanDAO->insApontMecanFechado($idBolBD, $apont);
                    }
                } else {
                    if($apont->statusApontMecan == 3){
                        $apontMecanDAO->updApontMecan($idBolBD, $apont);
                    }
                }
                $idApontArray[] = array("idApontMecan" => $apont->idApontMecan, "idBolApontMecan" => $idBolCel);
            }
        }
        $dadoApont = array("apont"=>$idApontArray);
        $retApont = json_encode($dadoApont);
        return $retApont;
    }

}
