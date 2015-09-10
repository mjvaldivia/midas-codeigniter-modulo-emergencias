<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 09-09-15
 * Time: 02:30 PM
 */
class Tipo_Instalacion_Model extends CI_Model {

    public function obtenerTodos() {
        $sql = "
        select
            ti.*,
            a.*
        from
            auxiliar_tipoinstalacion ti
            inner join ambitos_vs_tipos at on ti.aux_ia_id = at.tip_ia_id
            inner join ambitos a on a.amb_ia_id = at.amb_ia_id
        ";
        
        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
}