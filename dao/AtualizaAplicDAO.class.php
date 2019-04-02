<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';

/**
 * Description of AtualizaAplicDAO
 *
 * @author anderson
 */
class AtualizaAplicDAO extends Conn {

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function pesqInfo($dados) {

        foreach ($dados as $d) {

            $equip = $d->idEquipAtualizacao;
            $va = $d->versaoAtual;
        }

        $retorno = 'NAO=2_';

        $select = "SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PBM_ATUALIZACAO "
                . " WHERE "
                . " EQUIP_ID = " . $equip;

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $v = $item['QTDE'];
        }

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
