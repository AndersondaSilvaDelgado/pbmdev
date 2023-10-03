<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../control/AtualAplicCTR.class.php');
require_once('../model/AtualAplicDAO.class.php');
require_once('../model/ColabDAO.class.php');
require_once('../model/ComponenteDAO.class.php');
require_once('../model/EquipDAO.class.php');
require_once('../model/EscalaTrabDAO.class.php');
require_once('../model/ItemOSDAO.class.php');
require_once('../model/OSDAO.class.php');
require_once('../model/ParadaDAO.class.php');
require_once('../model/ServicoDAO.class.php');
/**
 * Description of BaseDadosCTR
 *
 * @author anderson
 */
class BaseDadosCTR {
    
    public function dadosColab($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
        
            $colabDAO = new ColabDAO();

            $dados = array("dados"=>$colabDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }
    
    public function dadosComponente($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
        
            $componenteDAO = new ComponenteDAO();

            $dados = array("dados"=>$componenteDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }
    
    public function dadosEquip($info) {

        $equipDAO = new EquipDAO();
        $atualAplicCTR = new AtualAplicCTR();

        $jsonObj = json_decode($info['dado']);
        $dados = $jsonObj->dados;

        foreach ($dados as $d) {
            $nroEquip = $d->nroEquip;
            $versao = $d->versao;
        }
        
        $dadosEquip = array("dados" => $equipDAO->dados($nroEquip));
        $resEquip = json_encode($dadosEquip);

        $v = $equipDAO->verifEquipNro($nroEquip);
        if ($v > 0) {
            $atualAplicCTR->inserirAtualVersao($equipDAO->retEquipNro($nroEquip), $versao);
        }
        
        return $resEquip;

    }
    
    public function dadosEscalaTrab($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
        
            $escalaTrabDAO = new EscalaTrabDAO();

            $dados = array("dados"=>$escalaTrabDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }
    
    public function dadosOS($info) {

        $osDAO = new OSDAO();
        $itemOSDAO = new ItemOSDAO();
        $atualAplicDAO = new AtualAplicDAO();

        $jsonObj = json_decode($info['dado']);
        $dados = $jsonObj->dados;

        foreach ($dados as $d) {
            $nroOS = $d->nroOS;
            $token = $d->token;
        }

        $v = $atualAplicDAO->verToken($token);
        
        if ($v > 0) {

            $dadosOS = array("dados" => $osDAO->dados($nroOS));
            $resOS = json_encode($dadosOS);

            $dadosItemOS = array("dados" => $itemOSDAO->dados($nroOS));
            $resItemOS = json_encode($dadosItemOS);

            return $resOS . "_" . $resItemOS;
        
        }

    }

    public function dadosParada($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
        
            $paradaDAO = new ParadaDAO();

            $dados = array("dados"=>$paradaDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }

    public function dadosServico($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
        
            $servicoDAO = new ServicoDAO();

            $dados = array("dados"=>$servicoDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }
    
}
