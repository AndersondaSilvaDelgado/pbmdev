<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../model/dao/AtualAplicDAO.class.php');
/**
 * Description of AtualAplicativoCTR
 *
 * @author anderson
 */
class AtualAplicCTR {
    
    public function atualAplic($info) {

        $atualAplicDAO = new AtualAplicDAO();

        $jsonObj = json_decode($info['dado']);
        $dados = $jsonObj->dados;

        foreach ($dados as $d) {
            $equip = $d->idEquipAtual;
            $va = $d->versaoAtual;
        }

        $retAtualApp = 0;

        $v = $atualAplicDAO->verAtual($equip);
        if ($v == 0) {
            $atualAplicDAO->insAtual($equip, $va);
        } else {
            $result = $atualAplicDAO->retAtual($equip);
            foreach ($result as $item) {
                $vn = $item['VERSAO_NOVA'];
                $vab = $item['VERSAO_ATUAL'];
            }
            if ($va != $vab) {
                $atualAplicDAO->updAtualNova($equip, $va);
            } else {
                if ($va != $vn) {
                    $retAtualApp = 1;
                } else {
                    if (strcmp($va, $vab) <> 0) {
                        $atualAplicDAO->updAtual($equip, $va);
                    }
                }
            }
        }
        
        $dado = array("flagAtualApp" => $retAtualApp, "minutosParada" => 2, "horaFechBoletim" => 4);
        return json_encode(array("parametro"=>array($dado)));

    }
    
}
