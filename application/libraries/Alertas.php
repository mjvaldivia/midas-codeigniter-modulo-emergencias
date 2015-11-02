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
     * @var Alarma_Comuna_Model
     */
    public $AlarmaComunaModel;
    
    /**
     *
     * @var Comuna_Model  
     */
    public $ComunaModel;
    
    /**
     *
     * @var Emergencia_Tipo_Model 
     */
    public $EmergenciaTipoModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model("alarma_model", "AlarmaModel");
        $this->ci->load->model("comuna_model", "ComunaModel");
        $this->ci->load->model("emergencia_tipo_model", "EmergenciaTipoModel");
        $this->ci->load->model("alarma_comuna_model", "AlarmaComunaModel");
    }
    
    /**
     * Envia email con alerta
     * @param int $id_alerta
     */
    public function enviaEmailAlarma($id_alerta){
        $alerta = $this->AlarmaModel->getById($id_alerta);
        
        if(!is_null($alerta)){
            $params = array(
                            "lista_comunas" => $this->_comunasConComa($id_alerta),
                            "tipo_emergencia" => $this->_nombreEmergenciaTipo($alerta->tip_ia_id)
                           );
        }
    }
    
    /**
     * Retorna el nombre del tipo de emergencia
     * @param int $id
     * @return string
     */
    protected function _nombreEmergenciaTipo($id){
        $tipo = $this->EmergenciaTipoModel->getById($id);
        if(!is_null($tipo)){
            return $tipo->aux_c_nombre;
        }
    }
    
    /**
     * Retorna comunas de una alerta
     * separadas por coma
     * @param int $id_alerta
     * @return string
     */
    protected function _comunasConComa($id_alerta){
        $lista_comunas = $this->AlarmaComunaModel->listaComunasPorAlerta($id_alerta);
            
        $coma = "";
        foreach($lista_comunas as $key => $row){
            $comuna = $this->ComunaModel->getById($row["com_ia_id"]);
            if(!is_null($comuna)){
                $comunas .= $coma.$comuna["com_c_nombre"];
                $coma = ", ";
            }
        }
        
        return $comunas;
    }
}

