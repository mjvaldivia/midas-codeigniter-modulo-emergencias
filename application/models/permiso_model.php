<?php

class Permiso_Model extends MY_Model {
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "roles_vs_permisos";
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('modulo_model');
    }
    /*
    public function tienePermisoEditar($lista_roles, $id_submodulo){
        $result = $this->_queryPorRolesModulo($lista_roles, $id_submodulo)
                       ->getOneResult();
    }*/
    
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
            return $result->cantidad;
        }else{
            return 0;
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
}

