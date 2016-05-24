<?php

/**
 * Devuelve el nombre del controlador
 * @return string
 */
function getController(){
    $_ci =& get_instance();
    return $_ci->router->fetch_class();
}