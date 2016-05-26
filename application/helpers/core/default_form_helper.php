<?php

/**
 * 
 * @param string $value
 * @param string $selected
 * @return string html
 */
function formCheckboxValue($value, $selected){
    if($selected == $value) {
        $checked = "checked=\"checked\"";
    } else {
        $checked = "";
    }
    return " value=\"".$value."\" " . $checked . " ";
}

function formSelectRegionUsuario($nombre, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library("core/form/form_select");
    $_ci->load->model("usuario_region_model", "_usuario_region_model");
    $_ci->form_select->setNombre($nombre);

    $_ci->form_select->populate($_ci->_usuario_region_model->listarPorUsuario($_ci->session->userdata('id')));
    $_ci->form_select->setAtributos(array("class" => "form-control"));
    $_ci->form_select->setOptionId("id");
    $_ci->form_select->setOptionName("nombre");
    return $_ci->form_select->render($nombre, $seleccion);
}

/**
 * 
 * @param string $nombre
 * @param array $seleccion
 * @return string html
 */
function formSelectRegion($nombre, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library("core/form/form_select");
    $_ci->load->model("region_model", "_region_model");
    $_ci->form_select->setNombre($nombre);

    $_ci->form_select->populate($_ci->_region_model->listar());
    $_ci->form_select->setAtributos(array("class" => "form-control"));
    $_ci->form_select->setOptionId("id");
    $_ci->form_select->setOptionName("nombre");
    return $_ci->form_select->render($nombre, $seleccion);
}



