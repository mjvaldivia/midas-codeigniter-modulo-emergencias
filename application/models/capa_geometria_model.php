<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Geometria_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_geometria";
    
    public function listarPorCapaComuna($id_capa, $lista_comunas){
        $result = $this->_query->select("DISTINCT g.*")
                               ->from($this->_tabla . " g")
                               ->join("capas_poligonos_informacion p", "g.geometria_id = p.poligono_capitem", "INNER")
                               ->whereAND("g.geometria_capa", $id_capa)
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}

