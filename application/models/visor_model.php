<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 01-10-15
 * Time: 05:41 PM
 */
class Visor_Model extends CI_Model
{
    public function guardarEstadoTipoIns($params) {
        $sql = "insert into tipo_ins_visor(id_emergencia, id_tipo_ins) values (?, ?)";
        $clean = "delete from tipo_ins_visor where id_emergencia = ?";

        $this->db->query($clean, array($params["idEmergencia"]));

        foreach($params["tiposIns"] as $ti) {
            $this->db->query($sql, array($params["idEmergencia"], $ti));
        }
    }

    public function obtenerLimitesVisor($params) {
        $resultados = array();

        if (!array_key_exists("id", $params)) return $resultados;

        $sql = "
          select
            c.com_c_xmin,
            c.com_c_ymin,
            c.com_c_xmax,
            c.com_c_ymax,
            c.com_c_geozone
          from
            emergencias_vs_comunas ec
            inner join comunas c on ec.com_ia_id = c.com_ia_id
          where
            ec.eme_ia_id = ?
        ";

        $query = $this->db->query($sql, array($params["id"]));

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function obtenerTipInsGuardados($params) {
        $resultados = array();

        if (!array_key_exists("id", $params)) return $resultados;

        $sql = "select id_tipo_ins from tipo_ins_visor where id_emergencia = ?";

        $query = $this->db->query($sql, array($params["id"]));

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
}