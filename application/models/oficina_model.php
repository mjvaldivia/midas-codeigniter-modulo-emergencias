<?php

class Oficina_Model extends MY_Model
{    
    /**
     *
     * @var string 
     */
    protected $_tabla = "oficinas";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("ofi_ia_id", $id);
    }
    
    /**
     * 
     * @return array
     */
    public function listarPorRegion($id_region){
        $result = $this->_query->select("DISTINCT o.*")
                               ->from($this->_tabla . " o")
                               ->join("oficinas_vs_comunas oc", "oc.ofi_ia_id = o.ofi_ia_id", "INNER")
                               ->join("comunas c", "c.com_ia_id = oc.com_ia_id", "INNER")
                               ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                               ->whereAND("p.reg_ia_id", $id_region)
                               ->orderBy("o.ofi_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("ofi_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

