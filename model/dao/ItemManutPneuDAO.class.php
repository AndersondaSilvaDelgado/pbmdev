<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
require_once ('../model/dao/AjusteDataHoraDAO.class.php');
/**
 * Description of ItemManutPneuDAO
 *
 * @author anderson
 */
class ItemManutPneuDAO extends Conn {

    //put your code here

    public function verifItemManutPneu($idBolPneu, $itemManutPneu) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PMP_ITEM_MANUT "
                . " WHERE "
                . " BOLETIM_ID = " . $idBolPneu
                . " AND "
                . " POSPNCONF_ID  = " . $itemManutPneu->posItemManutPneu
                . " AND "
                . " NRO_PNEU_RET LIKE '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                . " AND "
                . " NRO_PNEU_COL LIKE '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                . " AND "
                . " DTHR_CEL = TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') ";

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

    public function insItemManutPneu($idBolPneu, $itemManutPneu) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "INSERT INTO PMP_ITEM_MANUT ("
                . " BOLETIM_ID "
                . " , POSPNCONF_ID "
                . " , NRO_PNEU_RET "
                . " , NRO_PNEU_COL "
                . " , DTHR "
                . " , DTHR_CEL "
                . " , DTHR_TRANS "
                . " ) "
                . " VALUES ("
                . " " . $idBolPneu
                . " , " . $itemManutPneu->posItemManutPneu
                . " , '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                . " , '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemManutPneu->dthrItemManutPneu)
                . " , TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
