<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Soportes_Model extends CI_Model {

    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "soportes";
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
        $this->_query->setTable($this->_tabla);
    }


    public function obtSoportesUsuario($id_usuario) {
        $query = "select * from ".$this->_tabla." order by soporte_fecha_ingreso DESC";
        $query = $this->db->query($query);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

}    