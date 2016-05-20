<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Marea_Roja_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "marea_roja";
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    
    /**
     * 
     * @param array $data
     * @return int identificador del registro ingresado
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * Actualiza 
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "id", $id);
    }
    
    /**
     * 
     */
    public function delete($id){
        $this->_query->delete("id", $id);
    }
        
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){

        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->orderBy("id", "DESC");
        
        if(!empty($parametros["fecha_desde"]) && $parametros["fecha_desde"] instanceof DateTime){
            $query->whereAND("DATE_FORMAT(a.fecha,'%Y-%m-%d')", $parametros["fecha_desde"]->format("Y-m-d"), ">=");
        }
        
        if(!empty($parametros["fecha_hasta"]) && $parametros["fecha_hasta"] instanceof DateTime){
            $query->whereAND("DATE_FORMAT(a.fecha ,'%Y-%m-%d')", $parametros["fecha_hasta"]->format("Y-m-d"), "<=");
        }
        
        if(!empty($parametros["region"])){
            if(is_array($parametros["region"])){
                $query->whereAND("a.id_region", $parametros["region"], "IN");
            } else {
                $query->whereAND("a.id_region", $parametros["region"]);
            }
        }
        
        if(!empty($parametros["comuna"])){
            $query->whereAND("a.id_comuna", $parametros["comuna"]);
        }
        
        if(!empty($parametros["numero_muestra"])){
            $query->whereAND("a.numero_muestra", $parametros["numero_muestra"]);
        }
        
        if(isset($parametros["ingreso_resultado"])){
            $query->whereAND("a.bo_ingreso_resultado", $parametros["ingreso_resultado"]);
        }
        
        if(!empty($parametros["laboratorio"])){
            $query->whereAND("a.id_laboratorio", $parametros["laboratorio"], "IN");
        }
        
        if(!empty($parametros["no-laboratorio"])){
            $query->whereAND("a.id_laboratorio", $parametros["laboratorio"], "NOT IN");
        }
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

