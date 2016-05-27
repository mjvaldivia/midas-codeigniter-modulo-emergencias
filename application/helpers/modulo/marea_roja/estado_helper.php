<?php

/**
 * Muestra estado del resultado de la muestra
 * @param string $resultado
 * @param int $bo_ingreso_resultado
 * @return string
 */
function mareaRojaEstadoResultado($resultado, $bo_ingreso_resultado = 0){
    $html = "";
    
    if ($bo_ingreso_resultado == 1 AND $resultado != "") {
        switch ($resultado) {
            case "ND":
                $html = "<span class=\"label blue\"> No detectado </span>";
                break;
            case (int)$resultado >= 80:
                $html = "<span class=\"label red\"> Supera </span>";
                break;
            case (int)$resultado < 80:
                $html = "<span class=\"label green\"> No supera </span>";
                break;
            default:
                $html = "";
                break;
        }
    } 
    
    return $html;
}

/**
 * 
 * @param type $bo_ingreso_resultado
 * @param type $bo_validado
 * @return string
 */
function mareaRojaEstadoValidado($bo_ingreso_resultado, $bo_validado){
    if($bo_ingreso_resultado == 1){
        if($bo_validado == 1){
            return "<span class=\"label green\">Validado</span>";
        } else {
            return "<span class=\"label orange\">Esperando validación</span>";
        }
    }
}

/**
 * Muestra estado si se ha ingresado resultado o no
 * @param string $resultado
 * @param int $bo_ingreso_resultado
 * @return string
 */
function mareaRojaEstadoEsperaResultado($resultado, $bo_ingreso_resultado = 0){
    if ($bo_ingreso_resultado == 0 or $resultado == "") {
       
        return "<span class=\"label orange\"> Esperando ingreso </span>";
    } else {
        return $resultado;
    }
}