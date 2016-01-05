<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Region_Model extends MY_Model{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "regiones";
    
    
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("reg_ia_id", $id);
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("reg_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

