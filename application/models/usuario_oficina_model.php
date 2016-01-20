<?php

class Usuario_Oficina_Model extends MY_Model
{    
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "usuarios_vs_oficinas";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("uvf_ia_id", $id);
    }
    
    /**
     * 
     * @param int $id_usuario identificador usuario
     * @return array
     */
    public function listarOficinasPorUsuario($id_usuario){
        $result = $this->_query->select("o.*")
                               ->from($this->_tabla . " uo")
                               ->join("oficinas o", "o.ofi_ia_id = uo.ofi_ia_id", "INNER")
                               ->whereAND("uo.usu_ia_id", $id_usuario)
                               ->getAllResult();
       
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}
