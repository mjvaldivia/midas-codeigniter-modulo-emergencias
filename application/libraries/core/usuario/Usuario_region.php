<?php

Class Usuario_region{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance(); 
        $this->_ci->load->library("core/string/arreglo");
        $this->_ci->load->model("usuario_region_model","_usuario_region_model");
    }
    
    /**
     * Devuelve arreglo con los id de las regiones del usuario
     * @param int $id_usuario
     * @return array
     */
    public function listaIdRegiones($id_usuario){
        $regiones = $this->_ci->_usuario_region_model->listarPorUsuario($id_usuario);
        return $this->_ci->arreglo->arrayToArray($regiones, "id_region");
    }
}

