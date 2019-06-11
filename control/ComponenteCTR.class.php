<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./model/dao/ComponenteDAO.class.php');
/**
 * Description of ComponenteCTR
 *
 * @author anderson
 */
class ComponenteCTR {
    //put your code here
    
    public function dados() {
        
        $componenteDAO = new ComponenteDAO();
       
        $dados = array("dados"=>$componenteDAO->dados());
        $json_str = json_encode($dados);
        
        return $json_str;
        
    }
    
}
