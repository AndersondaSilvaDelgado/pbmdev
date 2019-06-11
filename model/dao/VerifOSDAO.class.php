<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';
/**
 * Description of VerOSDAO
 *
 * @author anderson
 */
class VerifOSDAO extends Conn {
    //put your code here
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($valor) {
        
        $select = " SELECT "
                    . " OS_ID AS \"idOS\" "
                    . " , NRO AS \"nroOS\" "
                    . " , NRO_EQUIP AS \"equipOS\" "
                    . " , DESCR AS \"descrEquipOS\" "
                . " FROM "
                    . " VMB_OS_AUTO "
                . " WHERE "
                    . " NRO = " . $valor;
        
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r1 = $this->Read->fetchAll();

        $dados = array("dados"=>$r1);
        $res1 = json_encode($dados);
        
        $select = " SELECT "
                . " I.ITOSMECAN_ID AS \"idItemOS\" "
                . " , I.OS_ID AS \"idOS\" "
                . " , I.ITEM_OS AS \"seqItemOS\" "
                . " , I.SERVICO_ID AS \"idServItemOS\" "
                . " , I.COMPONENTE_ID AS \"idCompItemOS\" "
                . " FROM "
                . " USINAS.VMB_OS_AUTO OS "
                . " , USINAS.VMB_ITEM_OS_AUTO I "
                . " WHERE "
                . " OS.NRO = " . $valor
                . " AND I.OS_ID = OS.OS_ID ";
        
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r2 = $this->Read->fetchAll();
        
        $dados = array("dados"=>$r2);
        $res2 = json_encode($dados);
        
        return $res1 . "#" . $res2;
    }
    
}
