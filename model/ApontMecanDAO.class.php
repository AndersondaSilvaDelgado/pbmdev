<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
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
                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
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

        if ($apont->nroOSApontMecan == 0) {
            $apont->nroOSApontMecan = 'NULL';
        }

        if ($apont->itemOSApontMecan == 0) {
            $apont->itemOSApontMecan = 'NULL';
        }

        if ($apont->paradaApontMecan == 0) {
            $apont->paradaApontMecan = 'NULL';
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
                . " , " . $apont->nroOSApontMecan
                . " , " . $apont->itemOSApontMecan
                . " , " . $apont->paradaApontMecan
                . " , TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , NULL "
                . " , NULL "
                . " , NULL "
                . " , " . $apont->realizApontMecan
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function insApontMecanFechado($idBol, $apont) {

        if ($apont->nroOSApontMecan == 0) {
            $apont->nroOSApontMecan = 'NULL';
        }

        if ($apont->itemOSApontMecan == 0) {
            $apont->itemOSApontMecan = 'NULL';
        }

        if ($apont->paradaApontMecan == 0) {
            $apont->paradaApontMecan = 'NULL';
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
                . " , " . $apont->nroOSApontMecan
                . " , " . $apont->itemOSApontMecan
                . " , " . $apont->paradaApontMecan
                . " , TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , TO_DATE('" . $apont->dthrFinalApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $apont->dthrFinalApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , " . $apont->realizApontMecan
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function updApontMecan($idBol, $apont) {

        $sql = "UPDATE PBM_APONTAMENTO"
                . " SET "
                . " DTHR_FINAL = TO_DATE('" . $apont->dthrFinalApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , DTHR_CEL_FINAL = TO_DATE('" . $apont->dthrFinalApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " , DTHR_TRANS_FINAL = SYSDATE "
                . " , IND_REALIZ = " . $apont->realizApontMecan
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApontMecan . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " BOLETIM_ID = " . $idBol;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
