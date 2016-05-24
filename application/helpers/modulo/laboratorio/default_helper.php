<?php

/**
 * 
 * @param int $id_laboratorio
 * @return string
 */
function laboratorioNombre($id_laboratorio){
    if($id_laboratorio != ""){
        $_ci =& get_instance();
        $_ci->load->model("laboratorio_model", "_laboratorio_model");
        
        $laboratorio = $_ci->_laboratorio_model->getById($id_laboratorio);
        if (!is_null($laboratorio)) {
            return $laboratorio->nombre;
        }
    } else {
        return "--------";
    }
}

