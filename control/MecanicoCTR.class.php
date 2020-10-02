<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/dao/LogDAO.class.php');
require_once('../model/dao/BoletimMecanDAO.class.php');
require_once('../model/dao/ApontMecanDAO.class.php');

/**
 * Description of InserirDadosMecan
 *
 * @author anderson
 */
class MecanicoCTR {

    private $base = 2;

    public function salvarBolFechado($info, $pagina) {

        $dados = $info['dado'];
        $this->salvarLog($dados, $pagina);

        $pos1 = strpos($dados, "_") + 1;

        $b = substr($dados, 0, ($pos1 - 1));
        $a = substr($dados, $pos1);

        $jsonObjBoletim = json_decode($b);
        $jsonObjAponta = json_decode($a);

        $dadosBoletim = $jsonObjBoletim->boletim;
        $dadosAponta = $jsonObjAponta->aponta;

        $boletimMecanDAO = new BoletimMecanDAO();
        $idBolArray = array();
        foreach ($dadosBoletim as $bol) {
            $v = $boletimMecanDAO->verifBol($bol, $this->base);
            if ($v == 0) {
                $boletimMecanDAO->insBolFechado($bol, $this->base);
            } else {
                $boletimMecanDAO->updBolFechado($bol, $this->base);
            }
            $idBol = $boletimMecanDAO->idBol($bol, $this->base);
            $this->salvarApont($idBol, $bol->idBoletim, $dadosAponta);
            $idBolArray[] = array("idBoletim" => $bol->idBoletim);
        }
        $dadoBol = array("boletim"=>$idBolArray);
        $retBol = json_encode($dadoBol);
        return "BOLFECHADOMEC#" . $retBol . "_";
    }

    public function salvarBolAberto($info, $pagina) {

        $dados = $info['dado'];
        $this->salvarLog($dados, $pagina);

        $pos1 = strpos($dados, "_") + 1;

        $b = substr($dados, 0, ($pos1 - 1));
        $a = substr($dados, $pos1);

        $jsonObjBoletim = json_decode($b);
        $jsonObjAponta = json_decode($a);

        $dadosBoletim = $jsonObjBoletim->boletim;
        $dadosAponta = $jsonObjAponta->aponta;

        $boletimMecanDAO = new BoletimMecanDAO();
        $idBolArray = array();
        foreach ($dadosBoletim as $bol) {
            $v = $boletimMecanDAO->verifBol($bol, $this->base);
            if ($v == 0) {
                $boletimMecanDAO->insBolAberto($bol, $this->base);
            }
            $idBol = $boletimMecanDAO->idBol($bol, $this->base);
            $retApont = $this->salvarApont($idBol, $bol->idBoletim, $dadosAponta);
            $idBolArray[] = array("idBoletim" => $bol->idBoletim, "idExtBoletim" => $idBol);
        }
        $dadoBol = array("boletim"=>$idBolArray);
        $retBol = json_encode($dadoBol);
        $retorno = "BOLABERTOMEC#" . $retBol . "_" . $retApont;
        return $retorno;
    }

    private function salvarApont($idBolBD, $idBolCel, $dadosAponta) {
        $apontMecanDAO = new ApontMecanDAO();
        $idApontArray = array();
        foreach ($dadosAponta as $apont) {
            if ($idBolCel == $apont->idBolApont) {
                $v = $apontMecanDAO->verifApont($idBolBD, $apont, $this->base);
                if ($v == 0) {
                    if ($apont->dthrFinalApont == "") {
                        $apontMecanDAO->insApontAberto($idBolBD, $apont, $this->base);
                    } else {
                        $apontMecanDAO->insApontFechado($idBolBD, $apont, $this->base);
                    }
                } else {
                    $apontMecanDAO->updApont($idBolBD, $apont, $this->base);
                }
                $idApontArray[] = array("idApont" => $apont->idApont, "idBolApont" => $idBolCel);
            }
        }
        $dadoApont = array("apont"=>$idApontArray);
        $retApont = json_encode($dadoApont);
        return $retApont;
    }

    private function salvarLog($dados, $pagina) {
        $logDAO = new LogDAO();
        $logDAO->salvarDados($dados, $pagina, $this->base);
    }

}
