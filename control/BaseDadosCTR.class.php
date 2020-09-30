<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/dao/ColabDAO.class.php');
require_once('../model/dao/ComponenteDAO.class.php');
require_once('../model/dao/EquipDAO.class.php');
require_once('../model/dao/EscalaTrabDAO.class.php');
require_once('../model/dao/ItemOSDAO.class.php');
require_once('../model/dao/OSDAO.class.php');
require_once('../model/dao/ParadaDAO.class.php');
require_once('../model/dao/PneuDAO.class.php');
require_once('../model/dao/REquipPneuDAO.class.php');
require_once('../model/dao/ServicoDAO.class.php');
/**
 * Description of BaseDadosCTR
 *
 * @author anderson
 */
class BaseDadosCTR {
    
    private $base = 1;
    
    public function dadosColab($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $colabDAO = new ColabDAO();
        
            $dados = array("dados"=>$colabDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosComponente($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $componenteDAO = new ComponenteDAO();
        
            $dados = array("dados"=>$componenteDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }

    public function dadosEquip($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $equipDAO = new EquipDAO();
        
            $dados = array("dados"=>$equipDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosEscalaTrab($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $escalaTrabDAO = new EscalaTrabDAO();
        
            $dados = array("dados"=>$escalaTrabDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosOS($versao, $info) {

        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
        
            $osDAO = new OSDAO();
            $itemOSDAO = new ItemOSDAO();

            $dado = $info['dado'];

            $dadosOS = array("dados" => $osDAO->dados($dado, $this->base));
            $resOS = json_encode($dadosOS);

            $dadosItemOS = array("dados" => $itemOSDAO->dados($dado, $this->base));
            $resItemOS = json_encode($dadosItemOS);

            return $resOS . "#" . $resItemOS;

        }
        
    }

    public function dadosParada($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $paradaDAO = new ParadaDAO();
        
            $dados = array("dados"=>$paradaDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosPneu($versao, $info) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
            
            $pneuDAO = new PneuDAO();

            $dado = $info['dado'];
            
            $dados = array("dados" => $pneuDAO->dados($dado, $this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosREquipPneu($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
        
            $rEquipPneuDAO = new REquipPneuDAO();

            $dados = array("dados"=>$rEquipPneuDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function dadosServico($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 2.00){
        
            $servicoDAO = new ServicoDAO();

            $dados = array("dados"=>$servicoDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
}
