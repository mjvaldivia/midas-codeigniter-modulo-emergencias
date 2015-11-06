<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Soportes_Adjuntos_Model extends CI_Model {

    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "soportes_adjuntos";


    protected $primary = 'soporteadjunto_id';
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
        $this->_query->setTable($this->_tabla);
    }



    

    public function insNuevoAdjuntoSoporte($datos){
        $id_adjunto = $this->_query->insert($datos);
        if($id_adjunto){
            return $id_adjunto;
        }else{
            return null;
        }

    }

    
    public function obtAdjuntosMensaje($id_mensaje){
        $query = "select * from ".$this->_tabla." where soporteadjunto_mensaje_fk = ?";
        $query = $this->db->query($query,array($id_mensaje));

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    public function obtAdjuntoSha($sha){
        $query = "select * from ".$this->_tabla." where soporteadjunto_sha = ? limit 1";
        $query = $this->db->query($query,array($sha));

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados[0];
    }


    

}    