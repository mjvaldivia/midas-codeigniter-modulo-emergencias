<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: claudio
 * Date: 21-09-15
 * Time: 01:33 PM
 */
class Instalacion_Model extends MY_Model
{
    public function obtenerInsSegunTipIns($params) {
        $sql = "select com_ia_id from emergencias_vs_comunas where eme_ia_id = ?";

        $query = $this->db->query($sql, array($params["idEmergencia"]));

        $comunas = "";
        foreach ($query->result_array() as $row) {
            $comunas .= $row["com_ia_id"] . ", ";
        }

        $tipos = "";
        foreach($params["tiposIns"] as $ti) {
            $tipos .= $ti . ", ";
        }

        if (empty($comunas)) return array();

        $comunas = substr($comunas, 0, -2);
        $tipos = substr($tipos, 0, -2);

        $sql = "
          select distinct * from (
            select
              mi.*,
              c.com_c_nombre,
              r.reg_c_nombre,
              (
                select
                    ti.aux_c_nombre
                from
                  valores_instalaciones vi
                  inner join configuracion_instalaciones ci on ci.avc_ia_id = vi.avc_ia_id and ci.avc_c_nombre = 'Clasificación de la instalación'
                  inner join auxiliar_tipoinstalacion ti on vi.val_c_valor_pk = ti.aux_ia_id
                where
                  vi.ins_ia_id = i.ins_ia_id and ci.amb_ia_id = i.amb_ia_id and vi.val_c_valor_pk in (" . $this->db->escape_str($tipos) . ")
                limit 1
              ) as tipo_instalacion
            from
              maestro_instalaciones mi
              inner join instalaciones i on mi.ins_ia_id = i.mae_ia_id
              inner join comunas c on mi.com_ia_id = c.com_ia_id
              inner join provincias p on p.prov_ia_id = c.prov_ia_id
              inner join regiones r on p.reg_ia_id = r.reg_ia_id
            where
              mi.com_ia_id in (" . $this->db->escape_str($comunas) . ")
          ) t where tipo_instalacion is not null
        ";
//        dump($sql);die;
        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
}