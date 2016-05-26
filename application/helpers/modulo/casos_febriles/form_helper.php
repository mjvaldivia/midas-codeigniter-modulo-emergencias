<?php

/**
 * 
 * @param string $nombre
 * @param array $seleccion
 * @return string html
 */
function formSelectEnfermedades($nombre, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library("core/form/form_select");
    $_ci->load->model("enfermedad_model", "_enfermedad_model");
    $_ci->form_select->setNombre($nombre);
    $_ci->form_select->populate($_ci->_enfermedad_model->listarTodos());
    $_ci->form_select->setOptionId("id");
    $_ci->form_select->setOptionName("nombre");
    return $_ci->form_select->render($nombre, $seleccion);
}

