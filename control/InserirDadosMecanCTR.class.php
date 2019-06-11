<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/InserirLogDAO.class.php');
require_once('./model/dao/BoletimMecanDAO.class.php');
require_once('./model/dao/ApontMecanDAO.class.php');

/**
 * Description of InserirDadosMecan
 *
 * @author anderson
 */
class InserirDadosMecanCTR {

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
        return 'GRAVOU-BOLFECHADO';
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
        }
        return "GRAVOU+id=" . $idBol . "_";
    }

    public function salvarDadosApontMecan($info, $pagina) {

        $apontMecanDAO = new ApontMecanDAO();

        $dados = $info['dado'];
        $this->salvarLog($dados, $pagina);

        $jsonObjAponta = json_decode($dados);

        $dadosAponta = $jsonObjAponta->aponta;

        foreach ($dadosAponta as $apont) {
            $v = $apontMecanDAO->verifApontMecan($apont->idExtBolAponta, $apont);
            if ($v == 0) {
                $apontMecanDAO->insApontMecan($apont->idExtBolAponta, $apont);
            }
            $idApont = $apontMecanDAO->idApontMecan($apont->idExtBolAponta, $apont);
        }
        return 'GRAVOU-APONTAMM';
    }

    private function salvarApont($idBolBD, $idBolCel, $dadosAponta) {
        $apontMMDAO = new ApontMMDAO();
        foreach ($dadosAponta as $apont) {
            if ($idBolCel == $apont->idBolAponta) {
                $v = $apontMMDAO->verifApontMM($idBolBD, $apont);
                if ($v == 0) {
                    $apontMMDAO->insApontMM($idBolBD, $apont);
                }
                $idApont = $apontMMDAO->idApontMM($idBolBD, $apont);
            }
        }
    }

    private function salvarLog($dados, $pagina) {
        $inserirLogDAO = new InserirLogDAO();
        $inserirLogDAO->salvarDados($dados, $pagina);
    }

}
