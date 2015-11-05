<?php

require_once(APPPATH . "helpers/modulo/layout/menu/Render.php");

/**
 * Despliega el menu
 */
function menuRender(){
    $menu = New Layout_Menu_Render(get_instance());
    return $menu->render();
}