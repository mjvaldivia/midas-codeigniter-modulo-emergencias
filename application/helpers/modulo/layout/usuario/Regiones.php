<?php

require_once(__DIR__ . "/../../direccion/nombre/Region.php");

Class Layout_Usuario_Regiones{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    /**
     *
     * @var Usuario_Region_Model 
     */
    protected $usuario_region_model;
    
     /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("usuario");
        $this->_ci->load->library("session");
        $this->_ci->load->model("usuario_region_model");
        
        $this->_session          = New CI_Session();
        $this->usuario_region_model = New Usuario_Region_Model();
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        $html = "";
        $lista = $this->usuario_region_model->listarPorUsuario($this->_session->userdata("session_idUsuario"));
        if(count($lista)>0){
            foreach($lista as $usuario_region){
                
                $nombre_region = New Direccion_Nombre_Region();
                $nombre_region->setId($usuario_region["id_region"]);

                $html .= "<li>"
                            ."<a href=\"#\">"
                            ."<i ></i> " . $nombre_region
                            ."</a>"
                        ."</li>";
            }
        }
        return $html;
    }
    
}

