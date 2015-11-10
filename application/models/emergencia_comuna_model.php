<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Emergencia_Comuna_Model extends CI_Model
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
    protected $_tabla = "emergencias_vs_comunas";
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('model/QueryBuilder');
        $this->_query = New QueryBuilder($this->db);
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
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return string
     */
    public function listaComunasPorEmergencia($id_emergencia){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}
