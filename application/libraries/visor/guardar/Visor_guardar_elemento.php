<?php

Class Visor_guardar_elemento{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_Elemento_Model 
     */
    protected $_emergencia_elemento_model;
    
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
        $this->_ci->load->model("emergencia_elemento_model");
        $this->_emergencia_elemento_model = New Emergencia_Elemento_Model();
    }
    
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    public function guardar($lista_elementos){
        $guardados = array();
        if(count($lista_elementos)>0){
            
            foreach($lista_elementos as $elemento_json){
                $elemento = json_decode($elemento_json);
                if(is_object($elemento)){
                    $emergencia_elemento = $this->_emergencia_elemento_model->getById($elemento->id);
                    
                    $data = array("id_emergencia" => $this->_id_emergencia,
                                  "tipo" => $elemento->tipo,
                                  "color" => $elemento->color,
                                  "propiedades" => json_encode($elemento->propiedades),
                                  "coordenadas" => json_encode($elemento->coordenadas));
                    
                    if(!is_null($emergencia_elemento)){
                        $this->_emergencia_elemento_model->update($data, $emergencia_elemento->id);
                        $guardados[] = $emergencia_elemento->id;
                    } else {
                        $guardados[] = $this->_emergencia_elemento_model->insert($data);
                    }
                }
            }
            
            
        }
        $this->_emergencia_elemento_model->deleteNotIn($this->_id_emergencia, $guardados);
    }
}

