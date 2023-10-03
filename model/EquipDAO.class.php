<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of EquipDAO
 *
 * @author anderson
 */
class EquipDAO extends Conn  {
    //put your code here
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($nroEquip) {

        $select = " SELECT " 
                        . " E.EQUIP_ID AS \"idEquip\" "
                        . " , E.NRO_EQUIP AS \"nroEquip\""
                        . " , CARACTER(CO.DESCR) AS \"descrClasseEquip\""
                    . " FROM "
                        . " USINAS.EQUIP E"
                        . " , USINAS.CLASSE_OPER CO "
                    . " WHERE " 
                        . " E.NRO_EQUIP = " . $nroEquip
                        . " AND "
                        . " DT_DESAT IS NULL "
                        . " AND "
                        . " E.CLASSOPER_ID = CO.CLASSOPER_ID ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
    
    public function verifEquipNro($nroEquip) {

        $select = " SELECT " 
                        . " E.EQUIP_ID AS \"idEquip\" "
                        . " , E.NRO_EQUIP AS \"nroEquip\""
                        . " , CARACTER(CO.DESCR) AS \"descrClasseEquip\""
                    . " FROM "
                        . " USINAS.EQUIP E"
                        . " , USINAS.CLASSE_OPER CO "
                    . " WHERE " 
                        . " E.NRO_EQUIP = " . $nroEquip
                        . " AND "
                        . " DT_DESAT IS NULL "
                        . " AND "
                        . " E.CLASSOPER_ID = CO.CLASSOPER_ID ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
        
    public function retEquipNro($nroEquip) {

        $select = " SELECT " 
                        . " E.EQUIP_ID AS ID "
                    . " FROM "
                        . " USINAS.EQUIP E"
                        . " , USINAS.CLASSE_OPER CO "
                    . " WHERE " 
                        . " E.NRO_EQUIP = " . $nroEquip
                        . " AND "
                        . " DT_DESAT IS NULL "
                        . " AND "
                        . " E.CLASSOPER_ID = CO.CLASSOPER_ID ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $id = $item['ID'];
        }

        return $id;
    }
}
