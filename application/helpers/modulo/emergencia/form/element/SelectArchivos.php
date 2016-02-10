<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para comuna
 */
Class Emergencia_Form_Element_SelectArchivos{
    
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
     * @var Emergencia_model 
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var Archivo_Alarma_Model 
     */
    protected $_archivo_alarma_model;

    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
        $this->_ci->load->library("emergencia/emergencia_comuna");
        $this->_ci->load->model("archivo_alarma_model");
        $this->_ci->load->model("emergencia_model");
        $this->_archivo_alarma_model = $this->_ci->archivo_alarma_model;
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
        
        $lista = $this->_listar();
        if(count($lista)>0){
            $this->_element->setNombre($this->_nombre);
            $this->_element->populate($lista);
            $this->_element->setOptionId("arch_ia_id");
            $this->_element->setOptionName("nombre");
            return $this->_element->render($this->_nombre, $default);
        } else {
            return "<div class=\"alert alert-warning\"> No hay archivos asociados a la emergencia </div>";
        }
    }
    
    /**
     * Lista de comunas
     * @return array
     */
    protected function _listar(){
        $lista = $this->_archivo_alarma_model->listaPorAlarma($this->_emergencia->eme_ia_id);
        if(count($lista)>0){
            foreach($lista as $key => $row){
                $lista[$key]["nombre"] = basename(BASEPATH . $row["arch_c_nombre"]);
            }
        }
        return $lista;
    }
}

