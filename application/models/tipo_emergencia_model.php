<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 14-08-15
 * Time: 02:07 PM
 */
class Tipo_Emergencia_Model extends CI_Model
{
    /**
     * Tipos
     */
    const INCENDIOS_URBANOS = 1;
    const INCENDIOS_FORESTALES = 2;
    const INCENDIOS_QUIMICOS = 3;
    const FENOMENOS_METEOROLOGICOS = 4;
    const SISMOS = 5;
    const TSUNAMI = 6;
    const ERUPCION_VOLCANICA = 7;
    const SEQUIAS = 8;
    const ACCIDENTE_MULTIPLES_VICTIMAS = 9;
    const ACCIDENTE_MEGA_EVENTOS = 10;
    const ACTO_TERRORISTA = 11;
    const EMERGENCIA_EPIDEMIOLOGICA = 12;
    const EMERGENCIA_SANEAMIENTO = 13;
    const OTROS = 14;
    const EMERGENCIA_RADIOLOGICA = 15;
    
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
    
    /**
     * Cantidad de tipos de emergencia
     * @return array
     */
    public function listCantidadPorTipo(){
        $result = $this->_query->select("t.aux_c_nombre, COUNT(e.eme_ia_id) as cantidad")
                               ->from("emergencias e")
                               ->join($this->_tabla . " t", "t.aux_ia_id = e.tip_ia_id", "INNER")
                               ->groupBy("t.aux_c_nombre")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
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