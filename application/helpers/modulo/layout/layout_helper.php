<?php

require_once(APPPATH . "helpers/core/layout/Menu.php");
require_once(APPPATH . "helpers/modulo/layout/menu/Collapse.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Logeado.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Permiso.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Regiones.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Roles.php");
require_once(APPPATH . "helpers/modulo/layout/sistema/Simulacion.php");
require_once(APPPATH . "helpers/modulo/layout/tab/Show.php");
require_once(APPPATH . "helpers/modulo/layout/text/MoreLess.php");
require_once(APPPATH . "helpers/modulo/layout/usuario/Imagen.php");


/**
 * Formulario para coordenadas y conversion de coordenadas
 * @param string $latitud
 * @param string $longitud
 * @return string html
 */
function formCoordenadas(
    $prefijo_input = "form_coordenadas", 
    $latitud = "", 
    $longitud = "",
    $propiedades = array()
){
        
    $ci =& get_instance();
    $ci->layout_assets->addJs("library/jquery.typing-0.2.0.min.js");
    $ci->layout_assets->addJs("modulo/mapa/google/extension/geo-encoder.js");
    $ci->layout_assets->addJs("modulo/layout/form-coordenadas.js");
    return $ci->load->view(
        "pages/helpers/modulo/layout/form-coordenadas", 
        array(
            "prefijo" => $prefijo_input,
            "latitud" => $latitud, 
            "longitud" => $longitud,
            "propiedades" => $propiedades
        ), 
        true
    );
}

/**
 * Formulario para seleccionar coordenada del mapa
 * @param string $id_html identificador del elemento html donde se cargara el mapa
 * @return string html
 */
function formMapa($id_html){
    $ci =& get_instance();
    $ci->layout_assets->addJs("library/jquery.typing-0.2.0.min.js");
    $ci->layout_assets->addJs("modulo/mapa/formulario.js");

    return $ci->load->view(
        "pages/helpers/modulo/layout/form-mapa", 
        array(
            "identificador" => $id_html,
        ), 
        true
    );
}

/**
 * Retorna el menu
 * @return string hmtl
 */
function menuRender(){
    $ci =& get_instance();
    $ci->load->model("comuna_model");
    $ci->load->model("region_model");
    $menu = New Layout_Menu();
    return $menu->render();
}

/**
 * Agrega los JS para datatables
 * @return string html
 */
function jsDatatable(){
    $ci =& get_instance();
    return $ci->load->view("templates/js-datatable", array(), true);
}

/**
 * Muestra cerrado o abierto el menu
 * @return string
 */
function menuCollapsed($html_object){
    $menu = New Layout_Menu_Collapse();
    return $menu->render($html_object);
}

/**
 * 
 * @return string
 */
function headerRoles(){
    $html = New Layout_Usuario_Roles();
    return $html->render();
}

/**
 * 
 * @return string
 */
function headerRegiones(){
    $html = New Layout_Usuario_Regiones();
    return $html->render();
}

/**
 * Si el usuario es monitor, no puede editar
 * @return boolean
 */
function puedeEditar($modulo){
    $editar = New Layout_Usuario_Permiso();
    return $editar->puedeEditar($modulo);
}

/**
 * 
 * @param string $modulo
 * @return boolean
 */
function puedeEliminar($modulo){
    $editar = New Layout_Usuario_Permiso();
    return $editar->puedeEliminar($modulo);
}

/**
 * 
 * @param type $modulo
 * @return type
 */
function puedeActivarAlarma($modulo){
    $reporte = New Layout_Usuario_Permiso();
    return $reporte->puedeActivarAlarma($modulo);
}

/**
 * 
 * @param type $modulo
 * @return type
 */
function puedeAbrirVisorEmergencia($modulo){
    $reporte = New Layout_Usuario_Permiso();
    return $reporte->puedeAbrirVisorEmergencia($modulo);
}

/**
 * 
 * @param type $modulo
 * @return type
 */
function puedeVerReporteEmergencia($modulo){
    $reporte = New Layout_Usuario_Permiso();
    return $reporte->puedeVerReporteEmergencia($modulo);
}

/**
 * 
 * @param type $modulo
 * @return type
 */
function puedeVerFormularioDatosPersonales($modulo){
    $reporte = New Layout_Usuario_Permiso();
    return $reporte->puedeVerFormularioDatosPersonales($modulo);
}

/**
 * 
 * @param string $modulo
 * @return boolean
 */
function puedeVer($modulo){
    $permiso = New Layout_Usuario_Permiso();
    return $permiso->puedeVer($modulo);
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
 * @param int $largo largo en caracteres permitidos
 * @return string html
 */
function textMoreLess($string, $largo = 30){
    $text = New Layout_Text_MoreLess();
    $text->setString($string);
    $text->setLargo($largo);
    return $text->render();
}

/**
 * Muestra mensaje cuando esta en simulacion
 * @return string html
 */
function htmlSimulacion(){
    $simulacion = New Layout_Sistema_Simulacion();
    return $simulacion->render();
}

/**
 * 
 * @return type
 */
function imagenPerfilUsuario(){
    $imagen = New Layout_Usuario_Imagen();
    return $imagen->render();
}

/**
 * 
 * @return type
 */
function estaLogeado(){
    $logeo = New Layout_Usuario_Logeado();
    return $logeo->estaLogeado();
}