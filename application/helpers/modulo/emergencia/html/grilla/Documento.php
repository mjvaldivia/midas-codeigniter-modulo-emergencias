<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * 
 */
Class Emergencia_Html_Grilla_Documento extends Emergencia_Html_Grilla_Abstract{
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function __construct($id_emergencia) {
        parent::__construct($id_emergencia);
        $this->_ci->load->model("emergencia_archivo_model","_emergencia_archivo_model");
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        $lista = $this->_ci->_emergencia_archivo_model->listarPorEmergenciaNoReporte($this->_emergencia->eme_ia_id);

        return $this->_ci->load->view("pages/evento/grilla/documento", array("lista" => $lista), true);
        
    }
}

