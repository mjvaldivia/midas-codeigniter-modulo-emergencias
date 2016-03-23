<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rapanui_Dengue_Estado_Model extends MY_Model
{    

    const CONFIRMADO = 1;
    const DESCARTADO = 2;
    const NO_CONCLUYENTE = 3;

    /**
     *
     * @var string 
     */
    protected $_tabla = "casos_febriles_estado";
    
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
