<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/ColabDAO.class.php');
/**
 * Description of ColabCTR
 *
 * @author anderson
 */
class ColabCTR {
    //put your code here
    
    public function dados() {
        
        $colabDAO = new ColabDAO();
       
        $dados = array("dados"=>$colabDAO->dados());
        $json_str = json_encode($dados);
        
        return $json_str;
        
    }
    
}
