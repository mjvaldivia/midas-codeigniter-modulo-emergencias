<?php

require_once(__DIR__ . "/nombre/Tipo.php");
require_once(__DIR__ . "/url/Link.php");

/**
 * Retorna el nombre del tipo de archivo
 * @param int $id_tipo_archivo
 * @return string
 */
function nombreArchivoTipo($id_tipo_archivo){
    $nombre = New Archivo_Nombre_Tipo();
    $nombre->setId($id_tipo_archivo);
    return $nombre->getString();
}

function linkArchivo($id_archivo){
    $link = New Archivo_Url_Link();
    return $link->url($id_archivo);
}