<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Capa_Detalle_Model extends MY_Model {
    
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
     * Actualiza 
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "geometria_id", $id);
    }
    
    /**
     * Lista las subcapas de region
     * @return array
     */
    public function listarGeometriaRegion($regiones = array()){
        $query = $this->_query->select("DISTINCT g.*")
                               ->from($this->_tabla . " g")
                               ->join("capas_poligonos_informacion p", "g.geometria_id = p.poliregion_capitem", "INNER");
        
        if(count($regiones)>0){
            $query->whereAND("p.poligono_region", $regiones, "IN");
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
                               ->join("capas_poligonos_informacion p", "g.geometria_id = p.poliprovincias_capitem", "INNER")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Cantidad de detalles por capa
     * @param int $id_capa
     * @return int
     */
    public function cantidadPorCapa(
            $id_capa,
            $lista_comunas = array(),
            $lista_provincias = array(),
            $lista_regiones = array()
    ){
        $query = $this->_queryPorCapa($id_capa)
                       ->select("count(DISTINCT g.geometria_id) as cantidad")
                       ->join("capas_poligonos_informacion p", "g.geometria_id = p.poligono_capitem", "INNER");;
        
        $this->_addWhereUbicacion($query, $lista_comunas, $lista_provincias, $lista_regiones);
        
        $result= $query->getOneResult();
        if (!is_null($result)){
           return $result->cantidad; 
        } else {
            return 0;
        }
    }
    
    /**
     * Retorna solo un detalle de la capa
     * @param int $id_capa
     * @return object
     */
    public function primerDetallePorCapa(
            $id_capa, 
            $lista_comunas = array(),
            $lista_provincias = array(),
            $lista_regiones = array()
    ){
        $query = $this->_queryPorCapa($id_capa)
                       ->select("DISTINCT g.*") 
                       ->join("capas_poligonos_informacion p", "g.geometria_id = p.poligono_capitem", "INNER");
        
        $this->_addWhereUbicacion($query, $lista_comunas, $lista_provincias, $lista_regiones);
        
        $result = $query->limit(1)
                        ->getOneResult();
        if (!is_null($result)){
           return $result; 
        } else {
           return null;
        }
    }
    
    /**
     * Agrega query para filtrar por ubicacion
     * @param type $query
     * @param type $lista_comunas
     * @param type $lista_provincias
     * @param type $lista_regiones
     */
    protected function _addWhereUbicacion(
            &$query,
            $lista_comunas = array(),
            $lista_provincias = array(),
            $lista_regiones = array()
    ){
        $query->addWhere("("
                       . "(p.poligono_comuna IN (".  implode(",", $lista_comunas).")) OR"
                       . "(p.poligono_comuna = 0 AND p.poligono_provincia IN (".  implode(",", $lista_provincias).")) OR"
                       . "(p.poligono_comuna = 0 AND p.poligono_provincia = 0 AND p.poligono_region IN (".  implode(",", $lista_regiones)."))"
                       . ")");
    }
    
    /**
     * 
     * @param int $id_capa
     * @return array
     */
    public function listarPorCapa(
        $id_capa, 
        $lista_comunas = array(),
        $lista_provincias = array(),
        $lista_regiones = array()
    ){
        $query = $this->_queryPorCapa($id_capa)
                       ->select("DISTINCT g.*")    
                       ->join("capas_poligonos_informacion p", "g.geometria_id = p.poligono_capitem", "INNER");
        
        $this->_addWhereUbicacion(
            $query, 
            $lista_comunas, 
            $lista_provincias, 
            $lista_regiones
        );
        
        $result = $query->getAllResult();
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
    
    /**
     * 
     * @param int $id_capa
     * @return queryBuilder
     */
    protected function _queryPorCapa($id_capa){
        return $this->_query
                    ->from($this->_tabla . " g")
                    ->whereAND("g.geometria_capa", $id_capa);
    }
}

