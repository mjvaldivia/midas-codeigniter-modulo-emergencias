<?php

require_once(__DIR__ . "/layout/Assets_View.php");

/**
 * retorna los css agregados a la vista
 */
function layoutCss(){
    $menu = New Layout_Assets_View();
    return $menu->cssToHtml();
}

/**
 * retorna los js agregados a la vista
 */
function layoutJs(){
    $menu = New Layout_Assets_View();
    return $menu->jsToHtml();
}