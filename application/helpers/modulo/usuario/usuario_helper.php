<?php

require_once( __DIR__ . "/Nombre.php");

/**
 * Retorna el nombre del usuario
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreUsuario($id_usuario){
    $nombre = New Usuario_Nombre();
    $nombre->setUsuario($id_usuario);
    return $nombre;
}

