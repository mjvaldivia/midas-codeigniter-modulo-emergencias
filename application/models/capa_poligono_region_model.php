<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Poligono_Region_Model extends MY_Model {
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_poligonos_regiones";
    
    /**
     * 
     * @param int $id_subcapa
     * @param array $lista_regiones
     * @return array
     */
    public function listarPorSubcapaRegion($id_subcapa, $lista_regiones){

        $query = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poliregion_capitem", $id_subcapa, "=")
                               ->whereAND("p.poliregion_region", $lista_regiones, "IN");

        $result = $query->getAllResult();

        if (!is_null($result)){
            fb($result);
           return $result; 
        } else {
            return NULL;
        }
    }
}
