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
    //put your code here
    
    private $base = 2;
    
    public function atualAplic($versao, $info) {

        $versao = str_replace("_", ".", $versao);
        
        if($versao >= 2.00){
        
            $atualAplicDAO = new AtualAplicDAO();

            $jsonObj = json_decode($info['dado']);
            $dados = $jsonObj->dados;

            foreach ($dados as $d) {
                $equip = $d->idEquipAtual;
                $va = $d->versaoAtual;
            }
        
            $retorno = 'NAO=2_';
            
            $v = $atualAplicDAO->verAtual($equip, $this->base);
            if ($v == 0) {
                $atualAplicDAO->insAtual($equip, $va, $this->base);
            } else {
                $result = $atualAplicDAO->retAtual($equip, $this->base);
                foreach ($result as $item) {
                    $vn = $item['VERSAO_NOVA'];
                    $vab = $item['VERSAO_ATUAL'];
                }
                if ($va != $vab) {
                    $atualAplicDAO->updAtualNova($equip, $va, $this->base);
                } else {
                    if ($va != $vn) {
                        $retorno = 'SIM';
                    } else {
                        if (strcmp($va, $vab) <> 0) {
                            $atualAplicDAO->updAtual($equip, $va, $this->base);
                        }
                    }
                }
            }
            return $retorno;
//            $dthr = $atualAplicDAO->dataHora($this->base);
//            if ($retorno == 'SIM') {
//                return $retorno;
//            } else {
//                return $retorno . "#" . $dthr;
//            }
        
        }
        
    }
    
}
