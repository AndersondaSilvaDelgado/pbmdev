<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './dbutil/Conn.class.php';
require_once './model/dao/AjusteDataHoraDAO.class.php';

/**
 * Description of BoletimMecan
 *
 * @author anderson
 */
class BoletimMecanDAO extends Conn {

    //put your code here

    public function verifBoletimMecan($bol) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PBM_BOLETIM "
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " FUNC_ID = " . $bol->idFuncBoletim . " ";

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

    public function idBoletimMecan($bol) {

        $select = " SELECT "
                . " ID AS ID "
                . " FROM "
                . " PBM_BOLETIM "
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " FUNC_ID = " . $bol->idFuncBoletim;

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

    public function insBoletimMecanAberto($bol) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "INSERT INTO PBM_BOLETIM ("
                . " FUNC_ID "
                . " , EQUIP_ID "
                . " , DTHR_INICIAL "
                . " , DTHR_CEL_INICIAL "
                . " , DTHR_TRANS_INICIAL "
                . " , STATUS "
                . " ) "
                . " VALUES ("
                . " " . $bol->idFuncBoletim
                . " , " . $bol->equipBoletim
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($bol->dthrInicialBoletim)
                . " , TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , 1 "
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function insBoletimMecanFechado($bol) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "INSERT INTO PBM_BOLETIM ("
                . " FUNC_ID "
                . " , EQUIP_ID "
                . " , DTHR_INICIAL "
                . " , DTHR_CEL_INICIAL "
                . " , DTHR_TRANS_INICIAL "
                . " , DTHR_FINAL "
                . " , DTHR_CEL_FINAL "
                . " , DTHR_TRANS_FINAL "
                . " , STATUS "
                . " ) "
                . " VALUES ("
                . " " . $bol->idFuncBoletim
                . " , " . $bol->equipBoletim
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($bol->dthrInicialBoletim)
                . " , TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , " . $ajusteDataHoraDAO->dataHoraGMT($bol->dthrFinalBoletim)
                . " , TO_DATE('" . $bol->dthrFinalBoletim . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , 2 "
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function updateBoletimMecanFechado($bol) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $sql = "UPDATE PBM_BOLETIM "
                . " SET "
                . " STATUS = " . $bol->statusBoletim
                . " , DTHR_FINAL = " . $ajusteDataHoraDAO->dataHoraGMT($bol->dthrFinalBoletim)
                . " , DTHR_CEL_FINAL = TO_DATE('" . $bol->dthrFinalBoletim . "','DD/MM/YYYY HH24:MI')"
                . " , DTHR_TRANS_FINAL = SYSDATE "
                . " WHERE "
                . " ID = " . $bol->idExtBoletim;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
        
    }

}
