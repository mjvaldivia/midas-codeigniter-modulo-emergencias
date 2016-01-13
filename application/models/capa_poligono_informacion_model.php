<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Poligono_Informacion_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_poligonos_informacion";
    
    /**
     * 
     * @param int $id_capa
     * @param array $lista_comunas
     * @return array
     */
    public function listarPorSubcapa($id_subcapa){
        $result = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poligono_capitem", $id_subcapa, "=")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_capa
     * @param array $lista_comunas
     * @return type
     */
    public function listarPorCapaComuna($id_capa, $lista_comunas){
        $result = $this->_query->select("DISTINCT p.*, g.geometria_nombre")
                               ->from($this->_tabla . " p")
                               ->join("capas_geometria g", "g.geometria_id = p.poligono_capitem", "INNER")
                               ->whereAND("g.geometria_capa", $id_capa)
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_capa
     * @param array $lista_comunas
     * @return array
     */
    public function listarPorComuna($id_capa, $lista_comunas){
        $result = $this->_query->select("c.*")
                               ->from($this->_tabla . " p")
                               ->join("capas_geometria g", "g.geometria_id = p.poligono_capitem", "INNER")
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
}
