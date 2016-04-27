<?php


if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Fuentes_Radiologicas_Model extends MY_Model {

    protected $_tabla = "fuentes_radiologicas";

    function __construct(){
        parent::__construct();
        $this->load->library("session");
        $this->_session = New CI_Session();
    }


    public function getListadoFuentes(){
        $query = "select * from fuentes_radiologicas order by nombre_empresa_fuente";
        $consulta = $this->db->query($query);
        return $consulta->result_array();

    }


    /**
     * 
     * @param array $data
     * @return int identificador del registro ingresado
     */
    public function insert($data){
        return $this->_query->insert($data);
    }


    public function getById($id){
        return $this->_query->getById("id_fuente", $id);
    }
}

