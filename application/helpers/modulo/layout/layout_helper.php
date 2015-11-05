<?php

require_once(APPPATH . "helpers/Modulo/Layout/Menu/Render.php");

/**
 * Despliega el menu
 */
function menuRender(){
    $menu = New Layout_Menu_Render(get_instance());
    return $menu->render();
}