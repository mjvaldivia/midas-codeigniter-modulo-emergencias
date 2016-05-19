<?php

/**
 * 
 * @param string $nombre
 * @param array $seleccion
 * @return string html
 */
function formSelectLaboratorio($nombre, $atributos, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library("core/form/form_select");
    $_ci->load->model("laboratorio_model", "_laboratorio_model");
    $_ci->form_select->setNombre($nombre);
    $_ci->form_select->populate($_ci->_laboratorio_model->listar());
    $_ci->form_select->setOptionId("id");
    $_ci->form_select->setOptionName("nombre");
    $_ci->form_select->setAtributos($atributos);
    return $_ci->form_select->render($nombre, $seleccion);
}

/**
 * 
 * @param string $nombre
 * @param array $seleccion
 * @return string html
 */
function formSelectLaboratorioUsuario($nombre, $atributos, $seleccion){
    $_ci =& get_instance();
    $_ci->load->library(
        array(
            "core/form/form_select",
            "core/string/arreglo"
        )
    );
    $_ci->load->model("laboratorio_model", "_laboratorio_model");
    $_ci->load->model("usuario_region_model", "_usuario_region_model");
    
    $lista = $_ci->_laboratorio_model->listar(
        array("usuario" => $_ci->session->userdata('session_idUsuario'))
    );
    
    if(is_null($lista)){
        
        $lista_regiones = $_ci->_usuario_region_model->listarRegionPorUsuario(
            $_ci->session->userdata('session_idUsuario')
        );
                
        $lista = $_ci->_laboratorio_model->listar(
            array("regiones" => $_ci->arreglo->arrayToArray($lista_regiones, "id_region"))
        );
    }
    
    if(!is_null($lista)){
    
        $_ci->form_select->setNombre($nombre);
        $_ci->form_select->populate(
            $lista
        );
        $_ci->form_select->setOptionId("id");
        $_ci->form_select->setOptionName("nombre");
        $_ci->form_select->setAtributos($atributos);
        return $_ci->form_select->render($nombre, $seleccion);
    } else {
        echo "<div class=\"alert alert-warning\"> No existen laboratorios asociados a su cuenta </div>";
    }
}