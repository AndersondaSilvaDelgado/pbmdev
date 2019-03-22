<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';
/**
 * Description of EscalaTrabDAO
 *
 * @author anderson
 */
class EscalaTrabDAO extends Conn {
    //put your code here
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados() {

        $select = " SELECT DISTINCT "
                    . " E.ESCALATRAB_ID AS \"idEscalaTrab\" "
                    . " , LPAD(E.HR_ENT1, 5, '0') AS \"horarioEntEscalaTrab\" "
                    . " , LPAD(E.HR_SAI2, 5, '0') AS \"horarioSaiEscalaTrab\" "
                . " FROM "
                    . " USINAS.VMB_FUNC_AUTO F "
                    . " , USINAS.VMB_FUNC_ESCALA FE "
                    . " , USINAS.VMB_ESCALA_TRAB E "
                . " WHERE "
                    . " F.FUNC_ID = FE.FUNC_ID "
                    . " AND FE.ESCALATRAB_ID = E.ESCALATRAB_ID";
        
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
    
}