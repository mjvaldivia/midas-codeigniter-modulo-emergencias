<?php

Class Usuario_permiso{
    
    protected $_ci;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance(); 
        $this->_ci->load->model("permiso_model","_permiso_model");
        $this->_ci->load->model("usuario_rol_model","_usuario_rol_model");
        $this->_ci->load->model("modulo_model");
    }
    
    /**
     * Ve si el permiso existe
     * @param string $accion
     * @return boolean
     */
    public function permiso($id_modulo, $accion, $id_usuario){
        return $this->_ci->_permiso_model->verPermiso(
            $this->_listarRoles($id_usuario), 
            $id_modulo, 
            $accion
        );
    }
        
    /**
     * 
     * @param int $id_usuario
     * @return array
     */
    protected function _listarRoles($id_usuario){
        $salida = array();
        $lista_roles = $this->_ci->_usuario_rol_model->listarRolesPorUsuario($id_usuario);
        if(!is_null($lista_roles)){
            foreach($lista_roles as $rol){
                $salida[] = $rol["rol_ia_id"];
            }
        }
        return $salida;
    }
}

