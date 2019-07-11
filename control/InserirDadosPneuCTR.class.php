<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/InserirLogDAO.class.php');
require_once('./model/dao/BoletimPneuDAO.class.php');
require_once('./model/dao/ItemMedPneuDAO.class.php');
require_once('./model/dao/ItemManutPneuDAO.class.php');

/**
 * Description of InserirDadosPneu
 *
 * @author anderson
 */
class InserirDadosPneuCTR {

    public function salvarDadosPneu($info, $pagina) {

        $dados = $info['dado'];
        $this->salvarLog($dados, $pagina);

        $pos1 = strpos($dados, "_") + 1;
        $pos2 = strpos($dados, "|") + 1;

        $bolpneu = substr($dados, 0, ($pos1 - 1));
        $itemmedpneu = substr($dados, $pos1, (($pos2 - 1) - $pos1));
        $itemmanutpneu = substr($dados, $pos2);

        $jsonObjBolPneu = json_decode($bolpneu);
        $jsonObjItemMedPneu = json_decode($itemmedpneu);
        $jsonObjItemManutPneu = json_decode($itemmanutpneu);

        $dadosBolPneu = $jsonObjBolPneu->bolpneu;
        $dadosItemMedPneu = $jsonObjItemMedPneu->itemmedpneu;
        $dadosItemManutPneu = $jsonObjItemManutPneu->itemmanutpneu;

        $boletimPneuDAO = new BoletimPneuDAO();

        foreach ($dadosBolPneu as $bol) {
            $v = $boletimPneuDAO->verifBoletimPneu($bol, 3);
            if ($v == 0) {
                $boletimPneuDAO->insBoletimPneu($bol, 3);
            }
            $idBol = $boletimPneuDAO->idBoletimPneu($bol, 3);
            $this->salvarApontMed($idBol, $bol->idBolPneu, $dadosItemMedPneu);
            $this->salvarApontManut($idBol, $bol->idBolPneu, $dadosItemManutPneu);
        }
        echo 'GRAVOUPNEU';
    }

    private function salvarApontMed($idBolBD, $idBolCel, $dadosItemMedPneu) {
        $itemMedPneuDAO = new ItemMedPneuDAO();
        foreach ($dadosItemMedPneu as $itemMedPneu) {
            if ($idBolCel == $itemMedPneu->idBolItemMedPneu) {
                $v = $itemMedPneuDAO->verifItemMedPneu($idBolBD, $itemMedPneu);
                if ($v == 0) {
                    $itemMedPneuDAO->insItemMedPneu($idBolBD, $itemMedPneu);
                }
            }
        }
    }
    
    private function salvarApontManut($idBolBD, $idBolCel, $dadosItemManutPneu) {
        $itemManutPneuDAO = new ItemManutPneuDAO();
        foreach ($dadosItemManutPneu as $itemManutPneu) {
            if ($idBolCel == $itemManutPneu->idBolItemManutPneu) {
                $v = $itemManutPneuDAO->verifItemManutPneu($idBolBD, $itemManutPneu);
                if ($v == 0) {
                    $itemManutPneuDAO->insItemManutPneu($idBolBD, $itemManutPneu);
                }
            }
        }
    }

    private function salvarLog($dados, $pagina) {
        $inserirLogDAO = new InserirLogDAO();
        $inserirLogDAO->salvarDados($dados, $pagina);
    }

}
