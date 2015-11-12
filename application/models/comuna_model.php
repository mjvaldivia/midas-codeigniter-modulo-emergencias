<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Comuna_Model extends MY_Model
{    
    
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
    

    public function getComunasPorRegion($id_region){
        $query = "select c.* from ".$this->_tabla." c
                left join provincias p on p.prov_ia_id = c.prov_ia_id 
                left join regiones r on r.reg_ia_id = p.reg_ia_id 
                where r.reg_ia_id = ?";
        $result = $this->db->query($query,array($id_region));

        if($result->num_rows() > 0){
            return $result->result_object();
        }else{
            return null;
        }
    }
    
}

