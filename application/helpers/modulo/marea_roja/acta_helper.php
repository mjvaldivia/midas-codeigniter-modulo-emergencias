<?php

/**
 * Muestra o no boton para ver acta
 * @param int $id
 * @param string $numero_acta
 * @return string html
 */
function mareaRojaBotonVerActa($id, $numero_acta = ""){
    $_ci =& get_instance();
    $_ci->load->model('marea_roja_actas_model','_marea_roja_actas_model');
    $cantidad = $_ci->_marea_roja_actas_model->contar(array("id_marea" => $id));
    if($cantidad > 0){
        return "<button type=\"button\" class=\"btn btn-sm btn-info ver-acta\" title=\"Ver Acta\"
                        data-muestra=\"" . $id . "\"
                        data-acta=\"" . $numero_acta . "\"><i class=\"fa fa-file-o\"></i>
                </button>";
    }
}

