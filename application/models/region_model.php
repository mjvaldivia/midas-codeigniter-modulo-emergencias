<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Region_Model extends MY_Model{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "regiones";
    
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
        $clave = $this->_tabla . "_getid_" . $id;
        if(!Zend_Registry::isRegistered($clave)){
            Zend_Registry::set($clave, $this->_query->getById("reg_ia_id", $id));
        }
        return Zend_Registry::get($clave);
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("reg_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

