<?php

class Archivo_Alarma_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "archivo_vs_alarma";
    
    /**
     * Lista por alarma
     * @param int $id_alarma
     * @return array
     */
    public function listaPorAlarma($id_alarma,$all=false){
        if($all){
            $result = $this->_query->select("a.*")
                ->from($this->_tabla . " aa")
                ->join("archivo a", "a.arch_ia_id = aa.arch_ia_id")
                ->whereAND("aa.ala_ia_id", $id_alarma)
                ->getAllResult();
        }else{
            $result = $this->_query->select("a.*")
                ->from($this->_tabla . " aa")
                ->join("archivo a", "a.arch_ia_id = aa.arch_ia_id")
                ->whereAND("aa.ala_ia_id", $id_alarma)
                ->getAllResult();
        }
        $result = $this->_query->select("a.*")
                               ->from($this->_tabla . " aa")
                               ->join("archivo a", "a.arch_ia_id = aa.arch_ia_id")
                               ->whereAND("aa.ala_ia_id", $id_alarma)
                               ->getAllResult();
        if (!is_null($result)){
           return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Borra registros relacionados a archivo
     * @param int $id_archivo
     */
    public function deletePorArchivo($id_archivo){
        $this->query()->delete("arch_ia_id", $id_archivo);
    }
}

