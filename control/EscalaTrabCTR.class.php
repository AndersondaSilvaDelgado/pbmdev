<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/EscalaTrabDAO.class.php');
/**
 * Description of EscalaTrabCTR
 *
 * @author anderson
 */
class EscalaTrabCTR {
    //put your code here
    
    public function dados() {
        
        $escalaTrabDAO = new EscalaTrabDAO();
       
        $dados = array("dados"=>$escalaTrabDAO->dados());
        $json_str = json_encode($dados);
        
        return $json_str;
        
    }
    
}
