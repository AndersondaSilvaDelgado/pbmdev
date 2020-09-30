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

    public function verAtual($equip, $base) {

        $select = "SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PBM_ATUALIZACAO "
                . " WHERE "
                . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $v = $item['QTDE'];
        }

        return $v;
    }
    
    public function insAtual($equip, $va, $base) {

        $sql = "INSERT INTO PBM_ATUALIZACAO ("
                . " EQUIP_ID "
                . " , VERSAO_ATUAL "
                . " , VERSAO_NOVA "
                . " , DTHR_ULT_ATUAL "
                . " ) "
                . " VALUES ("
                . " " . $equip
                . " , TRIM(TO_CHAR(" . $va . ", '99999999D99')) "
                . " , TRIM(TO_CHAR(" . $va . ", '99999999D99')) "
                . " , SYSDATE "
                . " )";

        $this->Conn = parent::getConn($base);
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function retAtual($equip, $base) {

        $select = " SELECT "
                    . " VERSAO_NOVA "
                    . " , VERSAO_ATUAL"
                    . " FROM "
                    . " PBM_ATUALIZACAO "
                    . " WHERE "
                    . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }

    public function updAtualNova($equip, $va, $base) {

        $sql = "UPDATE PBM_ATUALIZACAO "
                        . " SET "
                        . " VERSAO_ATUAL = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                        . " , VERSAO_NOVA = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                        . " , DTHR_ULT_ATUAL = SYSDATE "
                        . " WHERE "
                        . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn($base);
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function updAtual($equip, $va, $base) {

        $sql = "UPDATE PBM_ATUALIZACAO "
                    . " SET "
                    . " VERSAO_ATUAL = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                    . " , DTHR_ULT_ATUAL = SYSDATE "
                    . " WHERE "
                    . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn($base);
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

    public function dataHora($base) {

        $select = " SELECT "
                . " TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI') AS DTHR "
                . " FROM "
                . " DUAL ";

        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result1 = $this->Read->fetchAll();

        foreach ($result1 as $item) {
            $dthr = $item['DTHR'];
        }

        return $dthr;
    }
    
    public function verAtualAplic($dados) {

        foreach ($dados as $d) {
            $equip = $d->idEquipAtual;
            $va = $d->versaoAtual;
        }

        $retorno = 'NAO=2_';

        if ($v == 0) {

            $sql = "INSERT INTO PBM_ATUALIZACAO ("
                    . " EQUIP_ID "
                    . " , VERSAO_ATUAL "
                    . " , VERSAO_NOVA "
                    . " , DTHR_ULT_ATUAL "
                    . " ) "
                    . " VALUES ("
                    . " " . $equip
                    . " , TRIM(TO_CHAR(" . $va . ", '99999999D99')) "
                    . " , TRIM(TO_CHAR(" . $va . ", '99999999D99')) "
                    . " , SYSDATE "
                    . " )";

            $this->Create = $this->Conn->prepare($sql);
            $this->Create->execute();
            
        } else {

            $select = " SELECT "
                    . " VERSAO_NOVA "
                    . " , VERSAO_ATUAL"
                    . " FROM "
                    . " PBM_ATUALIZACAO "
                    . " WHERE "
                    . " EQUIP_ID = " . $equip;

            $this->Read = $this->Conn->prepare($select);
            $this->Read->setFetchMode(PDO::FETCH_ASSOC);
            $this->Read->execute();
            $result = $this->Read->fetchAll();

            foreach ($result as $item) {
                $vn = $item['VERSAO_NOVA'];
                $vab = $item['VERSAO_ATUAL'];
            }

            if ($va != $vab) {

                $sql = "UPDATE PBM_ATUALIZACAO "
                        . " SET "
                        . " VERSAO_ATUAL = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                        . " , VERSAO_NOVA = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                        . " , DTHR_ULT_ATUAL = SYSDATE "
                        . " WHERE "
                        . " EQUIP_ID = " . $equip;

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();
                
            } else {

                if ($va != $vn) {
                    $retorno = 'SIM';
                } else {

                    if (strcmp($va, $vab) <> 0) {

                        $sql = "UPDATE PBM_ATUALIZACAO "
                                . " SET "
                                . " VERSAO_ATUAL = TRIM(TO_CHAR(" . $va . ", '99999999D99'))"
                                . " , DTHR_ULT_ATUAL = SYSDATE "
                                . " WHERE "
                                . " EQUIP_ID = " . $equip;

                        $this->Create = $this->Conn->prepare($sql);
                        $this->Create->execute();
                        
                    }
                    
                }
            }
        }

        return $retorno;
    }

}
