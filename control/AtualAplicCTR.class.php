<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../model/AtualAplicDAO.class.php');
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
            $idEquip = $d->idEquip;
            $token = $d->token;
        }

        $retAtualApp = 0;

        
        $v = $atualAplicDAO->verToken($token);
        
        if ($v > 0) {
            
            $atualAplicDAO->updUltAcesso($idEquip);
            $dado = array("flagAtualApp" => $retAtualApp, "minutosParada" => 2, "horaFechBoletim" => 4);
            return json_encode(array("parametro"=>array($dado)));
        
        }

    }
        
    public function inserirAtualVersao($idEquip, $versao) {
        $atualAplicDAO = new AtualAplicDAO();
        $v = $atualAplicDAO->verAtual($idEquip);
        if ($v == 0) {
            $atualAplicDAO->insAtual($idEquip, $versao);
        } else {
            $atualAplicDAO->updAtual($idEquip, $versao);
        }
    }

    public function verifToken($info){
        
        $jsonObj = json_decode($info['dado']);
        $dados = $jsonObj->dados;

        foreach ($dados as $d) {
            $token = $d->token;
        }
        
        $atualAplicDAO = new AtualAplicDAO();
        $v = $atualAplicDAO->verToken($token);
        
        if ($v > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function parametro($info){
        
        if($this->verifToken($info)){
        
            $dado = array("minutosParada" => 2, "horaFechBoletim" => 4);
            return json_encode(array("parametro"=>array($dado)));
        
        }
    }
    
}
