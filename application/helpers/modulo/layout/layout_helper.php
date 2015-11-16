<?php

require_once(APPPATH . "helpers/modulo/layout/menu/Render.php");
require_once(APPPATH . "helpers/modulo/layout/menu/Collapse.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Permiso.php");
require_once(APPPATH . "helpers/modulo/layout/tab/Show.php");
require_once(APPPATH . "helpers/modulo/layout/text/MoreLess.php");

/**
 * Despliega el menu
 */
function menuRender(){
    $menu = New Layout_Menu_Render();
    return $menu->render();
}

/**
 * Muestra cerrado o abierto el menu
 * @return string
 */
function menuCollapsed($html_object){
    $menu = New Layout_Menu_Collapse();
    return $menu->render($html_object);
}

/**
 * Si el usuario es monitor, no puede editar
 * @return boolean
 */
function puedeEditar(){
    $editar = New Layout_Usuario_Permiso();
    return $editar->puedeEditar();
}

function puedeVer($modulo){
    $permiso = New Layout_Usuario_Permiso();
    return $permiso->puedeVer($modulo);
}

/**
 * Activa o desactiva un tab
 * @param string $actual
 * @param string $activo
 * @param string $tipo
 * @return string
 */
function tabActive($actual, $activo, $tipo){
    $tab = New Layout_Tab_Show();
    return $tab->render($actual, $activo, $tipo);
}

/**
 * Agrega la opcion "more" para ver mas texto
 * @param string $string
 * @param int $largo largo en caracteres permitidos
 * @return string html
 */
function textMoreLess($string, $largo = 30){
    $text = New Layout_Text_MoreLess();
    $text->setString($string);
    $text->setLargo($largo);
    return $text->render();
}