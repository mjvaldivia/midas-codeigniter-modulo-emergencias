<?php

Class Emergencia_Html_Reporte_TipoEmergencia{
    
    /**
     *
     * @var array
     */
    protected $_emergencia;
    
    /**
     *
     * @var Emergencia_Model 
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_model");
        $this->_ci->load->model("tipo_emergencia_model");
        
        $this->_emergencia_model = New Emergencia_Model();
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @throws Exception
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
        if(is_null($this->_emergencia)){
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        switch ($this->_emergencia->tip_ia_id) {
            case Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA:
                $path = "pages/reporte/emergencias/tipo-radiologica";
                break;
            default:
                $path = "pages/reporte/emergencias/tipo-general";
                break;
        }
        return $this->_ci->load->view($path, $this->_populate(), true);
    }
    
    /**
     * Retorna la data
     * @return string
     */
    protected function _getDataFromBd(){
        if(!is_null($this->_emergencia)){
            return $this->_emergencia->eme_c_datos_tipo_emergencia;
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return array
     */
    protected function _populate(){
        $array = array();
                    
        $datos = unserialize($this->_getDataFromBd());
        if(is_array($datos) && count($datos)>0){
            foreach($datos as $nombre_input => $valor){
                $array["form_tipo_" . $nombre_input] = $valor;
            }
        }
        
        return $array;
    }
}

