<?php

CLass Alertas{
    
    protected $ci;
    
    /**
     *
     * @var Alarma_Model 
     */
    public $AlarmaModel;
    
    /**
     *
     * @var Comuna_Model 
     */
    public $ComunaModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model("alarma_model", "AlarmaModel");
        $this->ci->load->model("comuna_model", "ComunaModel");
    }
    
    /**
     * Envia email con alerta
     * @param int $id_alerta
     */
    public function enviaEmailAlarma($id_alerta){
        
        $alerta = $this->AlarmaModel->query()->getById("ala_ia_id", $id_alerta);
        if(!is_null($alerta)){
            
        }
        
        $comunas = $this->ComunaModel->listaComunasPorAlerta($id_alerta);
    }
}

