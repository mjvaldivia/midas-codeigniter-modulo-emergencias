<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enfermedad_Model extends MY_Model
{    

    /**
     *
     * @var string 
     */
    protected $_tabla = "enfermedades";
    
    /**
     * Retorna la por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    /**
     * Lista todos los estados
     * @return array
     */
    public function listarTodos(){
         $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("nombre", "ASC")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
}

