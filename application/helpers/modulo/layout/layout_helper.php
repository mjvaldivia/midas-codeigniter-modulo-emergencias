<?php

require_once(APPPATH . "helpers/modulo/layout/menu/Render.php");
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
 * @return string html
 */
function textMoreLess($string){
    $text = New Layout_Text_MoreLess();
    $text->setString($string);
    return $text->render();
}