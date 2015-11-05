<?php

/**
 * Nombre del tipo de emergencia
 */
Class Alarma_Nombre_Comunas{
    
    /**
     *
     * @var type 
     */
    protected $ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_alarma;
    
      /**
     *
     * @var Comuna_Model  
     */
    public $ComunaModel;
        
    /**
     *
     * @var Alarma_Comuna_Model 
     */
    public $AlarmaComunaModel;
        
    /**
     * 
     * @param type $ci
     */
    public function __construct($ci) {
        $this->ci = $ci;
        $this->ci->load->model("comuna_model");
        $this->ci->load->model("alarma_comuna_model");
        
        $this->AlarmaComunaModel = New Alarma_Comuna_Model();
        $this->ComunaModel = New Comuna_Model();
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setIdAlarma($id_alarma){
        $this->_id_alarma = $id_alarma;
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        $lista_comunas = $this->AlarmaComunaModel->listaComunasPorAlarma($this->_id_alarma);
            
        $coma = "";
        foreach($lista_comunas as $key => $row){
            $comuna = $this->ComunaModel->getById($row["com_ia_id"]);
            if(!is_null($comuna)){
                $comunas .= $coma.$comuna->com_c_nombre;
                $coma = ", ";
            }
        }
        
        return $comunas;
    }
}

