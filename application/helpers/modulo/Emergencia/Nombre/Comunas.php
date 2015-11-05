<?php

/**
 * Nombre del tipo de emergencia
 */
Class Emergencia_Nombre_Comunas{
    
    /**
     *
     * @var type 
     */
    protected $ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
      /**
     *
     * @var Comuna_Model  
     */
    public $ComunaModel;
        
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $EmergenciaComunaModel;
        
    /**
     * 
     * @param type $ci
     */
    public function __construct($ci) {
        $this->ci = $ci;
        $this->ci->load->model("comuna_model");
        $this->ci->load->model("emergencia_comuna_model");
        
        $this->EmergenciaComunaModel = New Emergencia_Comuna_Model();
        $this->ComunaModel = New Comuna_Model();
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setIdEmergencia($id_emergencia){
        $this->_id_emergencia = $id_emergencia;
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        $lista_comunas = $this->EmergenciaComunaModel->listaComunasPorEmergencia($this->_id_emergencia);
            
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

