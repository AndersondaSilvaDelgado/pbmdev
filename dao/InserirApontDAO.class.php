<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';

/**
 * Description of InsApontamentoMMDAO
 *
 * @author anderson
 */
class InserirApontDAO extends Conn {
    //put your code here

    /** @var PDO */
    private $Conn;

    public function salvarDados($dadosAponta) {

        $this->Conn = parent::getConn();

        foreach ($dadosAponta as $apont) {

            $select = " SELECT "
                    . " COUNT(*) AS QTDE "
                    . " FROM "
                    . " PBM_APONTAMENTO "
                    . " WHERE "
                    . " DTHR_CEL = TO_DATE('" . $apont->dthrAponta . "','DD/MM/YYYY HH24:MI') "
                    . " AND "
                    . " BOLETIM_ID = " . $apont->idExtBolAponta . " ";

            $this->Read = $this->Conn->prepare($select);
            $this->Read->setFetchMode(PDO::FETCH_ASSOC);
            $this->Read->execute();
            $res1 = $this->Read->fetchAll();

            foreach ($res1 as $item1) {
                $v = $item1['QTDE'];
            }

            if ($v == 0) {

                $sql = "INSERT INTO PBM_APONTAMENTO ("
                        . " BOLETIM_ID "
                        . " , OS_NRO "
                        . " , ATIVAGR_ID "
                        . " , MOTPARADA_ID "
                        . " , DTHR_CEL "
                        . " , DTHR_TRANS "
                        . " , IND_REALIZ "
                        . " ) "
                        . " VALUES ("
                        . " " . $apont->idExtBolAponta
                        . " , " . $apont->osAponta
                        . " , " . $apont->itemOSAponta
                        . " , " . $apont->paradaAponta
                        . " , TO_DATE('" . $apont->dthrAponta . "','DD/MM/YYYY HH24:MI')"
                        . " , SYSDATE "
                        . " , 0 "
                        . " )";

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();
                
            } elseif (($v > 0) && ($apont->statusAponta == 3)) {

                $sql = "UPDATE PBM_APONTAMENTO"
                        . " SET IND_REALIZ = 1 "
                        . " WHERE "
                        . " DTHR_CEL = TO_DATE('" . $apont->dthrAponta . "','DD/MM/YYYY HH24:MI') "
                        . " AND "
                        . " BOLETIM_ID = " . $apont->idExtBolAponta . " ";

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();
            }
        }
    }

}
