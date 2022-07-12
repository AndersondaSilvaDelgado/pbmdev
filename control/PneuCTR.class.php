<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/BoletimPneuDAO.class.php');
require_once('../model/ItemCalibPneuDAO.class.php');
require_once('../model/ItemManutPneuDAO.class.php');

/**
 * Description of InserirDadosPneu
 *
 * @author anderson
 */
class PneuCTR {

    public function salvarDadosPneu($info) {

        $dados = $info['dado'];

        $array = explode("_", $dados);

        $jsonObjBolPneu = json_decode($array[0]);
        $jsonObjItemCalibPneu = json_decode($array[1]);
        $jsonObjItemManutPneu = json_decode($array[2]);

        $dadosBolPneu = $jsonObjBolPneu->bolpneu;
        $dadosItemCalibPneu = $jsonObjItemCalibPneu->itemcalibpneu;
        $dadosItemManutPneu = $jsonObjItemManutPneu->itemmanutpneu;

        $boletimPneuDAO = new BoletimPneuDAO();

        foreach ($dadosBolPneu as $bolPneu) {
            $v = $boletimPneuDAO->verifBoletimPneu($bolPneu);
            if ($v == 0) {
                $boletimPneuDAO->insBoletimPneu($bolPneu, 3);
            }
            $idBol = $boletimPneuDAO->idBoletimPneu($bolPneu);
            $this->salvarApontCalib($idBol, $bolPneu->idBolPneu, $dadosItemCalibPneu);
            $this->salvarApontManut($idBol, $bolPneu->idBolPneu, $dadosItemManutPneu);
            $idBolPneuArray[] = array("idBolPneu" => $bolPneu->idBolPneu);
        }
        $dadoBolPneu = array("boletimpneu"=>$idBolPneuArray);
        $retBolPneu = json_encode($dadoBolPneu);
        echo 'BOLETIMPNEU_' . $retBolPneu;
    }

    private function salvarApontCalib($idBolBD, $idBolCel, $dadosItemCalibPneu) {
        $itemCalibPneuDAO = new ItemCalibPneuDAO();
        foreach ($dadosItemCalibPneu as $itemCalibPneu) {
            if ($idBolCel == $itemCalibPneu->idBolItemCalibPneu) {
                $v = $itemCalibPneuDAO->verifItemCalibPneu($idBolBD, $itemCalibPneu);
                if ($v == 0) {
                    $itemCalibPneuDAO->insItemCalibPneu($idBolBD, $itemCalibPneu);
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
