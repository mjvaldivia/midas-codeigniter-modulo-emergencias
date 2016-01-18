<?php

require_once(__DIR__ . "/../../direccion/nombre/Region.php");

Class Usuario_Nombre_Regiones{
    
    /**
     *
     * @var Usuario_Region_Model 
     */
    protected $_usuario_region_model;
    
    /**
     *
     * @var array
     */
    protected $_usuario;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("usuario_region_model");
        $this->_ci->load->model("usuario_model");
        
        $this->_usuario_model = New Usuario_Model();
        $this->_usuario_region_model = New Usuario_Region_Model();
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
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        
        $salida = "";
        
        $lista = $this->_usuario_region_model->listarPorUsuario($this->_usuario->usu_ia_id);
        if(count($lista)>0){
            $coma = "";
            foreach($lista as $usuario_region){
                $nombre_region = New Direccion_Nombre_Region();
                $nombre_region->setId($usuario_region["id_region"]);
                $salida .= $coma . " " . $nombre_region;
                $coma = ",";
            }
        }
        
        return $salida;
    }
}

