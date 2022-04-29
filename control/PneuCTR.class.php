<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/dao/BoletimPneuDAO.class.php');
require_once('../model/dao/ItemMedPneuDAO.class.php');
require_once('../model/dao/ItemManutPneuDAO.class.php');

/**
 * Description of InserirDadosPneu
 *
 * @author anderson
 */
class InserirDadosPneuCTR {

    public function salvarDadosPneu($info) {

        $dados = $info['dado'];

        $array = explode("_", $dados);

        $jsonObjBolPneu = json_decode($array[0]);
        $jsonObjItemMedPneu = json_decode($array[1]);
        $jsonObjItemManutPneu = json_decode($array[2]);

        $dadosBolPneu = $jsonObjBolPneu->bolpneu;
        $dadosItemMedPneu = $jsonObjItemMedPneu->itemmedpneu;
        $dadosItemManutPneu = $jsonObjItemManutPneu->itemmanutpneu;

        $boletimPneuDAO = new BoletimPneuDAO();

        foreach ($dadosBolPneu as $bolPneu) {
            $v = $boletimPneuDAO->verifBoletimPneu($bolPneu);
            if ($v == 0) {
                $boletimPneuDAO->insBoletimPneu($bolPneu, 3);
            }
            $idBol = $boletimPneuDAO->idBoletimPneu($bolPneu);
            $this->salvarApontMed($idBol, $bol->idBolPneu, $dadosItemMedPneu);
            $this->salvarApontManut($idBol, $bol->idBolPneu, $dadosItemManutPneu);
            $idBolPneuArray[] = array("idBolPneu" => $bolPneu->idBolPneu);
        }
        $dadoBolPneu = array("boletimpneu"=>$idBolPneuArray);
        $retBolPneu = json_encode($dadoBolPneu);
        echo 'BOLPNEU_' . $retBolPneu;
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

}
