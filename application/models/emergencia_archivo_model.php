<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Archivo_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_archivo";
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model("archivo_model","_archivo_model");
        $this->load->model("archivo_tipo_model","_archivo_tipo_model");
    }
    
    /**
     * 
     * @param array $data
     * @return int
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * Cuenta por archivo
     * @param int $id_archivo
     * @return int
     */
    public function countByArchivo($id_archivo){
        $query = $this->_query->select("count(*) as cantidad")
                               ->from($this->_tabla . "")
                               ->whereAND("id_archivo", $id_archivo);
        $result = $query->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        }else{
            return 0;
        }
    }
    
    /**
     * 
     * @param int $id_evento
     * @param int $id_archivo
     * @return array
     */
    public function getByEventoArchivo($id_evento, $id_archivo){
        $query = $this->_query->select("*")
                               ->from($this->_tabla . "")
                               ->whereAND("id_emergencia", $id_evento)
                               ->whereAND("id_archivo", $id_archivo);
        $result = $query->getOneResult();
        if(!is_null($result)){
            return $result;
        }else{
            return NULL;
        }
    }
    
    /**
     * @param int $id_evento
     * @param array $array
     */
    public function deleteArchivoNotIn($id_evento, $array){
        $query = $this->_query->select("*")
                               ->from($this->_tabla . "")
                               ->whereAND("id_emergencia", $id_evento);
        
        if(count($array)>0){
            $query->whereAND("id_archivo", $array, "NOT IN");
        }
        $result = $query->getAllResult();
        
        if (!is_null($result)){
            foreach($result as $row){
                $this->_query->delete("id", $row["id"]);
                
                $cantidad = $this->countByArchivo($row["id_archivo"]);
                if($cantidad == 0){
                    $this->_archivo_model->delete($row["id_archivo"]);
                }
            }
        }
    }
    
    
    /**
     * Lista los reportes
     * @param int $id_emergencia
     * @return array
     */
    public function listarPorEmergenciaReporte($id_emergencia){
        $result = $this->_queryPorEmergenciaReporte($id_emergencia)
                       ->select("a.*,u.usu_c_nombre,u.usu_c_apellido_paterno,u.usu_c_apellido_materno", false)
                       ->join('usuarios u','u.usu_ia_id = a.usu_ia_id','left')
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista documentos que no son reportes
     * @param int $id_emergencia
     * @return array
     */
    public function listarPorEmergenciaNoReporte($id_emergencia){
        $result = $this->_queryPorEmergenciaNoReporte($id_emergencia)
                       ->select("a.*,u.usu_c_nombre,u.usu_c_apellido_paterno,u.usu_c_apellido_materno", false)
                       ->join('usuarios u','u.usu_ia_id = a.usu_ia_id','left')
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("a.*, CONCAT_WS(\" - \", t.nombre, a.arch_c_descripcion) as nombre_completo ", false)
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return queryBuilder
     */
    protected function _queryPorEmergenciaReporte($id_emergencia){
        return $this->_queryPorEmergencia($id_emergencia)
                    ->whereAND("t.id", Archivo_Tipo_Model::REPORTE);
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return queryBuilder
     */
    protected function _queryPorEmergenciaNoReporte($id_emergencia){
        return $this->_queryPorEmergencia($id_emergencia)
                    ->whereAND("t.id", Archivo_Tipo_Model::REPORTE , "<>");
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return queryBuilder
     */
    protected function _queryPorEmergencia($id_emergencia){
        $query = $this->_query
                       ->from($this->_tabla . " ea")
                       ->join("archivo a", "a.arch_ia_id = ea.id_archivo", "INNER")
                       ->join("archivo_tipo t", "t.id = a.arch_c_tipo")
                       ->whereAND("id_emergencia", $id_emergencia);
        return $query;
    }
}

