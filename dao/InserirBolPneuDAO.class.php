<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';
require_once 'AjusteDataHoraDAO.class.php';

/**
 * Description of InserirBolPneu
 *
 * @author anderson
 */
class InserirBolPneuDAO extends Conn {
    //put your code here

    /** @var PDO */
    private $Conn;

    public function salvarDados($dadosBolPneu, $dadosItemMedPneu, $dadosItemManutPneu) {

        $this->Conn = parent::getConn();

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        foreach ($dadosBolPneu as $bolPneu) {

            $select = " SELECT "
                    . " COUNT(*) AS QTDE "
                    . " FROM "
                    . " PMP_BOLETIM "
                    . " WHERE "
                    . " FUNC_MATRIC = " . $bolPneu->funcBolPneu
                    . " AND "
                    . " EQUIP_ID = " . $bolPneu->equipBolPneu
                    . " AND "
                    . " DTHR_CEL = TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') ";

            $this->Read = $this->Conn->prepare($select);
            $this->Read->setFetchMode(PDO::FETCH_ASSOC);
            $this->Read->execute();
            $res7 = $this->Read->fetchAll();

            foreach ($res7 as $item7) {
                $v = $item7['QTDE'];
            }

            if ($v == 0) {

                $sql = "INSERT INTO PMP_BOLETIM ("
                        . " FUNC_MATRIC "
                        . " , EQUIP_ID "
                        . " , DTHR "
                        . " , DTHR_CEL "
                        . " , DTHR_TRANS "
                        . " ) "
                        . " VALUES ("
                        . " " . $bolPneu->funcBolPneu
                        . " , " . $bolPneu->equipBolPneu
                        . " , " . $ajusteDataHoraDAO->dataHoraGMT($bolPneu->dthrBolPneu)
                        . " , TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') "
                        . " , SYSDATE "
                        . " )";

                $this->Create = $this->Conn->prepare($sql);
                $this->Create->execute();

                $select = " SELECT "
                        . " ID AS IDBOLPNEU "
                        . " FROM "
                        . " PMP_BOLETIM "
                        . " WHERE "
                        . " FUNC_MATRIC = " . $bolPneu->funcBolPneu
                        . " AND "
                        . " EQUIP_ID = " . $bolPneu->equipBolPneu
                        . " AND "
                        . " DTHR_CEL = TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res8 = $this->Read->fetchAll();

                foreach ($res8 as $item8) {
                    $idBolPneu = $item8['IDBOLPNEU'];
                }

                foreach ($dadosItemMedPneu as $itemMedPneu) {

                    if ($bolPneu->idBolPneu == $itemMedPneu->idBolItemMedPneu) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PMP_ITEM_MED "
                                . " WHERE "
                                . " BOLETIM_ID = " . $idBolPneu
                                . " AND "
                                . " NRO_PNEU LIKE '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                                . " AND "
                                . " DTHR_CEL = TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res9 = $this->Read->fetchAll();

                        foreach ($res9 as $item9) {
                            $v = $item9['QTDE'];
                        }

                        if ($v == 0) {

                            $sql = "INSERT INTO PMP_ITEM_MED ("
                                    . " BOLETIM_ID "
                                    . " , POSPNCONF_ID "
                                    . " , NRO_PNEU "
                                    . " , PRESSAO_ENC "
                                    . " , PRESSAO_COL "
                                    . " , DTHR "
                                    . " , DTHR_CEL "
                                    . " , DTHR_TRANS "
                                    . " ) "
                                    . " VALUES ("
                                    . " " . $idBolPneu
                                    . " , " . $itemMedPneu->posItemMedPneu
                                    . " , '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                                    . " , " . $itemMedPneu->pressaoEncItemMedPneu
                                    . " , " . $itemMedPneu->pressaoColItemMedPneu
                                    . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemMedPneu->dthrItemMedPneu)
                                    . " , TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') "
                                    . " , SYSDATE "
                                    . " )";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                        }
                    }
                }

                foreach ($dadosItemManutPneu as $itemManutPneu) {

                    if ($bolPneu->idBolPneu == $itemManutPneu->idBolItemManutPneu) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PMP_ITEM_MANUT "
                                . " WHERE "
                                . " BOLETIM_ID = " . $idBolPneu
                                . " AND "
                                . " POSPNCONF_ID  = " . $itemManutPneu->posItemManutPneu
                                . " AND "
                                . " NRO_PNEU_RET LIKE '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                                . " AND "
                                . " NRO_PNEU_COL LIKE '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                                . " AND "
                                . " DTHR_CEL = TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res9 = $this->Read->fetchAll();

                        foreach ($res9 as $item9) {
                            $v = $item9['QTDE'];
                        }

                        if ($v == 0) {

                            $sql = "INSERT INTO PMP_ITEM_MANUT ("
                                    . " BOLETIM_ID "
                                    . " , POSPNCONF_ID "
                                    . " , NRO_PNEU_RET "
                                    . " , NRO_PNEU_COL "
                                    . " , DTHR "
                                    . " , DTHR_CEL "
                                    . " , DTHR_TRANS "
                                    . " ) "
                                    . " VALUES ("
                                    . " " . $idBolPneu
                                    . " , " . $itemManutPneu->posItemManutPneu
                                    . " , '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                                    . " , '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                                    . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemManutPneu->dthrItemManutPneu)
                                    . " , TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') "
                                    . " , SYSDATE "
                                    . " )";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                        }
                    }
                }
            } else {

                $select = " SELECT "
                        . " ID AS IDBOLPNEU "
                        . " FROM "
                        . " PMP_BOLETIM "
                        . " WHERE "
                        . " FUNC_MATRIC = " . $bolPneu->funcBolPneu
                        . " AND "
                        . " EQUIP_ID = " . $bolPneu->equipBolPneu
                        . " AND "
                        . " DTHR_CEL = TO_DATE('" . $bolPneu->dthrBolPneu . "','DD/MM/YYYY HH24:MI') ";

                $this->Read = $this->Conn->prepare($select);
                $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                $this->Read->execute();
                $res8 = $this->Read->fetchAll();

                foreach ($res8 as $item8) {
                    $idBolPneu = $item8['IDBOLPNEU'];
                }

                foreach ($dadosItemMedPneu as $itemMedPneu) {

                    if ($bolPneu->idBolPneu == $itemMedPneu->idBolItemMedPneu) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PMP_ITEM_MED "
                                . " WHERE "
                                . " BOLETIM_ID = " . $idBolPneu
                                . " AND "
                                . " NRO_PNEU LIKE '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                                . " AND "
                                . " DTHR_CEL = TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res9 = $this->Read->fetchAll();

                        foreach ($res9 as $item9) {
                            $v = $item9['QTDE'];
                        }

                        if ($v == 0) {

                            $sql = "INSERT INTO PMP_ITEM_MED ("
                                    . " BOLETIM_ID "
                                    . " , POSPNCONF_ID "
                                    . " , NRO_PNEU "
                                    . " , PRESSAO_ENC "
                                    . " , PRESSAO_COL "
                                    . " , DTHR "
                                    . " , DTHR_CEL "
                                    . " , DTHR_TRANS "
                                    . " ) "
                                    . " VALUES ("
                                    . " " . $idBolPneu
                                    . " , " . $itemMedPneu->posItemMedPneu
                                    . " , '" . $itemMedPneu->nroPneuItemMedPneu . "'"
                                    . " , " . $itemMedPneu->pressaoEncItemMedPneu
                                    . " , " . $itemMedPneu->pressaoColItemMedPneu
                                    . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemMedPneu->dthrItemMedPneu)
                                    . " , TO_DATE('" . $itemMedPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') "
                                    . " , SYSDATE "
                                    . " )";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                        }
                    }
                }

                foreach ($dadosItemManutPneu as $itemManutPneu) {

                    if ($bolPneu->idBolPneu == $itemManutPneu->idBolItemManutPneu) {

                        $select = " SELECT "
                                . " COUNT(*) AS QTDE "
                                . " FROM "
                                . " PMP_ITEM_MANUT "
                                . " WHERE "
                                . " BOLETIM_ID = " . $idBolPneu
                                . " AND "
                                . " POSPNCONF_ID  = " . $itemManutPneu->posItemManutPneu
                                . " AND "
                                . " NRO_PNEU_RET LIKE '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                                . " AND "
                                . " NRO_PNEU_COL LIKE '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                                . " AND "
                                . " DTHR_CEL = TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') ";

                        $this->Read = $this->Conn->prepare($select);
                        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
                        $this->Read->execute();
                        $res9 = $this->Read->fetchAll();

                        foreach ($res9 as $item9) {
                            $v = $item9['QTDE'];
                        }

                        if ($v == 0) {

                            $sql = "INSERT INTO PMP_ITEM_MANUT ("
                                    . " BOLETIM_ID "
                                    . " , POSPNCONF_ID "
                                    . " , NRO_PNEU_RET "
                                    . " , NRO_PNEU_COL "
                                    . " , DTHR "
                                    . " , DTHR_CEL "
                                    . " , DTHR_TRANS "
                                    . " ) "
                                    . " VALUES ("
                                    . " " . $idBolPneu
                                    . " , " . $itemManutPneu->posItemManutPneu
                                    . " , '" . $itemManutPneu->nroPneuRetItemManutPneu . "'"
                                    . " , '" . $itemManutPneu->nroPneuColItemManutPneu . "'"
                                    . " , " . $ajusteDataHoraDAO->dataHoraGMT($itemManutPneu->dthrItemManutPneu)
                                    . " , TO_DATE('" . $itemManutPneu->dthrItemManutPneu . "','DD/MM/YYYY HH24:MI') "
                                    . " , SYSDATE "
                                    . " )";

                            $this->Create = $this->Conn->prepare($sql);
                            $this->Create->execute();
                        }
                    }
                }
            }
        }
    }

}
