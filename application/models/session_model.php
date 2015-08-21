<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 11:02 AM
 */
class Session_Model extends CI_Model
{
    public function obtenerComunas() {
        $this->load->helper("debug");
//        dump($this->session->all_userdata());die;

        $sql = "select c.com_ia_id, c.com_c_nombre from comunas c where c.com_ia_id in (" . $this->session->userdata("session_comunas") . ") order by c.com_c_nombre";

        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function obtenerUsuariosImpersonables() {
        $sql = "
          select
            usu_ia_id,
            CONCAT(usu_c_login,' - ',UPPER(crg_c_nombre),' - ',UPPER(reg_c_nombre)) as usu_c_cargo
          from
            usuarios u
            LEFT JOIN cargos c ON c.crg_ia_id=u.crg_ia_id
            LEFT JOIN regiones r ON r.reg_ia_id=u.reg_ia_id
          where
            usu_ia_id <> ?
          order by usu_c_login asc
          ";

        $query = $this->db->query($sql, array(
            $this->session->userdata("session_idUsuario")
        ));

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function autentificar($rut) {
        $sql = "
            select
              u.*,
              c.*,
              r.reg_c_nombre,
              (
                select
                  group_concat(uvo.ofi_ia_id)
                from
                  usuarios_vs_oficinas uvo
                where
                  uvo.usu_ia_id = u.usu_ia_id
              ) as oficinas,
              (
                select
                  group_concat(uva.amb_ia_id)
                from
                  usuarios_vs_ambitos uva
                where
                  uva.usu_ia_id = u.usu_ia_id
              ) as ambitos,
              (
                select
                  group_concat(uvr.rol_ia_id)
                from
                  usuarios_vs_roles uvr
                where
                  uvr.usu_ia_id = u.usu_ia_id
              ) as roles,
              (
                select
                  group_concat(DISTINCT c.com_ia_id)
                from
                  comunas c
                  inner join oficinas_vs_comunas ovc on ovc.com_ia_id = c.com_ia_id
                  inner join usuarios_vs_oficinas uvo on ovc.ofi_ia_id = uvo.ofi_ia_id
                where
                  uvo.usu_ia_id = u.usu_ia_id
              ) as comunas
            from
              usuarios u
              inner join cargos c on c.crg_ia_id = u.crg_ia_id
              inner join regiones r on r.reg_ia_id = u.reg_ia_id
              where u.usu_c_rut = ?
        ";

        $query = $this->db->query($sql, array(
            $rut,
        ));

        $resultadoOperacion = false;

        $this->session->set_userdata(array());

        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            foreach ($resultados as $r) {
                $this->session->set_userdata("session_idUsuario", $r["usu_ia_id"]);
                $this->session->set_userdata("session_nombres", $r["usu_c_nombre"] . " " . $r["usu_c_apellido_paterno"] . " " . $r["usu_c_apellido_materno"]);
                $this->session->set_userdata("session_usuario", $r["usu_c_login"]);
                $this->session->set_userdata("session_region", $r["reg_c_nombre"]);
                $this->session->set_userdata("session_cargo", $r["crg_c_nombre"]);
                $this->session->set_userdata("session_ambitos", $r["ambitos"]);
                $this->session->set_userdata("session_oficinas", $r["oficinas"]);
                $this->session->set_userdata("session_comunas", $r["comunas"]);
                $this->session->set_userdata("session_roles", $r["roles"]);

                $resultadoOperacion = true;
                break;
            }
//            dump($this->session->all_userdata());die;
        }
        return $resultadoOperacion;
    }

    public function impersonar($userID) {
        $sql = "
            select
              u.*,
              c.*,
              r.reg_c_nombre,
              (
                select
                  group_concat(uvo.ofi_ia_id)
                from
                  usuarios_vs_oficinas uvo
                where
                  uvo.usu_ia_id = u.usu_ia_id
              ) as oficinas,
              (
                select
                  group_concat(uva.amb_ia_id)
                from
                  usuarios_vs_ambitos uva
                where
                  uva.usu_ia_id = u.usu_ia_id
              ) as ambitos,
              (
                select
                  group_concat(uvr.rol_ia_id)
                from
                  usuarios_vs_roles uvr
                where
                  uvr.usu_ia_id = u.usu_ia_id
              ) as roles,
              (
                select
                  group_concat(DISTINCT c.com_ia_id)
                from
                  comunas c
                  inner join oficinas_vs_comunas ovc on ovc.com_ia_id = c.com_ia_id
                  inner join usuarios_vs_oficinas uvo on ovc.ofi_ia_id = uvo.ofi_ia_id
                where
                  uvo.usu_ia_id = u.usu_ia_id
              ) as comunas
            from
              usuarios u
              inner join cargos c on c.crg_ia_id = u.crg_ia_id
              inner join regiones r on r.reg_ia_id = u.reg_ia_id
              where u.usu_ia_id = ?
        ";

        $query = $this->db->query($sql, array(
            $userID,
        ));

        $resultadoOperacion = false;

        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            foreach ($resultados as $r) {
                $this->session->set_userdata("session_idUsuario", $r["usu_ia_id"]);
                $this->session->set_userdata("session_nombres", $r["usu_c_nombre"] . " " . $r["usu_c_apellido_paterno"] . " " . $r["usu_c_apellido_materno"]);
                $this->session->set_userdata("session_usuario", $r["usu_c_login"]);
                $this->session->set_userdata("session_region", $r["reg_c_nombre"]);
                $this->session->set_userdata("session_cargo", $r["crg_c_nombre"]);
                $this->session->set_userdata("session_ambitos", $r["ambitos"]);
                $this->session->set_userdata("session_oficinas", $r["oficinas"]);
                $this->session->set_userdata("session_comunas", $r["comunas"]);
                $this->session->set_userdata("session_roles", $r["roles"]);
                $this->session->set_userdata("session_cambioRapido", 1);

                $resultadoOperacion = true;
                break;
            }
//            dump($this->session->all_userdata());die;
        }
        return $resultadoOperacion;
    }
}