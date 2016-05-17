<?php

class Permiso_Model extends MY_Model {
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "roles_vs_permisos";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('modulo_model');
    }
    
    /**
     * Actualiza la alarma
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "rvsp_ia_id", $id);
    }
    
    /**
     * Borra todos los permisos asociados a un rol
     * @param int $id_rol
     * @return boolean
     */
    public function deletePorRol($id_rol){
        return $this->_query->delete("rol_ia_id", $id_rol);
    }
    
    /**
     * 
     * @param int $id_rol
     * @return array
     */
    public function listarPorRol($id_rol){
        $result = $this->_query->select("*")
                              ->from($this->_tabla . " m")
                              ->whereAND("m.rol_ia_id", $id_rol)
                              ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Ve si un rol tiene acceso o no a emergencias
     * @param int $id_rol
     * @return boolean
     */
    public function tieneAccesoRol($id_rol){
        $result = $this->_query->select("count(*) as cantidad")
                              ->from($this->_tabla . " m")
                              ->join("permisos p", "p.per_ia_id = m.per_ia_id", "INNER")
                              ->whereAND("m.rol_ia_id", $id_rol)
                              ->whereAND("p.per_c_id_modulo", Modulo_Model::MODULO_EMERGENCIA)
                              ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
    }
    
    /**
     * Permiso para finalizar emergencia
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoFinalizarEmergencia($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_finalizar_emergencia", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoReporteEmergencia($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_reporte_emergencia", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }  
        return false;
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoActivarAlarma($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_activar_alarma", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }  
        return false;
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoVisorEmergencia($lista_roles, $id_submodulo){
        $query = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                      ->whereAND("m.bo_visor_emergencia", 1)
                      ->select("count(*) as cantidad", false);
        fb($query->getQuery());
        $result = $query->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }  
        return false;
    }
    
    /**
     * 
     * @param type $lista_roles
     * @param type $id_modulo
     * @param type $accion
     * @return boolean
     */
    public function verPermiso($lista_roles, $id_modulo, $accion){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_modulo)
                       ->select("*", false)
                       ->getOneResult();
        if(!is_null($result)){
            $permisos = Zend_Json::decode($result->permisos);
            if(isset($permisos[$accion]) && $permisos[$accion]==1){
                return true;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoEliminar($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_eliminar", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }  
        return false;
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoVerFormularioDatosPersonales($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_formulario_datos_personales", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
        
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoEmbarazadas($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_embarazadas", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
        
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return boolean
     */
    public function tienePermisoEditar($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->whereAND("m.bo_editar", 1)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
        
    }
    
    /**
     * retorna si hay o no acceso a un modulo
     * @param type $lista_roles
     * @param type $id_submodulo
     * @return int
     */
    public function tieneAccesoModulo($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->select("count(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }
            
        return false;
    }


    public function tienePermisoVisorEmergenciaGuardar($lista_roles, $id_submodulo){
        $query = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                      ->whereAND("m.bo_visor_emergencia_guardar", 1)
                      ->select("count(*) as cantidad", false);
        $result = $query->getOneResult();
        if(!is_null($result)){
            if($result->cantidad > 0){
                return true;
            }
        }  
        return false;
    }
    
     /**
     * 
     * @param int $id_rol
     * @param int $id_modulo
     * @return array
     */
    public function getByRolAndModulo($id_rol, $id_modulo){
        $result = $this->_query
                       ->select("*")
                       ->from($this->_tabla . " m")
                       ->whereAND("m.rol_ia_id", $id_rol)
                       ->whereAND("m.per_ia_id", $id_modulo)
                       ->getOneResult();
        if(!is_null($result)){
            return $result;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param array $lista_roles
     * @param int $id_submodulo
     * @return QueryBuilder
     */
    protected function _queryPorRolesModulo($lista_roles, $id_submodulo){
        $query = $this->_query->select("*")
                              ->from($this->_tabla . " m")
                              ->join("permisos p", "p.per_ia_id = m.per_ia_id", "INNER")
                              ->whereAND("rol_ia_id", $lista_roles, "IN")
                              ->whereAND("p.per_ia_id", $id_submodulo);
        return $query;
        
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("per_ia_id", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

