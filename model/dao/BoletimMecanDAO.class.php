<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
require_once ('../model/dao/AjusteDataHoraDAO.class.php');

/**
 * Description of BoletimMecan
 *
 * @author anderson
 */
class BoletimMecanDAO extends Conn {

    //put your code here

    public function verifBolMecan($bol) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PBM_BOLETIM "
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " FUNC_ID = " . $bol->idFuncBolMecan . " ";

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

    public function idBolMecan($bol) {

        $select = " SELECT "
                . " ID AS ID "
                . " FROM "
                . " PBM_BOLETIM "
                . " WHERE "
                . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " AND "
                . " FUNC_ID = " . $bol->idFuncBolMecan;

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

    public function insBolMecanAberto($bol) {

        $sql = "INSERT INTO PBM_BOLETIM ("
                . " FUNC_ID "
                . " , EQUIP_ID "
                . " , DTHR_INICIAL "
                . " , DTHR_CEL_INICIAL "
                . " , DTHR_TRANS_INICIAL "
                . " , STATUS "
                . " ) "
                . " VALUES ("
                . " " . $bol->idFuncBolMecan
                . " , " . $bol->idEquipBolMecan
                . " , TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , 1 "
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function insBolMecanFechado($bol) {

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
                . " , STATUS_FECH "
                . " ) "
                . " VALUES ("
                . " " . $bol->idFuncBolMecan
                . " , " . $bol->equipBolMecan
                . " , TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $bol->dthrInicialBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , TO_DATE('" . $bol->dthrFinalBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $bol->dthrFinalBolMecan . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , 2 "
                . " , " . $bol->statusFechBoletim
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function updBolMecanFechado($bol) {

        $sql = "UPDATE PBM_BOLETIM "
                . " SET "
                . " STATUS = " . $bol->statusBolMecan
                . " , DTHR_FINAL = TO_DATE('" . $bol->dthrFinalBolMecan . "','DD/MM/YYYY HH24:MI')"
                . " , DTHR_CEL_FINAL = TO_DATE('" . $bol->dthrFinalBolMecan . "','DD/MM/YYYY HH24:MI')"
                . " , DTHR_TRANS_FINAL = SYSDATE "
                . " , STATUS_FECH = " . $bol->statusFechBolMecan
                . " WHERE "
                . " ID = " . $bol->idExtBoletim;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
        
    }

}
