<?php

Class Visor_guardar_elemento{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_kml_Model 
     */
    protected $_emergencia_kml_model;
    
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
        $this->_ci->load->model("emergencia_kml_model");
        $this->_emergencia_elemento_model = $this->_ci->emergencia_kml_model;
    }
    
    /**
     * Setea emergencia
     * @param int $id
     * @return \Visor_guardar_elemento
     */
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    /**
     * 
     * @param array $lista_kml
     */
    public function guardar($lista_kml){
        $guardados = array();
        if(count($lista_kml)>0){
            foreach($lista_kml as $kml_seleccionado){
                $kml = $this->_emergencia_kml_model->getById($kml_seleccionado["id"]);
                if(is_null($kml)){
                    $data = array("id_emergencia" => $this->_id_emergencia,
                                  "nombre" => $kml_seleccionado["nombre"],
                                  "kml"    => file_get_contents($kml["url"]));
                    $guardados[] = $this->_emergencia_kml_model->query()->insert($data);
                } else {
                    $guardados[] = $kml->id;
                }
            }    
        }
        $this->_emergencia_kml_model->deleteNotIn($this->_id_emergencia, $guardados);
    }
}

