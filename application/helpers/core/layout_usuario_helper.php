<?php

require_once(__DIR__ . "/layout/Usuario.php");

/**
 * Despliega perfil
 * @return string html
 */
function layoutUsuarioPerfil(){
    $menu = New Layout_Usuario();
    return $menu->htmlUsuarioPerfil(
        $menu->getUsuarioLogeado()
    );
}

/**
 * Despliega el menu superior derecho
 * @return string html
 */
function layoutUsuarioMenu(){
    $menu = New Layout_Usuario();
    return $menu->htmlUsuarioMenu(
        $menu->getUsuarioLogeado()
    );
}

/**
 * 
 * @return string
 */
function layoutUsuarioNombre($id_usuario){
    $menu = New Layout_Usuario();
    return $menu->getNombreUsuario(
        $id_usuario
    );
}

/**
 * Devuelve regiones asociadas al usuario
 * @param int $id_usuario
 * @return string regiones separadas por coma
 */
function layoutUsuarioRegiones($id_usuario){
    
    $_ci =& get_instance();
    $_ci->load->model("usuario_region_model", "_usuario_region_model");
    
    $_ci->load->library(array(
        "core/string/arreglo")
    );
            
    $lista = $_ci->_usuario_region_model->listarPorUsuario($id_usuario);
    
    return $_ci->arreglo->arrayToString($lista, ",", "nombre");
}