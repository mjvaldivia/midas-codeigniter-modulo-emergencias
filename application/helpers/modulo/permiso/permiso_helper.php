<?php

require_once(APPPATH . "helpers/modulo/permiso/rol/AccesoEstado.php");
require_once(APPPATH . "helpers/modulo/permiso/form/attribute/Checked.php");
/**
 * 
 * @param int $rol_id
 * @return string
 */
function estadoAccesoEmergencias($rol_id){
    $acceso = New Permiso_Rol_AccesoEstado();
    return $acceso->render($rol_id);
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedVer($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->ver();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedActivarAlarma($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->activarAlarma();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedFinalizar($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->finalizar();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedReporteEmergencia($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->reporteEmergencia();
}

/**
 * 
 * @param int $id_rol
 * @param int $id_modulo
 * @return string html
 */
function permisoFormCheckedFormularioDatosPersonales($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->formularioDatosPersonales();
}

/**
 * 
 * @param int $id_rol
 * @param int $id_modulo
 * @return string html
 */
function permisoFormCheckedEmbarazada($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->formularioEmbarazadas();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedVisorEmergencia($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->visorEmergencia();
}


function permisoFormCheckedVisorEmergenciaGuardar($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->visorEmergenciaGuardar();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedEliminar($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->eliminar();
}

/**
 * 
 * @param type $id_rol
 * @param type $id_modulo
 * @return type
 */
function permisoFormCheckedEditar($id_rol, $id_modulo){
    $atributo = New Permiso_Form_Attribute_Checked();
    $atributo->setRol($id_rol);
    $atributo->setModulo($id_modulo);
    return $atributo->editar();
}