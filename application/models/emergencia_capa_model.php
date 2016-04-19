<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Capa_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_capa";
    
    /**
     * Cuenta capas asociadas a emergencia
     * @param int $id_emergencia
     * @return int
     */
    public function contarPorEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("count(*) as cantidad")
                       ->getOneResult();
        if (!is_null($result)){
           return $result->cantidad; 
        } else {
            return 0;
        }
    }
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("cg.*")
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaIdsPorEmergencia($id_emergencia){
        $query = $this->_query->select("cg.id_geometria as id")
                              ->from($this->_tabla . " cg") 
                              ->whereAND("cg.id_emergencia", $id_emergencia);
        $result = $query->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return QueryBuilder
     */
    protected function _queryPorEmergencia($id_emergencia){
        $query = $this->_query->from($this->_tabla . " cg")
                               ->join("capas_geometria g", "g.geometria_id = cg.id_geometria")
                               ->join("capas c", "c.cap_ia_id = g.geometria_capa", "INNER")
                               ->whereAND("cg.id_emergencia", $id_emergencia);
        return $query;
    }
}

