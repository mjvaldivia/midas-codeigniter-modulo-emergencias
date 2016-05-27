<?php

/**
 * Muestra o no boton para ver acta
 * @param int $id
 * @param string $numero_acta
 * @return string html
 */
function mareaRojaBotonValidar($id, $bo_resultado, $bo_validado){
    if($bo_resultado == 1){
        if($bo_validado == 1){
            return "<button type=\"button\" class=\"btn btn-sm btn-success validar\" title=\"Resultado validado\" data-rel=\"" . $id . "\">
                    <i class=\"fa fa-check\"></i>
                    </button>";
        } else {
            return "<button type=\"button\" class=\"btn btn-sm btn-white validar\" title=\"Validar resultado\" data-rel=\"" . $id . "\">
                    <i class=\"fa fa-check-circle\"></i>
                    </button>";
        }
    }
}

