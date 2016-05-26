<?php

/**
 * 
 * @param string $nombre
 * @param array $seleccion
 * @return string html
 */
function formSelectComuna($nombre, $id_region, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library("core/form/form_select");
    $_ci->load->model("comuna_model", "_comuna_model");
    $_ci->form_select->setNombre($nombre);
    $_ci->form_select->populate($_ci->_comuna_model->getComunasPorRegion($id_region));
    $_ci->form_select->setOptionId("com_ia_id");
    $_ci->form_select->setAtributos(array("class" => "form-control"));
    $_ci->form_select->setOptionName("com_c_nombre");
    return $_ci->form_select->render($nombre, $seleccion);
}

