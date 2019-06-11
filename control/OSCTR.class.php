<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('./model/dao/OSDAO.class.php');
require('./model/dao/ItemOSDAO.class.php');
/**
 * Description of OSCTR
 *
 * @author anderson
 */
class OSCTR {
    //put your code here
    
    public function dados($info) {

        $osDAO = new OSDAO();
        $itemOSDAO = new ItemOSDAO();

        $dado = $info['dado'];

        $dadosOS = array("dados" => $osDAO->dados($dado));
        $resOS = json_encode($dadosOS);

        $dadosItemOS = array("dados" => $itemOSDAO->dados($dado));
        $resItemOS = json_encode($dadosItemOS);
        
        return $resOS . "#" . $resItemOS;
                
    }
    
}
