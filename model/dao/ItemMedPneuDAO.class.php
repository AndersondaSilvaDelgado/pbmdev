<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './dbutil/Conn.class.php';
require_once 'AjusteDataHoraDAO.class.php';

/**
 * Description of ItemMedPneu
 *
 * @author anderson
 */
class ItemMedPneuDAO extends Conn {

    public function verifItemMedPneu($idBolPneu, $itemMedPneu) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PMP_ITEM_MED "
                . " WHERE "
                . " BOLETIM_ID = " . $idBolPneu
                . " AND "
                . " NRO_PNEU LIKE '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                . " AND "
                . " DTHR_CEL = TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') ";

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

    public function insItemMedPneu($idBolPneu, $itemMedPneu) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "INSERT INTO PMP_ITEM_MED ("
                . " BOLETIM_ID "
                . " , POSPNCONF_ID "
                . " , NRO_PNEU "
                . " , PRESSAO_ENC "
                . " , PRESSAO_COL "
                . " , DTHR "
                . " , DTHR_CEL "
                . " , DTHR_TRANS "
                . " ) "
                . " VALUES ("
                . " " . $idBolPneu
                . " , " . $itemMedPneu->posItemMedPneu
                . " , '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                . " , " . $itemMedPneu->pressaoEncItemMedPneu
                . " , " . $itemMedPneu->pressaoColItemMedPneu
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemMedPneu->dthrItemMedPneu)
                . " , TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
