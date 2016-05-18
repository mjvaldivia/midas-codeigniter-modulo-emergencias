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

/**
 * 
 * @param string $accion
 * @param array $permisos
 * @return string
 */
function checkboxPermisosChecked($accion, $permisos){
    if(isset($permisos[$accion]) && $permisos[$accion] == 1){
        return "checked=\"checked\"";
    }
}

/**
 * Retorna HTML con los permisos especiales para cada modulo
 * @param int $id_modulo
 * @param array $permisos
 * @return string html
 */
function htmlPermisosEspeciales($id_modulo, $permisos){
    $salida = "";
    $_ci =& get_instance();
    $_ci->load->model("modulo_model","_modulo_model");
    switch ($id_modulo) {
        case Modulo_Model::SUB_CASOS_FEBRILES:
            $salida = $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/casos-febriles", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            
            break;
        case Modulo_Model::SUB_MODULO_EMERGENCIA:
            $salida = $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/evento", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            break;
        case Modulo_Model::SUB_MAREA_ROJA:
            $salida = $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/marea-roja", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            break;
        /*case Modulo_Model::HANTA:
            
            return $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/hanta", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            
            break;*/
        /*case Modulo_Model::VACUNA_INVENTARIO:
            
            return $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/vacunas-inventario", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            break;
        case Modulo_Model::VECTORES:
            
            return $_ci->load->view(
                "pages/mantenedor_rol/permisos_especiales/vectores", 
                array(
                    "id_modulo" => $id_modulo,
                    "permiso" => $permisos
                ), 
                true
            );
            break;*/
        default:
            break;
    }
    return $salida;
}