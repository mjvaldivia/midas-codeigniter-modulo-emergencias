<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Comuna_Model extends CI_Model
{    
    
    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "comunas";
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
        $this->_query->setTable($this->_tabla);
    }
    
    /**
     * Retorna HELPER para consultas generales
     * @return Query
     */
    public function query(){
        return $this->_query;
    }
    
    /**
     * Lista de comunas por alerta
     * @param int $id_alerta
     * @return string
     */
    public function listaComunasPorAlerta($id_alerta){
        $query = $this->db->query("SELECT GROUP_CONCAT(com_c_nombre) comunas "
                                 ."FROM comunas c "
                                 ."JOIN alertas_vs_comunas avc ON avc.com_ia_id = c.com_ia_id"
                                 . "WHERE avc.ala_ia_id = ?", array($id_alerta));
        
        if ($query->num_rows() > 0){
           $row = $query->row(); 

           return $row->comunas;
        }
    }
}

