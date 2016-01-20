<?php

class Usuario_Rol_Model extends MY_Model
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
     * Borra todos los registros asociados a un rol
     * @param int $id_rol
     * @return boolean
     */
    public function deletePorUsuarioYRol($id_usuario, $id_rol){
        $lista = $this->getPorUsuarioYRol($id_usuario, $id_rol);
        if(count($lista)>0){
            foreach($lista as $usuario_rol){
                $this->delete($usuario_rol["uvr_ia_id"]);
            }
        }
        
    }
    
    /**
     * 
     * @param int $id_usuario
     * @param int $id_rol
     * @return array
     */
    public function getPorUsuarioYRol($id_usuario, $id_rol){
        $result = $this->_query->select("ur.*")
                               ->from($this->_tabla . " ur")
                               ->whereAND("ur.usu_ia_id", $id_usuario)
                               ->whereAND("ur.rol_ia_id", $id_rol)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Borra todos los registros asociados a un rol
     * @param int $id_rol
     * @return boolean
     */
    public function deletePorRol($id_rol){
        return $this->_query->delete("rol_ia_id", $id_rol);
    }
    
    /**
     * 
     * @param int $id
     * @return boolean
     */
    public function delete($id){
        return $this->_query->delete("uvr_ia_id", $id);
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


