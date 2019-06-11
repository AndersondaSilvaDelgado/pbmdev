<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/REquipPneuDAO.class.php');
/**
 * Description of REquipPneuCTR
 *
 * @author anderson
 */
class REquipPneuCTR {
    //put your code here
    
    public function dados() {
        
        $rEquipPneuDAO = new REquipPneuDAO();
        
        $dados = array("dados"=>$rEquipPneuDAO->dados());
        $json_str = json_encode($dados);
        
        return $json_str;
        
    }
    
}
