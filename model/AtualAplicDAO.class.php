<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of AtualizaAplicDAO
 *
 * @author anderson
 */
class AtualAplicDAO extends Conn {

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function verAtual($idEquip) {

        $select = "SELECT "
                        . " COUNT(*) AS QTDE "
                    . " FROM "
                        . " PBM_ATUAL "
                    . " WHERE "
                        . " EQUIP_ID = " . $idEquip;

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
        
    public function verToken($token) {

        $select = "SELECT "
                    . " COUNT(*) AS QTDE "
                . " FROM "
                    . " PBM_ATUAL "
                . " WHERE "
                    . " TOKEN = '" . $token . "'";

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

    public function insAtual($idEquip, $versao) {

        $sql = "INSERT INTO PBM_ATUAL ("
                                . " EQUIP_ID "
                                . " , VERSAO "
                                . " , DTHR_ULT_ACESSO "
                                . " , TOKEN "
                                . " ) "
                            . " VALUES ("
                                . " " . $idEquip
                                . " , '" . $versao . "'"
                                . " , SYSDATE "
                                . " , '" . strtoupper(md5('PBM-VERSAO_' . $versao . '-' . $idEquip)) . "'"
                            . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function retAtual($equip) {

        $select = " SELECT "
                        . " VERSAO "
                    . " FROM "
                        . " PBM_ATUAL "
                    . " WHERE "
                        . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }

    public function updAtual($idEquip, $versao) {

        $sql = "UPDATE PBM_ATUAL "
                            . " SET "
                                . " VERSAO = '" . $versao . "'"
                                . " , DTHR_ULT_ACESSO = SYSDATE "
                                . " , TOKEN = '" . strtoupper(md5('PBM-VERSAO_' . $versao . '-' . $idEquip)) . "'"
                            . " WHERE "
                                . " EQUIP_ID = " . $idEquip;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
        
    }
    
    public function updUltAcesso($idEquip) {

        $sql = "UPDATE PBM_ATUAL "
                        . " SET "
                            . " DTHR_ULT_ACESSO = SYSDATE "
                        . " WHERE "
                            . " EQUIP_ID = " . $idEquip;

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function dataHora() {

        $select = " SELECT "
                            . " TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI') AS DTHR "
                        . " FROM "
                            . " DUAL ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result1 = $this->Read->fetchAll();

        foreach ($result1 as $item) {
            $dthr = $item['DTHR'];
        }

        return $dthr;
    }

}
