<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';

/**
 * Description of InserirBoletimAberto
 *
 * @author anderson
 */
class InserirBolAbertoDAO extends Conn {
    //put your code here

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function salvarDados($dadosBoletim, $dadosAponta) {

        $this->Conn = parent::getConn();

        foreach ($dadosBoletim as $bol) {

            $select = " SELECT "
                    . " COUNT(*) AS QTDE "
                    . " FROM "
                    . " PBM_BOLETIM "
                    . " WHERE "
                    . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                    . " AND "
                    . " FUNC_ID = " . $bol->idFuncBoletim . " ";

            $this->Read = $this->Conn->prepare($select);
            $this->Read->setFetchMode(PDO::FETCH_ASSOC);
            $this->Read->execute();
            $res1 = $this->Read->fetchAll();

            foreach ($res1 as $item1) {
                $v = $item1['QTDE'];
            }

            if ($v == 0) {

                $sql = "INSERT INTO PBM_BOLETIM ("
                        . " FUNC_ID "
                        . " , DTHR_CEL_INICIAL "
                        . " , DTHR_TRANS_INICIAL "
                        . " , STATUS "
                        . " ) "
                        . " VALUES ("
                        . " " . $bol->idFuncBoletim
                        . " , TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " , SYSDATE "
                        . " , 1 "
                        . " )";

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();

                $select = " SELECT "
                        . " ID AS ID "
                        . " FROM "
                        . " PBM_BOLETIM "
                        . " WHERE "
                        . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " AND "
                        . " FUNC_ID = " . $bol->idFuncBoletim . " ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res2 = $this->Read->fetchAll();

                foreach ($res2 as $item2) {
                    $idBol = $item2['ID'];
                }

                foreach ($dadosAponta as $apont) {

                    if ($bol->idBoletim == $apont->idBolApont) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PBM_APONTAMENTO "
                                . " WHERE "
                                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                                . " AND "
                                . " BOLETIM_ID = " . $idBol . " ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res3 = $this->Read->fetchAll();

                        foreach ($res3 as $item3) {
                            $v = $item3['QTDE'];
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
                                        . " " . $idBol
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
                                        . " " . $idBol
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
                                        . " BOLETIM_ID = " . $idBol . " ";

                                $this->Create = $this->Conn->prepare($sql);
                                $this->Create->execute();
                            }
                        }
                    }
                }
            } else {

                $select = " SELECT "
                        . " ID AS ID "
                        . " FROM "
                        . " PBM_BOLETIM "
                        . " WHERE "
                        . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicialBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " AND "
                        . " FUNC_ID = " . $bol->idFuncBoletim . " ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res9 = $this->Read->fetchAll();

                foreach ($res9 as $item9) {
                    $idBol = $item9['ID'];
                }

                foreach ($dadosAponta as $apont) {

                    if ($bol->idBoletim == $apont->idBolApont) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PBM_APONTAMENTO "
                                . " WHERE "
                                . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialApont . "','DD/MM/YYYY HH24:MI') "
                                . " AND "
                                . " BOLETIM_ID = " . $idBol . " ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res10 = $this->Read->fetchAll();

                        foreach ($res10 as $item10) {
                            $v = $item10['QTDE'];
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
                                        . " " . $idBol
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
                                        . " " . $idBol
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
                                        . " DTHR_CEL_FINAL =  TO_DATE('" . $apont->dthrFinalAponta . "','DD/MM/YYYY HH24:MI') "
                                        . " , DTHR_TRANS_FINAL = SYSDATE "
                                        . " , IND_REALIZ = " . $apont->realizAponta
                                        . " WHERE "
                                        . " DTHR_CEL_INICIAL = TO_DATE('" . $apont->dthrInicialAponta . "','DD/MM/YYYY HH24:MI') "
                                        . " AND "
                                        . " BOLETIM_ID = " . $idBol . " ";

                                $this->Create = $this->Conn->prepare($sql);
                                $this->Create->execute();
                            }
                        }
                    }
                }
            }

            $dados[] = array(
                "idBoletim" => $bol->idBoletim,
                "idExtBoletim" => $idBol
            );
        }

        $json_str = "BOLETIMABERTO#" . json_encode(array("dados" => $dados)) . "_";

        return $json_str;
    }

}
