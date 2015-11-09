<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Soportes_Historial_Model extends CI_Model {

    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "soportes_historial";


    protected $primary = 'soportehistorial_id';
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
        $this->_query->setTable($this->_tabla);
    }



    

    public function insNuevoHistorialSoporte($datos){
        $id_log = $this->_query->insert($datos);
        if($id_log){
            return $id_log;
        }else{
            return null;
        }

    }


    public function obtHistorialSoporte($id_soporte) {
        $query = "select 
                    soportehistorial_id,
                    soportehistorial_soporte_fk,
                    soportehistorial_fecha,
                    soportehistorial_usuario_fk,
                    soportehistorial_evento,
                    soporte_codigo,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soportehistorial_usuario_fk 
                    left join soportes on soporte_id = soportehistorial_soporte_fk 
                    where soportehistorial_soporte_fk = ? ";
        $query = $this->db->query($query,array($id_soporte));
        
        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    
}    