<?php

class Usuario_Ambito_Model extends MY_Model
{    
    /**
     *
     * @var string 
     */
    protected $_tabla = "usuarios_ambitos";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("uva_ia_id", $id);
    }
    
    /**
     * 
     * @param int $id_usuario identificador usuario
     * @return array
     */
    public function listarAmbitosPorUsuario($id_usuario){
        $result = $this->_query->select("a.*")
                               ->from($this->_tabla . " ua")
                               ->join("ambitos a", "a.amb_ia_id = ua.amb_ia_id", "INNER")
                               ->whereAND("ua.usu_ia_id", $id_usuario)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

