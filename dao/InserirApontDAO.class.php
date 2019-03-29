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
                    . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                    . " AND "
                    . " BOLETIM_ID = " . $apont->idExtBolApont . " ";

            $this->Read = $this->Conn->prepare($select);
            $this->Read->setFetchMode(PDO::FETCH_ASSOC);
            $this->Read->execute();
            $res1 = $this->Read->fetchAll();

            foreach ($res1 as $item1) {
                $v = $item1['QTDE'];
            }

            if ($v == 0) {

                if ($apont->osApont == 0) {
                    $apont->osApont = 'NULL';
                }

                if ($apont->itemOSApont == 0) {
                    $apont->itemOSApont = 'NULL';
                }

                if ($apont->paradaApont == 0) {
                    $apont->paradaApont = 'NULL';
                }

                if ($apont->dthrFinalApont == "") {

                    $sql = "INSERT INTO PBM_APONTAMENTO ("
                            . " BOLETIM_ID "
                            . " , OS_NRO "
                            . " , ITEM_OS "
                            . " , MOTPARMEC_ID "
                            . " , DTHR_CEL_INICIAL "
                            . " , DTHR_TRANS_INICIAL "
                            . " , DTHR_CEL_FINAL "
                            . " , DTHR_TRANS_FINAL "
                            . " , IND_REALIZ "
                            . " ) "
                            . " VALUES ("
                            . " " . $apont->idExtBolApont
                            . " , " . $apont->osApont
                            . " , " . $apont->itemOSApont
                            . " , " . $apont->paradaApont
                            . " , TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI')"
                            . " , SYSDATE "
                            . " , NULL "
                            . " , NULL "
                            . " , " . $apont->realizApont
                            . " )";
                } else {

                    $sql = "INSERT INTO PBM_APONTAMENTO ("
                            . " BOLETIM_ID "
                            . " , OS_NRO "
                            . " , ITEM_OS "
                            . " , MOTPARMEC_ID "
                            . " , DTHR_CEL_INICIAL "
                            . " , DTHR_TRANS_INICIAL "
                            . " , DTHR_CEL_FINAL "
                            . " , DTHR_TRANS_FINAL "
                            . " , IND_REALIZ "
                            . " ) "
                            . " VALUES ("
                            . " " . $apont->idExtBolApont
                            . " , " . $apont->osApont
                            . " , " . $apont->itemOSApont
                            . " , " . $apont->paradaApont
                            . " , TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI')"
                            . " , SYSDATE "
                            . " , TO_DATE('" . $apont->dthrFinalApont . "','DD/MM/YYYY HH24:MI')"
                            . " , SYSDATE "
                            . " , " . $apont->realizApont
                            . " )";
                }

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();
                
            } else {

                if ($apont->dthrFinalApont != "") {

                    $sql = "UPDATE PBM_APONTAMENTO"
                            . " SET "
                            . " DTHR_CEL_FINAL =  TO_DATE('" . $apont->dthrFinalApont . "','DD/MM/YYYY HH24:MI') "
                            . " , DTHR_TRANS_FINAL = SYSDATE "
                            . " , IND_REALIZ = " . $apont->realizApont
                            . " WHERE "
                            . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                            . " AND "
                            . " BOLETIM_ID = " . $apont->idExtBolApont;

                    $this->Create = $this->Conn->prepare($sql);
                    $this->Create->execute();
                }
            }
        }
    }

}
