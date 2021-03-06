<?php

require_once(BASEPATH . "../application/models/tipo_emergencia_model.php");

/**
 * Retorna formulario para el tipo de emergencia
 */
Class Alarma_form_tipo{
    
    /**
     * Ubicacion de los templates para formulario
     * @var string 
     */
    protected $_path = "pages/evento/form-tipos-emergencia/";
    
    /**
     * Formularios
     * @var type 
     */
    protected $_path_form = array(
                                  "default" => "form-general",
                                  Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA => "form-radiologica"
                                 );
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var array
     */
    protected $_alarma = NULL;
    
    /**
     *
     * @var array 
     */
    protected $_emergencia_tipo;
    
    /**
     *
     * @var Alarma_Model 
     */
    protected $_alarma_model;
    
    /**
     *
     * @var Tipo_Emergencia_Model
     */
    protected $_emergencia_tipo_model;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("tipo_emergencia_model");
        $this->_ci->load->model("emergencia_model");
        $this->_alarma_model = New Emergencia_Model();
        $this->_emergencia_tipo_model = New Tipo_Emergencia_Model();
    }
    
    /**
     * 
     * @param int $id_alarma
     * @throws Exception
     */
    public function setAlarma($id_alarma){
        $this->_alarma = $this->_alarma_model->getById($id_alarma);

    }
    
    /**
     * 
     * @param int $id_tipo
     * @throws Exception
     */
    public function setEmergenciaTipo($id_tipo){
        $this->_emergencia_tipo = $this->_emergencia_tipo_model->getById($id_tipo);
    }
    
    /**
     * Retorna el formulario si corresponde
     * @return array
     */
    public function getFormulario(){
        $respuesta = array("path" => "",
                           "data" => array(),
                           "form" => false);
                
        if(!is_null($this->_emergencia_tipo)){
            switch ($this->_emergencia_tipo->aux_ia_id) {
                case Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA:
                    $respuesta["path"] = $this->_path . $this->_path_form[Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA];
                    break;
                default:
                    $respuesta["path"] = $this->_path . $this->_path_form["default"];
                    break;
                    
            }
            $respuesta["data"] = $this->_populate();
            $respuesta["form"] = true;
        }
        
        return $respuesta;
    }
    
    /**
     * 
     * @return array
     */
    protected function _populate(){
        $array = array("id" => $this->_alarma->eme_ia_id);
                    
        $datos = unserialize($this->_getDataFromBd());
        if(is_array($datos) && count($datos)>0){
            
            foreach($datos as $nombre_input => $valor){
                $array["form_tipo_" . $nombre_input] = $valor;
            }
        }
        
        return $array;
    }
    
    
    /**
     * Retorna la data
     * @return string
     */
    protected function _getDataFromBd(){
        if(!is_null($this->_alarma)){
            return $this->_alarma->eme_c_datos_tipo_emergencia;
        } else {
            return "";
        }
    }
    
}

