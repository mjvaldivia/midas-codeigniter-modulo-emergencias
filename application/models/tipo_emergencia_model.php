<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 14-08-15
 * Time: 02:07 PM
 */
class Tipo_Emergencia_Model extends CI_Model
{
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