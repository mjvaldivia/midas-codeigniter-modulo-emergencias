<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Poligono_Provincia_Model extends MY_Model {
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_poligonos_provincias";
    
    /**
     * 
     * @param int $id_subcapa
     * @param array $lista_provincias
     * @return array
     */
    public function listarPorSubcapaProvincia($id_subcapa, $lista_provincias){
        $result = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poliprovincias_capitem", $id_subcapa, "=")
                               ->whereAND("p.poliprovincias_provincias", $lista_provincias, "IN")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}

