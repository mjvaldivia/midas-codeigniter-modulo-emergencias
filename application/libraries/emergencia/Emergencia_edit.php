<?php

Class Emergencia_edit{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Alarma_Model 
     */
    protected $_alarma_model;
    
    /**
     *
     * @var Emergencia_Model 
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var Alarma_Comuna_Model 
     */
    public $_alarma_comuna_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $_emergencia_comuna_model;
    
    /**
     *
     * @var array 
     */
    protected $_alarma = NULL;
    
    /**
     *
     * @var array 
     */
    protected $_emergencia = NULL;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("alarma_model");
        $this->_ci->load->model("alarma_comuna_model");
        $this->_ci->load->model("emergencia_model");
        $this->_ci->load->model("emergencia_comuna_model");
        $this->_alarma_model = New Alarma_Model();
        $this->_alarma_comuna_model = New Alarma_Comuna_Model();
        $this->_emergencia_model = New Emergencia_Model();
        $this->_emergencia_comuna_model = New Emergencia_Comuna_Model();
    }
    
    /**
     * 
     * @param int $id_alarma
     */
    public function setAlarma($id_alarma){
        $this->_alarma = $this->_alarma_model->getById($id_alarma);
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
        if(!is_null($this->_emergencia)){
            $this->setAlarma($this->_emergencia->ala_ia_id);
        }
    }
    
    /**
     * Retorna datos del formulario
     * para generar nueva emergencia
     * @return array
     */
    public function getNewData(){
        $data = array();
        if(!is_null($this->_alarma)){
            $data = array("eme_id"              => "",
                          "ala_id"              => $this->_alarma->ala_ia_id,
                          "nombre_informante"   => $this->_alarma->ala_c_nombre_informante,
                          "telefono_informante" => $this->_alarma->ala_c_telefono_informante,
                          "nombre_emergencia"   => $this->_alarma->ala_c_nombre_emergencia,
                          "id_tipo_emergencia"  => $this->_alarma->tip_ia_id,
                          "nombre_lugar"        => $this->_alarma->ala_c_lugar_emergencia,
                          "observacion"         => $this->_alarma->ala_c_observacion,
                          "fecha_emergencia"    => ISODateTospanish($this->_alarma->ala_d_fecha_emergencia),
                          "geozone"             => $this->_alarma->ala_c_geozone,
                          "latitud_utm"         => $this->_alarma->ala_c_utm_lat,
                          "longitud_utm"        => $this->_alarma->ala_c_utm_lng);
            
            $lista_comunas = $this->_alarma_comuna_model->listaComunasPorAlarma($this->_alarma->ala_ia_id);
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
            }
        }
        return $data;
    }
    
    /**
     * Retorna data de emergencia para editar
     * @return array
     */
    public function getEditData(){
        $data = array();
        if(!is_null($this->_emergencia)){
            $data = array("eme_id"              => $this->_emergencia->eme_ia_id,
                          "ala_id"              => $this->_emergencia->ala_ia_id,
                          "nombre_informante"   => $this->_emergencia->eme_c_nombre_informante,
                          "telefono_informante" => $this->_emergencia->eme_c_telefono_informante,
                          "nombre_emergencia"   => $this->_emergencia->eme_c_nombre_emergencia,
                          "id_tipo_emergencia"  => $this->_emergencia->tip_ia_id,
                          "nombre_lugar"        => $this->_emergencia->eme_c_lugar_emergencia,
                          "observacion"         => $this->_emergencia->eme_c_observacion,
                          "fecha_emergencia"    => ISODateTospanish($this->_emergencia->eme_d_fecha_emergencia),                          
                          "geozone"             => $this->_alarma->ala_c_geozone,
                          "latitud_utm"         => $this->_alarma->ala_c_utm_lat,
                          "longitud_utm"        => $this->_alarma->ala_c_utm_lng);
            
            $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($this->_emergencia->eme_ia_id);
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
            }
        }
        return $data;
    }
}
