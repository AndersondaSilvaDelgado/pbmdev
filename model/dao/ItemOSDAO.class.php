<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of ItemOSDAO
 *
 * @author anderson
 */
class ItemOSDAO extends Conn {
    //put your code here

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($os, $base) {

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
                . " OS.NRO = " . $os
                . " AND I.OS_ID = OS.OS_ID ";

        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }

}
