<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';
/**
 * Description of REquipPneu
 *
 * @author anderson
 */
class REquipPneuDAO extends Conn {
    //put your code here
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados() {

        $select = " SELECT "
                . " ROWNUM AS \"idREquipPneu\" "
                . " , VEP.EQUIP_ID AS \"idEquip\" "
                . " , VEP.POSPNCONF_ID AS \"idPosConfPneu\" "
                . " , VEP.POS_PNEU AS \"posPneu\" "
                . " FROM "
                . " VMB_EQUIP_PNEU VEP ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
    
}
