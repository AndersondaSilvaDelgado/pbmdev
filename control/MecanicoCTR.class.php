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

    //put your code here

    public function salvarDadosBolFechadoMecan($info, $pagina) {

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

        foreach ($dadosBoletim as $bol) {
            $v = $boletimMecanDAO->verifBoletimMecan($bol);
            if ($v == 0) {
                $boletimMecanDAO->insBoletimMecanFechado($bol);
            } else {
                $boletimMecanDAO->updateBoletimMecanFechado($bol);
            }
            $idBol = $boletimMecanDAO->idBoletimMecan($bol);
            $this->salvarApont($idBol, $bol->idBoletim, $dadosAponta);
        }
        return 'GRAVOUFECHADO';
    }

    public function salvarDadosBolAbertoMecan($info, $pagina) {

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

        foreach ($dadosBoletim as $bol) {
            $v = $boletimMecanDAO->verifBoletimMecan($bol);
            if ($v == 0) {
                $boletimMecanDAO->insBoletimMecanAberto($bol);
            }
            $idBol = $boletimMecanDAO->idBoletimMecan($bol);
            $this->salvarApont($idBol, $bol->idBoletim, $dadosAponta);
            
            $d[] = array(
                "idBoletim" => $bol->idBoletim,
                "idExtBoletim" => $idBol
            );
        }

        $retorno = "GRAVOUABERTO#" . json_encode(array("dados" => $d)) . "_";
        return $retorno;
    }

    public function salvarDadosApontMecan($info, $pagina) {

        $apontMecanDAO = new ApontMecanDAO();

        $dados = $info['dado'];
        $this->salvarLog($dados, $pagina);

        $jsonObjAponta = json_decode($dados);

        $dadosAponta = $jsonObjAponta->aponta;

        foreach ($dadosAponta as $apont) {
            $v = $apontMecanDAO->verifApontMecan($apont->idExtBolApont, $apont);
            if ($v == 0) {
                if ($apont->dthrFinalApont == "") {
                    $apontMecanDAO->insApontMecanAberto($apont->idExtBolApont, $apont);
                } else {
                    $apontMecanDAO->insApontMecanFechado($apont->idExtBolApont, $apont);
                }
            } else {
                $apontMecanDAO->updateApontMecan($apont->idExtBolApont, $apont);
            }
        }
        echo 'GRAVOUAPONTA';
    }

    private function salvarApont($idBolBD, $idBolCel, $dadosAponta) {
        $apontMecanDAO = new ApontMecanDAO();
        foreach ($dadosAponta as $apont) {
            if ($idBolCel == $apont->idBolApont) {
                $v = $apontMecanDAO->verifApontMecan($idBolBD, $apont);
                if ($v == 0) {
                    if ($apont->dthrFinalApont == "") {
                        $apontMecanDAO->insApontMecanAberto($idBolBD, $apont);
                    } else {
                        $apontMecanDAO->insApontMecanFechado($idBolBD, $apont);
                    }
                } else {
                    $apontMecanDAO->updateApontMecan($idBolBD, $apont);
                }
            }
        }
    }

    private function salvarLog($dados, $pagina) {
        $logDAO = new LogDAO();
        $logDAO->salvarDados($dados, $pagina);
    }

}
