<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../dbutil/Conn.class.php');
/**
 * Description of ColaboradorDAO
 *
 * @author anderson
 */
class ColabDAO extends Conn {
    
    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($base) {

        $select = " SELECT "
                    . " F.FUNC_ID AS \"idColab\" "
                    . " , F.CD AS \"matricColab\" "
                    . " , F.NOME AS \"nomeColab\" "
                    . " , E.ESCALATRAB_ID AS \"idEscalaTrabColab\" "
                . " FROM "
                    . " USINAS.VMB_FUNC_AUTO F "
                    . " , USINAS.VMB_FUNC_ESCALA E "
                . " WHERE "
                    . " F.FUNC_ID = E.FUNC_ID "
                . " ORDER BY "
                    . " F.CD "
                . " ASC ";
        
        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        return $result;
    }
    
}
