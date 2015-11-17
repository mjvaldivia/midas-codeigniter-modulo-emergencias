<?php

require_once(APPPATH . "helpers/modulo/capa/archivo/Geozone.php");

/**
 * Retorna link a archivo
 * @param string $path
 * @param string $hash
 * @return string html
 */
function getLinkFileGeozone($path, $hash){
    $file = New Capa_Archivo_Geozone();
    $file->setFile($path, $hash);
    return $file->getUrl();
}