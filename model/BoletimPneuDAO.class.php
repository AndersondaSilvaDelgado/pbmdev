<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of BoletimPneu
 *
 * @author anderson
 */
class BoletimPneuDAO extends Conn {

    //put your code here

    public function verifBoletimPneu($bolPneu) {

        $select = " SELECT "
                        . " COUNT(*) AS QTDE "
                    . " FROM "
                        . " PMP_BOLETIM "
                    . " WHERE "
                        . " CEL_ID = " . $bolPneu->idBolPneu
                        . " AND "
                        . " DTHR_CEL = TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') ";

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

    public function idBoletimPneu($bolPneu) {

        $select = " SELECT "
                        . " ID AS ID "
                    . " FROM "
                        . " PMP_BOLETIM "
                    . " WHERE "
                        . " CEL_ID = " . $bolPneu->idBolPneu
                        . " AND "
                        . " DTHR_CEL = TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') ";

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

    public function insBoletimPneu($bolPneu, $tipoAplic) {

        $sql = "INSERT INTO PMP_BOLETIM ("
                            . " FUNC_ID "
                            . " , EQUIP_ID "
                            . " , DTHR "
                            . " , DTHR_CEL "
                            . " , DTHR_TRANS "
                            . " , TIPO_APLIC "
                            . " , CEL_ID "
                            . " ) "
                        . " VALUES ("
                            . " " . $bolPneu->idFuncBolPneu
                            . " , " . $bolPneu->idEquipBolPneu
                            . " , TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') "
                            . " , TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') "
                            . " , SYSDATE "
                            . " , " . $tipoAplic
                            . " , " . $bolPneu->idBolPneu
                            . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
