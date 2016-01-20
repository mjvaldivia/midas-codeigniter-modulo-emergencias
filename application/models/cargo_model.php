<?php

class Cargo_Model extends MY_Model
{    
    
    const SEREMI = 1;
    const JEFE_DAS = 2;
    const JEFE_SP = 3;
    const EAT_REGIONAL = 5;
    const JEFE_OFICINA = 6;
    const EAT_OFICINA = 6;
    const CRE = 4;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "cargos";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("crg_ia_id", $id);
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("crg_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}
