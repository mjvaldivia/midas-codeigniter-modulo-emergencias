<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Casos_Febriles_Enfermedades_Model extends MY_Model
{    

    /**
     *
     * @var string 
     */
    protected $_tabla = "casos_febriles_enfermedades";
    
    /**
     * Retorna la por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    /**
     * 
     * @param int $id_caso
     * @return array
     */
    public function listarPorCaso($id_caso){
         $result = $this->_query->select("ce.id, ce.id_enfermedad, e.nombre")
                               ->from($this->_tabla . " ce")
                               ->join("enfermedades e", "e.id = ce.id_enfermedad ", "INNER")
                               ->whereAND("id_caso_febril", $id_caso)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
}

