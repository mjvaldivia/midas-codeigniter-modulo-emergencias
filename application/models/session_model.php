<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 11:02 AM
 */
class Session_Model extends MY_Model
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

    public function obtenerDatosMIDAS($rut) {
        $sql = "
        select rut,nombres,apellidos,email from (
            select
                u.usu_c_rut as rut,
                u.usu_c_nombre as nombres,
                concat(u.usu_c_apellido_paterno, ' ', u.usu_c_apellido_materno) as apellidos,
                u.usu_c_email as email,
                (
                    select
                      count(*)
                    from
                      usuarios u2
                      inner join usuarios_vs_roles uvr on u2.usu_ia_id = uvr.usu_ia_id
                      inner join roles_vs_permisos rvp on uvr.rol_ia_id = rvp.rol_ia_id
                      inner join permisos p on rvp.per_ia_id = p.per_ia_id
                    where
                      u2.usu_ia_id = u.usu_ia_id and p.per_c_id_modulo = 2
                ) as habilitado_emergencias
            from
              usuarios u
            where
              u.usu_c_rut = ?
        ) t where habilitado_emergencias > 0
        ";

        $resultados = array();

        $query = $this->db->query($sql, array(
            $rut,
        ));

        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();
            $resultados = $resultados[0];
        }

        return $resultados;
    }

    public function autentificar($rut) {
        $sql = "
            select * from (
              select
              u.*,
             
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
                  usuarios_ambitos uva
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
              ) as comunas,
              (
                select
                  count(*)
                from
                  usuarios u2
                  inner join usuarios_vs_roles uvr on u2.usu_ia_id = uvr.usu_ia_id
                  inner join roles_vs_permisos rvp on uvr.rol_ia_id = rvp.rol_ia_id
                  inner join permisos p on rvp.per_ia_id = p.per_ia_id
                where
                  u2.usu_ia_id = u.usu_ia_id and p.per_c_id_modulo = 2
              ) as habilitado_emergencias
            from
              usuarios u

              inner join regiones r on r.reg_ia_id = u.reg_ia_id
              where u.usu_c_rut = ?
            ) t
            where habilitado_emergencias > 0
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
                $this->session->set_userdata("session_region_codigo", $r["reg_ia_id"]);
                $this->session->set_userdata("session_cargo", $r["crg_c_nombre"]);
                $this->session->set_userdata("session_idCargo", $r["crg_ia_id"]);
                $this->session->set_userdata("session_ambitos", $r["ambitos"]);
                $this->session->set_userdata("session_oficinas", $r["oficinas"]);
                $this->session->set_userdata("session_comunas", $r["comunas"]);
                $this->session->set_userdata("session_roles", $r["roles"]);
                $this->session->set_userdata("session_cre_activo", $r["usu_b_cre_activo"]); // es CRE y está activo
                $this->session->set_userdata("session_email", $r["usu_c_email"]); 

                $resultadoOperacion = true;
                break;
            }
//            dump($this->session->all_userdata());die;
        }
        return $resultadoOperacion;
    }

    public function impersonar($userID) {
        $sql = "
            select * from (
              select
              u.*,
              
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
                  usuarios_ambitos uva
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
              ) as comunas,
              (
                select
                  count(*)
                from
                  usuarios u2
                  inner join usuarios_vs_roles uvr on u2.usu_ia_id = uvr.usu_ia_id
                  inner join roles_vs_permisos rvp on uvr.rol_ia_id = rvp.rol_ia_id
                  inner join permisos p on rvp.per_ia_id = p.per_ia_id
                where
                  u2.usu_ia_id = u.usu_ia_id and p.per_c_id_modulo = 2
              ) as habilitado_emergencias
            from
              usuarios u
              where u.usu_ia_id = ?
            ) t
            where habilitado_emergencias > 0
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
                //$this->session->set_userdata("session_region", $r["reg_c_nombre"]);
                $this->session->set_userdata("session_cargo", $r["crg_c_nombre"]);
                $this->session->set_userdata("session_idCargo", $r["crg_ia_id"]);
                $this->session->set_userdata("session_ambitos", $r["ambitos"]);
                $this->session->set_userdata("session_oficinas", $r["oficinas"]);
                $this->session->set_userdata("session_comunas", $r["comunas"]);
                $this->session->set_userdata("session_roles", $r["roles"]);
                $this->session->set_userdata("session_cre_activo", $r["usu_b_cre_activo"]); // es CRE y está activo
                $this->session->set_userdata("session_cambioRapido", 1);
                $this->session->set_userdata("session_email", $r["usu_c_email"]); 

                $resultadoOperacion = true;
                break;
            }
        }
        return $resultadoOperacion;
    }
    
        public function getMinMaxUser() {
        $this->load->helper("debug");

        //var_dump($this->session->userdata('session_comunas'));
        $sql = "select  min(c.com_c_xmin) com_c_xmin,
                        min(c.com_c_ymin) com_c_ymin,
                        max(c.com_c_xmax) com_c_xmax,
                        max(c.com_c_ymax) com_c_ymax,
                        com_c_geozone from comunas c 
                        where c.com_ia_id in (" . $this->session->userdata("session_comunas") . ")";

        $query = $this->db->query($sql);


        $resultado = $query->result_array();

        return $resultado[0];
    }
    
}