<?php

Class Usuario_Nombre_Base{
    
    /**
     *
     * @var Usuario_Model 
     */
    protected $_usuario_model;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var array
     */
    protected $_usuario;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("usuario_model");
        $this->_usuario_model = New Usuario_Model();
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        if(!is_null($this->_usuario)){
            return $this->_usuario->usu_c_nombre . " " . $this->_usuario->usu_c_apellido_paterno . " " . $this->_usuario->usu_c_apellido_materno;
        }
    }
    
    /**
     * 
     * @param int $id_usuario
     * @throws Exception
     */
    public function setUsuario($id_usuario){
        $this->_usuario = $this->_usuario_model->getById($id_usuario);
        if(is_null($this->_usuario)){
            throw new Exception(__METHOD__ . " - No existe el usuario");
        }
    }
}

