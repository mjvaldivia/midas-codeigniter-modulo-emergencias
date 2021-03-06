<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_Laboratorio_Model extends MY_Model{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "usuario_laboratorios";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
        
    /**
     * 
     * @param int $id_usuario
     * @return array
     */
    public function listarPorUsuario($id_usuario){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("id_usuario", $id_usuario)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
}

