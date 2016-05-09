<?php

class Rol_Model extends MY_Model {
    
    const ADMINISTRADOR = 27;
    const MONITOR = 44;
    const MEDICO = 46;
    const MEDICO_EPI = 49;
    const ENTOMOLOGO = 59;
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "roles";
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("rol_ia_id", $id);
    }
    
    /**
     * Actualiza 
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "rol_ia_id", $id);
    }
    
    /**
     * 
     * @param array $data
     * @return int
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    public function delete($id_rol){
        return $this->_query->delete("rol_ia_id", $id_rol);
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("rol_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}
