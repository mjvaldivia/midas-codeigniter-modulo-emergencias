<?php

require_once(__DIR__ . "/layout/Menu.php");

/**
 * Despliega el menu
 */
function layoutMenu(){
    
    $_ci =& get_instance();
    $_ci->load->model("region_model", "_region_model");
    $_ci->load->model("comuna_model", "_comuna_model");
    
    $menu = New Layout_Menu();
    return $menu->render();
}

