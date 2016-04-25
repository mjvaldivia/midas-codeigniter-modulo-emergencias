<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Detalle_Elemento_Model extends MY_Model {
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas_poligonos_informacion";
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library(array("cache"));
        $this->load->model("comuna_model","comuna_model");
    }
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        //$cache = Cache::iniciar();
        //if(!($row = $cache->load("capa_poligono_" . $id))){
           $row = $this->_query->getById("poligono_id", $id);
          // $cache->save($row, "capa_poligono_" . $id);
        //}
        return $row;
    }
    
    /**
     * Actualiza
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "poligono_id", $id);
    }

    /**
     * Insertar
     * @param  [type] $data [description]
     * @param  [type] $id   [description]
     * @return [type]       [description]
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    public function listarPorComunaRegion($id_subcapa, $id_region){
        $comunas = $this->comuna_model->getComunasPorRegion($id_region);
        $lista_comunas = array();
        
        foreach($comunas as $com){
            $lista_comunas[] = $com->com_ia_id;
        }
        
        $query = $this->_query->select("p.*")
                              ->from($this->_tabla . " p")
                              ->whereAND("p.poligono_capitem", $id_subcapa, "=");
        
        $query->addWhere("p.poligono_comuna IN (".  implode(",", $lista_comunas)  . ")");
   
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
    public function listarPorSubcapa(
        $id_subcapa,
        $lista_comunas = array(),
        $lista_provincias = array(),
        $lista_regiones = array()
    ){
        $query = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poligono_capitem", $id_subcapa, "=");
        
        $this->_addWhereUbicacion($query, $lista_comunas, $lista_provincias, $lista_regiones);
        
        $result = $query->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
     /**
     * 
     * @param int $id_subcapa
     * @param array $lista_regiones
     * @return array
     */
    public function listarPorSubcapaRegion($id_subcapa, $lista_regiones){
        $query = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poligono_capitem", $id_subcapa, "=")
                               ->whereAND("p.poligono_region", $lista_regiones, "IN")
                               ->whereAND("p.poligono_comuna", 0)
                               ->whereAND("p.poligono_provincia", 0);
        $result = $query->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_subcapa
     * @param array $lista_provincias
     * @return array
     */
    public function listarPorSubcapaProvincia($id_subcapa, $lista_provincias){
        $result = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poligono_capitem", $id_subcapa, "=")
                               ->whereAND("p.poligono_provincia", $lista_provincias, "IN")
                               ->whereAND("p.poligono_comuna", 0)
                               ->whereAND("p.poligono_region", 0)
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
    public function listarPorSubcapaComuna($id_subcapa, $lista_comunas){
        $result = $this->_query->select("p.*")
                               ->from($this->_tabla . " p")
                               ->whereAND("p.poligono_capitem", $id_subcapa, "=")
                              // ->whereCondOr(array(array()""))
                               //
                               //->whereAND("p.poligono_comuna", $lista_comunas, "IN")
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
    
}
