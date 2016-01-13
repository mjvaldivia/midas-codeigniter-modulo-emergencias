<?php

require_once(APPPATH . "helpers/modulo/capa/archivo/Geozone.php");
require_once(APPPATH . "helpers/modulo/capa/preview/Capa.php");
require_once(APPPATH . "helpers/modulo/capa/preview/Subcapa.php");

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

/**
 * Muestra icono preview de objeto de capa
 * @param int $id_capa
 * @return string html
 */
function getCapaPreview($id_capa){
    $preview = New Capa_Preview_Capa();
    $preview->setCapa($id_capa);
    return $preview->render();
}

/**
 * Muestra icono preview de objeto de capa
 * @param int $id_capa
 * @return string html
 */
function getSubCapaPreview($id_subcapa){
    $preview = New Capa_Preview_Subcapa();
    $preview->setSubCapa($id_subcapa);
    return $preview->render();
}