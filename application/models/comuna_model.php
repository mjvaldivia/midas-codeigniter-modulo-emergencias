<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Comuna_Model extends MY_Model
{    
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "comunas";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("com_ia_id", $id);
    }
    
    /**
     * Retorna una comuna por el nombre
     * @param string $nombre
     * @return array
     */
    public function getOneByName($nombre){
        return $this->_query->getById("com_c_nombre", $nombre);
    }
    
    /**
     * 
     * @param int $id_usuario
     * @return array
     */
    public function listarComunasPorRegion($id_region){
        $result = $this->_query
                      ->select("c.*")
                      ->from($this->_tabla . " c")
                      ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                      ->join("regiones r", "r.reg_ia_id = p.reg_ia_id", "INNER")
                      ->whereAND("r.reg_ia_id", $id_region)
                      ->orderBy("c.com_c_nombre", "ASC")
                      ->getAllResult();

        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_usuario
     * @return array
     */
    public function listarComunasPorUsuario($id_usuario){
        $result = $this->_query
                      ->select("DISTINCT c.*")
                      ->from($this->_tabla . " c")
                      ->join("oficinas_vs_comunas oc", "oc.com_ia_id = c.com_ia_id", "INNER")
                      ->join("usuarios_vs_oficinas uo", "uo.ofi_ia_id = oc.ofi_ia_id", "INNER")
                      ->whereAND("uo.usu_ia_id", $id_usuario)
                      ->orderBy("c.com_c_nombre", "ASC")
                      ->getAllResult();

        if(!is_null($result)){
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
        /*$result = $this->_query->select("*")
                               ->from()
                               ->orderBy("com_c_nombre", "ASC")
                               ->getAllResult();*/
        $query = 'select c.*,p.*,r.* from '.$this->_tabla.' c
                left join provincias p on p.prov_ia_id = c.prov_ia_id
                left join regiones r on r.reg_ia_id = p.reg_ia_id
                order by com_c_nombre ASC';
        $result = $this->db->query($query);

        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return null;
        }
    }
    

    public function getComunasPorRegion($id_region){
        $query = "select c.* from ".$this->_tabla." c
                left join provincias p on p.prov_ia_id = c.prov_ia_id 
                left join regiones r on r.reg_ia_id = p.reg_ia_id 
                where r.reg_ia_id = ? ORDER BY c.com_c_nombre ASC";
        $result = $this->db->query($query,array($id_region));

        if($result->num_rows() > 0){
            return $result->result_object();
        }else{
            return null;
        }
    }


    public function getByNombre($nombre){
        $query = 'select c.*, p.prov_ia_id as id_provincia, r.reg_ia_id as id_region from '.$this->_tabla.' c
                left join provincias p on p.prov_ia_id = c.prov_ia_id
                left join regiones r on r.reg_ia_id = p.reg_ia_id
                where c.com_c_nombre like "%'.$nombre.'%" limit 1';
        $result = $this->db->query($query);

        if($result->num_rows() > 0){
            return $result->result_object();
        }else{
            return null;
        }
    }
    
}

