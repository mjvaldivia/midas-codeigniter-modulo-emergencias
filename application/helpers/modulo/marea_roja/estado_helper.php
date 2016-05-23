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