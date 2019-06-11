<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './dbutil/Conn.class.php';
require_once './model/dao/AjusteDataHoraDAO.class.php';

/**
 * Description of ApontMecanDAO
 *
 * @author anderson
 */
class ApontMecanDAO extends Conn {

    //put your code here

    public function verifApontMecan($idBol, $apont) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PBM_APONTAMENTO "
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " BOLETIM_ID = " . $idBol;

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

    public function insApontMecanAberto($idBol, $apont) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        if ($apont->osApont == 0) {
            $apont->osApont = 'NULL';
        }

        if ($apont->itemOSApont == 0) {
            $apont->itemOSApont = 'NULL';
        }

        if ($apont->paradaApont == 0) {
            $apont->paradaApont = 'NULL';
        }

        $sql = "INSERT INTO PBM_APONTAMENTO ("
                . " BOLETIM_ID "
                . " , OS_NRO "
                . " , ITEM_OS "
                . " , MOTPARMEC_ID "
                . " , DTHR_INICIAL "
                . " , DTHR_CEL_INICIAL "
                . " , DTHR_TRANS_INICIAL "
                . " , DTHR_FINAL "
                . " , DTHR_CEL_FINAL "
                . " , DTHR_TRANS_FINAL "
                . " , IND_REALIZ "
                . " ) "
                . " VALUES ("
                . " " . $idBol
                . " , " . $apont->osApont
                . " , " . $apont->itemOSApont
                . " , " . $apont->paradaApont
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($apont->dthrInicialApont)
                . " , TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI')"
                . " , SYSDATE "
                . " , NULL "
                . " , NULL "
                . " , NULL "
                . " , " . $apont->realizApont
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function insApontMecanFechado($idBol, $apont) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        if ($apont->osApont == 0) {
            $apont->osApont = 'NULL';
        }

        if ($apont->itemOSApont == 0) {
            $apont->itemOSApont = 'NULL';
        }

        if ($apont->paradaApont == 0) {
            $apont->paradaApont = 'NULL';
        }

        $sql = "INSERT INTO PBM_APONTAMENTO ("
                . " BOLETIM_ID "
                . " , OS_NRO "
                . " , ITEM_OS "
                . " , MOTPARMEC_ID "
                . " , DTHR_INICIAL "
                . " , DTHR_CEL_INICIAL "
                . " , DTHR_TRANS_INICIAL "
                . " , DTHR_FINAL "
                . " , DTHR_CEL_FINAL "
                . " , DTHR_TRANS_FINAL "
                . " , IND_REALIZ "
                . " ) "
                . " VALUES ("
                . " " . $idBol
                . " , " . $apont->osApont
                . " , " . $apont->itemOSApont
                . " , " . $apont->paradaApont
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($apont->dthrInicialApont)
                . " , TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI')"
                . " , SYSDATE "
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($apont->dthrFinalApont)
                . " , TO_DATE('" . $apont->dthrFinalApont . "','DD/MM/YYYY HH24:MI')"
                . " , SYSDATE "
                . " , " . $apont->realizApont
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function updateApontMecan($idBol, $apont) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "UPDATE PBM_APONTAMENTO"
                . " SET "
                . " DTHR_FINAL = " . $ajusteDataHoraDAO->dataHoraGMT($apont->dthrFinalApont)
                . " , DTHR_CEL_FINAL = TO_DATE('" . $apont->dthrFinalApont . "','DD/MM/YYYY HH24:MI') "
                . " , DTHR_TRANS_FINAL = SYSDATE "
                . " , IND_REALIZ = " . $apont->realizApont
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " BOLETIM_ID = " . $idBol;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
