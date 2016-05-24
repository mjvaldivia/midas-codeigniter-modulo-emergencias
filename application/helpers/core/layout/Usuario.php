<?php

Class Layout_Usuario{
    
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
        $this->_ci->load->model("usuario_model", "_usuario_model");
        $this->_ci->load->model("region_model", "_region_model");
        $this->_ci->load->model("usuario_rol_model", "_usuario_rol_model");
        $this->_ci->load->model("usuario_region_model", "_usuario_region_model");
    }
    
    /**
     * 
     * @return int
     */
    public function getUsuarioLogeado(){
        return $this->_ci->session->userdata('id');
    }
    
    /**
     * 
     * @param int $id_usuario
     * @return string
     */
    public function getNombreUsuario($id_usuario){
        $usuario = $this->_ci->_usuario_model->getById($id_usuario);
        if(!is_null($usuario)){
            return $usuario->usu_c_nombre . " " . $usuario->usu_c_apellido_paterno . " " . $usuario->usu_c_apellido_materno;
        }
    }
    
    /**
     * 
     * @param type $id_usuario
     * @return type
     */
    public function htmlUsuarioMenu($id_usuario){
        $usuario = $this->_ci->_usuario_model->getById($id_usuario);
        if(!is_null($usuario)){
            return $this->_ci->load->view(
                "templates/usuario/usuario-menu.php",
                array(
                    "nombre_usuario" => $usuario->usu_c_nombre . " " . $usuario->usu_c_apellido_paterno . " " . $usuario->usu_c_apellido_materno,
                    "lista_roles" => $this->htmlListaRoles($id_usuario),
                    "lista_regiones" => $this->htmlListaRegiones($id_usuario)
                ),
                TRUE
            );
        }
    }
    
    
    
    /**
     * 
     * @param type $id_usuario
     * @return type
     */
    public function htmlUsuarioPerfil($id_usuario){
        $usuario = $this->_ci->_usuario_model->getById($id_usuario);
        if(!is_null($usuario)){
            return $this->_ci->load->view(
                "templates/usuario/usuario-perfil.php",
                array(
                    "imagen_usuario" => $this->_imagenPerfil($id_usuario),
                    "nombre_usuario" => $usuario->usu_c_nombre . " " . $usuario->usu_c_apellido_paterno . " " . $usuario->usu_c_apellido_materno
                ),
                TRUE
            );
        }
    }
    
    /**
     * 
     * @return string
     */
    public function htmlListaRoles($id_usuario){
        $html = "";
        $lista = $this->_ci->_usuario_rol_model->listarRolesPorUsuario($id_usuario);
        if(count($lista)>0){
            foreach($lista as $rol){
                $html .= "<li>"
                            ."<a href=\"#\">"
                            ."<i ></i> " . $rol["nombre"]
                            ."</a>"
                        ."</li>";
            }
        }
        return $html;
    }
    
    /**
     * 
     * @return string
     */
    public function htmlListaRegiones($id_usuario){
        $html = "";
        $lista = $this->_ci->_usuario_region_model->listarPorUsuario($id_usuario);
        if(count($lista)>0){
            foreach($lista as $usuario_region){
                $region = $this->_ci->_region_model->getById($usuario_region["id"]);
                if(!is_null($region)){

                    $html .= "<li>"
                                ."<a href=\"#\">"
                                ."<i ></i> " . $region->nombre
                                ."</a>"
                            ."</li>";
                }
            }
        }
        return $html;
    }
    
    /**
     * 
     * @param int $id_usuario
     * @return string
     */
    protected function _imagenPerfil($id_usuario){

        $imagen = "";
        
        $cache = $this->_ci->cache->iniciar();
        if(!($imagen = $cache->load("imagen_perfil_" . $id_usuario))){
            $usuario = $this->_ci->_usuario_model->getById($id_usuario);
            if(!is_null($usuario)){
                $rut = explode("-",  $usuario->usu_c_rut);
                $url = "http://192.168.10.165/static/images/personas/".$rut[0].".jpg";
                $url_midas = "http://midas.minsal.cl/static/images/personas/".$rut[0].".jpg";
                $headers = @get_headers($url);
                if(stripos($headers[0],"200 OK")){
                    $imagen = "<img width=\"90px\" class=\"img-circle\" src=\"" . $url_midas . "\" alt=\"\">";
                }
            }
            $cache->save($imagen, "imagen_perfil_" . $id_usuario);
        }
        return $imagen;
    }

}

