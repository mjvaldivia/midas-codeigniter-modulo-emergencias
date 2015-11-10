<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Alarma_Comuna_Model extends CI_Model
{    
    
    /**
     *
     * @var QueryBuilder
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "alertas_vs_comunas";
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('model/QueryBuilder');
        $this->_query = New QueryBuilder($this->db);
        $this->_query->setTable($this->_tabla);
    }
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return string
     */
    public function listaComunasPorAlarma($id_alarma){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("ala_ia_id", $id_alarma)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }

}
