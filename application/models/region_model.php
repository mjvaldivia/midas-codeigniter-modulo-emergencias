<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Region_Model extends MY_Model{    
    
    const LOS_LAGOS = 10;
    const REGION_VALPARAISO = 5;
    const REGION_ARICA = 15;
    
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
     * Lista regiones por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaRegionesPorEmergencia($id_emergencia){
        $result = $this->_query->select("DISTINCT r.*")
                               ->from($this->_tabla . " r")
                               ->join("provincias p", "p.reg_ia_id = r.reg_ia_id")
                               ->join("comunas c", "c.prov_ia_id = p.prov_ia_id", "INNER")
                               ->join("emergencias_vs_comunas ec", "ec.com_ia_id = c.com_ia_id")
                               ->whereAND("ec.eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
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



    public function getByNombre($nombre){
        $query = 'select r.* from '.$this->_tabla.' r where r.reg_c_nombre like "%'.$nombre.'%" limit 1';
        $result = $this->db->query($query);

        if($result->num_rows() > 0){
            return $result->result_object();
        }else{
            return null;
        }
    }
}

