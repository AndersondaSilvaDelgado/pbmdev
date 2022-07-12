<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of ItemMedPneu
 *
 * @author anderson
 */
class ItemCalibPneuDAO extends Conn {

    public function verifItemCalibPneu($idBolPneu, $itemCalibPneu) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PMP_ITEM_MED "
                . " WHERE "
                . " BOLETIM_ID = " . $idBolPneu
                . " AND "
                . " CEL_ID = " . $itemCalibPneu->idItemCalibPneu;

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $v = $item['QTDE'];
        }

        return $v;
    }

    public function insItemCalibPneu($idBolPneu, $itemCalibPneu) {

        $sql = "INSERT INTO PMP_ITEM_MED ("
                . " BOLETIM_ID "
                . " , POSPNCONF_ID "
                . " , NRO_PNEU "
                . " , PRESSAO_ENC "
                . " , PRESSAO_COL "
                . " , DTHR "
                . " , DTHR_CEL "
                . " , DTHR_TRANS "
                . " , CEL_ID "
                . " ) "
                . " VALUES ("
                . " " . $idBolPneu
                . " , " . $itemCalibPneu->idPosItemCalibPneu
                . " , '" . $itemCalibPneu->nroPneuItemCalibPneu . "'"
                . " , " . $itemCalibPneu->pressaoEncItemCalibPneu
                . " , " . $itemCalibPneu->pressaoColItemCalibPneu
                . " , TO_DATE('" . $itemCalibPneu->dthrItemCalibPneu . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $itemCalibPneu->dthrItemCalibPneu . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , " . $itemCalibPneu->idItemCalibPneu
                . " ) ";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
