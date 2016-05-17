<?php

/**
 * Retorna label con el nombre del estado
 * @param int $id_estado
 * @return string
 */
function casoFebrilNombreEstado($id_estado){
    $_ci =& get_instance();
    $_ci->load->model("casos_febriles_estado_model","_estado_model");
    $estado = $_ci->_estado_model->getById($id_estado);
    
    
    if(!is_null($estado)){
        switch ($estado->id) {
            case Casos_Febriles_Estado_Model::CONFIRMADO:
                return "<span class=\"label red\">" . $estado->nombre . "</span>";
                break;
            case Casos_Febriles_Estado_Model::DESCARTADO:
                return "<span class=\"label green\">" . $estado->nombre . "</span>";
                break;
            default:
                return "<span class=\"label blue\">" . $estado->nombre . "</span>";
                break;
        }
    } else {
        return "<span class=\"label orange\">Caso sospechoso</span>";
    }
}

