<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Emergencia_Estado_Model extends CI_Model
{    
    /**
     * Emergencia terminada
     * @see est_ia_id en tabla estado_emergencia
     */
    const CERRADA = 2;
    
    /**
     * @see tip_ia_id en tabla alertas 
     */
    const EN_CURSO = 1;
        
    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "estados_emergencias";
    
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
     * Lista todos los estados
     * @return array
     */
    public function listarTodos(){
         $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("est_c_nombre", "ASC")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
}