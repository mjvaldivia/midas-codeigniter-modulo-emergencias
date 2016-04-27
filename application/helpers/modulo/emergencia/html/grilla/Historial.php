<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * 
 */
Class Emergencia_Html_Grilla_Historial extends Emergencia_Html_Grilla_Abstract{
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function __construct($id_emergencia) {
        parent::__construct($id_emergencia);
        $this->_ci->load->model("alarma_historial_model","_alarma_historial_model");
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        $lista = $this->_ci->_alarma_historial_model->listaPorEmergencia($this->_emergencia->eme_ia_id);
        if(!is_null($lista)){
            return $this->_ci->load->view("pages/evento/grilla/historial", array("lista" => $lista), true);
        }
    }
}

