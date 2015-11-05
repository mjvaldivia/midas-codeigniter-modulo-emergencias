<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 14-08-15
 * Time: 02:07 PM
 */
class Tipo_Emergencia_Model extends CI_Model
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
    protected $_tabla = "auxiliar_emergencias_tipo";
    
    
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
     * 
     * @param type $id
     * @return type
     */
    public function getById($id){
        return $this->_query->getById("aux_ia_id", $id);
    }
    
    
    public function find($id) {
        $query = $this->db->query(
            "select aux_ia_id, aux_c_nombre from auxiliar_emergencias_tipo where aux_ia_id = ?",
            array($id)
        );

        $resultados = array("aux_ia_id" => "", "aux_c_nombre" => "");

        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();
            $resultados = $resultados[0];
        }

        return $resultados;
    }

    public function get() {
        $query = $this->db->query("select aux_ia_id, aux_c_nombre from auxiliar_emergencias_tipo order by aux_c_nombre");

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
}