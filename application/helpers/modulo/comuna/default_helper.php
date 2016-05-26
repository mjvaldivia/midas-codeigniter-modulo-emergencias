<?php

/**
 * 
 * @param int $id_region
 * @return string
 */
function nombreComuna($id_comuna){
    if($id_comuna != ""){
        $_ci =& get_instance();
        $_ci->load->model("comuna_model", "_comuna_model");
        $comuna = $_ci->_comuna_model->getById($id_comuna);
        if(!is_null($comuna)){
            return $comuna->com_c_nombre;
        }
    } else {
        return "--------";
    }
}

