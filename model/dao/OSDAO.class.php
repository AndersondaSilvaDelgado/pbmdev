<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./dbutil/Conn.class.php');
/**
 * Description of OSDAO
 *
 * @author anderson
 */
class OSDAO extends Conn {
    //put your code here
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($os) {

        $select = " SELECT "
                    . " OS_ID AS \"idOS\" "
                    . " , NRO AS \"nroOS\" "
                    . " , NRO_EQUIP AS \"equipOS\" "
                    . " , DESCR AS \"descrEquipOS\" "
                . " FROM "
                    . " VMB_OS_AUTO "
                . " WHERE "
                    . " NRO = " . $os;

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
    
}
