<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';

/**
 * Description of InsBolFechadoMMDAO
 *
 * @author anderson
 */
class InsBolFechadoDAO extends Conn {
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
                    . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicioBoletim . "','DD/MM/YYYY HH24:MI') "
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
                        . " , DTHR_INICIAL_CEL "
                        . " , DTHR_TRANS_INICIAL "
                        . " , STATUS "
                        . " ) "
                        . " VALUES ("
                        . " " . $bol->idFuncBoletim
                        . " , TO_DATE('" . $bol->dthrInicioBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " , SYSDATE "
                        . " , 2 "
                        . " )";

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();

                $select = " SELECT "
                        . " ID AS ID "
                        . " FROM "
                        . " PBM_BOLETIM "
                        . " WHERE "
                        . " DTHR_INICIAL_CEL = TO_DATE('" . $bol->dthrInicioBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " AND "
                        . " FUNC_ID = " . $bol->idFuncBoletim . " ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res2 = $this->Read->fetchAll();

                foreach ($res2 as $item2) {
                    $idBol= $item2['ID'];
                }

                foreach ($dadosAponta as $apont) {

                    if ($bol->idBoletim == $apont->idBolAponta) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PBM_APONTAMENTO "
                                . " WHERE "
                                . " DTHR_CEL = TO_DATE('" . $apont->dthrAponta . "','DD/MM/YYYY HH24:MI') "
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
                                    . " " . $idBol
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
                                    . " BOLETIM_ID = " . $idBol . " ";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                            
                        }
                        
                    }
                    
                }
                
            } else {

                $sql = "UPDATE PBM_BOLETIM "
                        . " SET "
                        . " STATUS = " . $bol->statusBoletim
                        . " , DTHR_CEL_FINAL = TO_DATE('" . $bol->dthrFimBoletim . "','DD/MM/YYYY HH24:MI')"
                        . " , DTHR_TRANS_FINAL = SYSDATE "
                        . " WHERE "
                        . " ID = " . $bol->idExtBoletim;

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();

                $select = " SELECT "
                        . " ID AS ID "
                        . " FROM "
                        . " PBM_BOLETIM "
                        . " WHERE "
                        . " DTHR_CEL_INICIAL = TO_DATE('" . $bol->dthrInicioBoletim . "','DD/MM/YYYY HH24:MI') "
                        . " AND "
                        . " FUNC_ID = " . $bol->idFuncBoletim . " ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res10 = $this->Read->fetchAll();

                foreach ($res10 as $item10) {
                    $idBol = $item10['ID'];
                }

                foreach ($dadosAponta as $apont) {

                    if ($bol->idBoletim == $apont->idBolAponta) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PBM_APONTAMENTO "
                                . " WHERE "
                                . " DTHR_CEL = TO_DATE('" . $apont->dthrAponta . "','DD/MM/YYYY HH24:MI') "
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
                                    . " " . $idBol
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
                                    . " BOLETIM_ID = " . $idBol . " ";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                            
                        }
                        
                    }
                    
                }

            }
        }

        return 'GRAVOU-BOLFECHADO';
    }

}
