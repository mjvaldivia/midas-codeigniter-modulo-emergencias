<?php

class Usuario_Rol_Model extends MY_Model
{    
    /**
     *
     * @var string 
     */
    protected $_tabla = "usuarios_vs_roles";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("uvr_ia_id", $id);
    }
    
    /**
     * 
     * @param int $id_usuario identificador usuario
     * @return array
     */
    public function listarRolesPorUsuario($id_usuario){
        $result = $this->_query->select("r.*")
                               ->from($this->_tabla . " ur")
                               ->join("roles r", "r.rol_ia_id = ur.rol_ia_id", "INNER")
                               ->whereAND("ur.usu_ia_id", $id_usuario)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}


