<?php

Class Layout_Usuario_Imagen{
    
    protected $_ci;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library(
            array(
                "cache",
                "session"
            )
        );
        
        $this->_ci->load->model("usuario_model","_usuario_model");
    }
    
    /**
     * Retorna imagen del perfil
     * @return string
     */
    public function render(){
        
        $imagen = "";
        
        $cache = Cache::iniciar();
        if(!($imagen = $cache->load("imagen_perfil_" . $this->_ci->session->userdata('session_idUsuario')))){
            $usuario = $this->_ci->_usuario_model->getById($this->_ci->session->userdata('session_idUsuario'));
            if(!is_null($usuario)){
                $rut = explode("-",  $usuario->usu_c_rut);
                $url = "http://midas.minsal.cl/static/images/personas/".$rut[0].".jpg";
                $headers = @get_headers($url);
                if(stripos($headers[0],"200 OK")){
                    $imagen = "<img width=\"90px\" class=\"img-circle\" src=\"" . $url . "\" alt=\"\">";
                }
            }
            $cache->save($imagen, "imagen_perfil_" . $this->_ci->session->userdata('session_idUsuario'));
        }
        return $imagen;
    }
}
