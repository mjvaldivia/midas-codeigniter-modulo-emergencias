<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Geometria_Model extends MY_Model {
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_geometria";
    
    /**
     * Retorna la alarma por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("geometria_id", $id);
    }
    
    /**
     * Lista las subcapas de region
     * @return array
     */
    public function listarGeometriaRegion($regiones = array()){
        $query = $this->_query->select("DISTINCT g.*")
                               ->from($this->_tabla . " g")
                               ->join("capas_poligonos_regiones p", "g.geometria_id = p.poliregion_capitem", "INNER");
        
        if(count($regiones)>0){
            $query->whereAND("p.poliregion_region", $regiones, "IN");
        }
        
        
        $result = $query->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista las subcapas de provincia
     * @return array
     */
    public function listarGeometriaProvincias(){
        $result = $this->_query->select("DISTINCT g.*")
                               ->from($this->_tabla . " g")
                               ->join("capas_poligonos_provincias p", "g.geometria_id = p.poliprovincias_capitem", "INNER")
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

