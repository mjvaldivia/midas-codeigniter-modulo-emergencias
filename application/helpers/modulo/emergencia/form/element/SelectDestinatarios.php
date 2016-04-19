<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para comuna
 */
Class Emergencia_Form_Element_SelectDestinatarios{
    
    /**
     *
     * @var Cosof_Form_Select
     */
    protected $_element;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * Nombre del input
     * @var string 
     */
    protected $_nombre;
    
    /**
     *
     * @var array 
     */
    protected $_emergencia;
    
    /**
     *
     * @var Usuario_Model
     */
    protected $_usuario_model;
    
    /**
     *
     * @var Emergencia_model 
     */
    protected $_emergencia_model;

    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
        $this->_ci->load->library("emergencia/emergencia_comuna");
        $this->_ci->load->model("usuario_model");
        $this->_ci->load->model("emergencia_model");
        $this->_usuario_model = $this->_ci->usuario_model;
        $this->_emergencia_model = $this->_ci->emergencia_model;
    }
    
    /**
     * Setea la emergencia
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
    }
    
    /**
     * 
     * @return Cosof_Form_Select
     */
    public function getElement(){
        return $this->_element;
    }
    
    /**
     * 
     * @param string $nombre
     */
    public function setNombre($nombre){
        $this->_nombre = $nombre;
    }
    
    /**
     * 
     * @param array $default valores por defecto
     * @return string html
     */
    public function render($default = ""){
        $this->_element->setNombre($this->_nombre);
        $this->_element->populate($this->_listar());
        $this->_element->setOptionId("usu_c_email");
        $this->_element->setOptionName("usu_c_email");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista de comunas
     * @return array
     */
    protected function _listar(){
        $comunas = implode(",", $this->_ci->emergencia_comuna->listComunas($this->_emergencia->eme_ia_id));
        return $this->_usuario_model->listarDestinatariosCorreo($this->_emergencia->tip_ia_id, 
                                                                $comunas, 
                                                                $this->_ci->session->userdata('session_idUsuario'));
    }
}

