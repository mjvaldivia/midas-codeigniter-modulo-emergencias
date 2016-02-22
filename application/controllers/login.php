<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model 
     */
    public $_usuario_model;
    
    /**
     *
     * @var Session_Model 
     */
    public $_session_model;
    
    /**
     *
     * @var Usuario_Rol_Model 
     */
    public $_usuario_rol_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->model('usuario_model','_usuario_model');
        $this->load->model('usuario_rol_model','_usuario_rol_model');
        $this->load->model('session_model','_session_model');
        $this->load->model('rol_model','_rol_model');
    }
    
    /**
     * 
     */
    public function index(){
        if(estaLogeado()){
            $this->_redireccion();
        }
        $this->load->view('pages/login/index', array());
    }
    
    /**
     * 
     */
    public function actualizar(){
        $this->template->parse("default", 
                               "pages/login/actualizar", 
                                array());
    }
    
    /**
     * 
     */
    public function procesar(){
        $params = $this->input->post(null, true);
        $usuario = $this->_usuario_model->getByUserAndPass($params["username"], $params["password"]);
        if(!is_null($usuario)){
            $this->_session_model->autentificar($usuario->usu_c_rut);
            if($usuario->bo_cambiar_password == 1){
                redirect(base_url("login/actualizar"));
            } else {
                $this->_redireccion();
            }
        }
        $this->load->view('pages/login/index', array("error" => true,
                                               "mensaje" => "El usuario no es válido, intente nuevamente."));
    }
    
    public function ajax_guardar_nuevo_password(){
        header('Content-type: application/json');
        $this->load->library("validar");
        
        $params = $this->input->post(null, true);
        
        $correcto = $this->validar->validarVacio($params["password_nuevo"]);
        $correcto = $correcto && $this->validar->validarVacio($params["password_repetido"]);
        $correcto = $correcto && ($params["password_repetido"] == $params["password_nuevo"]);
        
        if($correcto){
            $data = array("bo_cambiar_password" => 0,
                          "usu_c_clave" => sha1($params["password_nuevo"]));
            $this->_usuario_model->update($data, $params["id"]);
        }
        
        $salida = array("error"    => array(),
                        "correcto" => $correcto);
        
        $json = Zend_Json::encode($salida);
        echo $json;
    }
    
    /**
     * 
     */
    protected function _redireccion(){
        if(estaLogeado()){
            $usuario = $this->_usuario_model->getById($this->session->userdata("session_idUsuario"));
            if(!is_null($usuario)){
                $lista_roles = $this->_usuario_rol_model->listarRolesPorUsuario($usuario->usu_ia_id);
                
                $bo_perfil_medico = false;
                foreach($lista_roles as $rol){
                    if($rol["rol_ia_id"] == Rol_Model::MEDICO){
                        $bo_perfil_medico = true;
                    }
                }
                
                if($bo_perfil_medico){
                    if(count($lista_roles) > 0){
                        redirect(base_url("home"));
                    } else {
                        redirect(base_url("formulario"));
                    }
                } else {
                    redirect(base_url("home"));
                }
            }
        }
    }
}

