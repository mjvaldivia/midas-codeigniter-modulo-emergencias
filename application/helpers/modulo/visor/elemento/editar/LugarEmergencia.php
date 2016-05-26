<?php

require_once(__DIR__ . "/../Editar.php");

Class Visor_Elemento_Editar_LugarEmergencia extends Visor_Elemento_Editar{
    
    /**
     * Retorna propiedades
     * @return string html
     */
    public function render(){
        return $this->_ci->load->view(
            "pages/mapa/form/lugar-emergencia-editar", 
            array("tipo" => $this->_tipo,
                  "color" => $this->_color,
                  "propiedades" => $this->_propiedades), 
            true
        );
    }
}