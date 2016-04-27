<?php

Class Layout_Usuario_Roles{
    
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
     * @var Usuario_Rol_Model 
     */
    protected $usuario_rol_model;
    
     /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("usuario");
        $this->_ci->load->library("session");
        $this->_ci->load->model("usuario_rol_model");
        
        $this->_session          = New CI_Session();
        $this->usuario_rol_model = New Usuario_Rol_Model();
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        $html = "";
        $lista = $this->usuario_rol_model->listarRolesPorUsuario($this->_session->userdata("session_idUsuario"));
        if(count($lista)>0){
            foreach($lista as $rol){
                $html .= "<li>"
                            ."<a href=\"#\">"
                            ."<i ></i> " . $rol["rol_c_nombre"]
                            ."</a>"
                        ."</li>";
            }
        }
        return $html;
    }
    
}

