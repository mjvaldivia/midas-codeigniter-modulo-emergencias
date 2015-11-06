<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Alarma_Estado_Model extends CI_Model
{    
    /**
     * Alarma rechazada
     * @see tip_ia_id en tabla alertas 
     */
    const RECHAZADO = 2;
    
    /**
     * La alarma se convierte en 
     * emergencia
     * @see tip_ia_id en tabla alertas 
     */
    const ACTIVADO = 1;
    
    /**
     * La alarma esta ingresada
     * @see tip_ia_id en tabla alertas 
     */
    const REVISION = 3;
    
    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "estados_alertas";
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
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

