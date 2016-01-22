<?php

Class Usuario_comunas{
    
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
        $this->_ci->load->model("comuna_model");
    }
    
    /**
     * 
     * @param int $id_usuario
     * @return array
     */
    public function listaIdComunas($id_usuario){
        $salida = array();
        $lista_comunas = $this->_ci->comuna_model->listarComunasPorUsuario($id_usuario);
        foreach($lista_comunas as $comunas){
            $salida[] = $comunas["com_ia_id"];
        }
        return $salida;
    }
}

