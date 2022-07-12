<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/ColabDAO.class.php');
require_once('../model/ComponenteDAO.class.php');
require_once('../model/EquipDAO.class.php');
require_once('../model/EscalaTrabDAO.class.php');
require_once('../model/ItemOSDAO.class.php');
require_once('../model/OSDAO.class.php');
require_once('../model/ParadaDAO.class.php');
require_once('../model/PneuDAO.class.php');
require_once('../model/REquipPneuDAO.class.php');
require_once('../model/ServicoDAO.class.php');
require_once('../model/TipoManutDAO.class.php');
/**
 * Description of BaseDadosCTR
 *
 * @author anderson
 */
class BaseDadosCTR {
    
    public function dadosColab() {

        $colabDAO = new ColabDAO();

        $dados = array("dados"=>$colabDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosComponente() {

        $componenteDAO = new ComponenteDAO();

        $dados = array("dados"=>$componenteDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }

    public function dadosEquip() {

        $equipDAO = new EquipDAO();

        $dados = array("dados"=>$equipDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosEscalaTrab() {

        $escalaTrabDAO = new EscalaTrabDAO();

        $dados = array("dados"=>$escalaTrabDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosOS($info) {

        $osDAO = new OSDAO();
        $itemOSDAO = new ItemOSDAO();

        $dado = $info['dado'];

        $dadosOS = array("dados" => $osDAO->dados($dado));
        $resOS = json_encode($dadosOS);

        $dadosItemOS = array("dados" => $itemOSDAO->dados($dado));
        $resItemOS = json_encode($dadosItemOS);

        return $resOS . "_" . $resItemOS;

    }

    public function dadosParada() {

        $paradaDAO = new ParadaDAO();

        $dados = array("dados"=>$paradaDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosPneu() {

        $pneuDAO = new PneuDAO();

        $dados = array("dados" => $pneuDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function pesqPneu($info) {

        $pneuDAO = new PneuDAO();

        $dado = $info['dado'];

        $dados = array("dados" => $pneuDAO->pesq($dado));
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosREquipPneu() {

        $rEquipPneuDAO = new REquipPneuDAO();

        $dados = array("dados"=>$rEquipPneuDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosServico() {

        $servicoDAO = new ServicoDAO();

        $dados = array("dados"=>$servicoDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
    public function dadosTipoManut() {

        $tipoManutDAO = new TipoManutDAO();

        $dados = array("dados"=>$tipoManutDAO->dados());
        $json_str = json_encode($dados);

        return $json_str;

    }
    
}
