<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emergencia_Model extends CI_Model {

    public  $activado = 1;
    public  $noactivado = 2;
    public  $revision = 3;

    public function guardarEmergencia($params) {

        $this->load->helper('utils');

        $query = $this->db->query("
        INSERT INTO emergencias (
        eme_c_nombre_informante, 
        eme_c_telefono_informante,
        eme_c_nombre_emergencia,
        tip_ia_id,
        eme_c_lugar_emergencia,
        eme_d_fecha_emergencia,
        rol_ia_id,
        eme_d_fecha_recepcion,
        usu_ia_id,
        ala_ia_id,
        eme_c_recursos,
        eme_c_heridos,
        eme_c_fallecidos,
        eme_c_riesgo,
        eme_c_capacidad,
        eme_c_descripcion,
        eme_c_acciones,
        eme_c_informacion_adicional,
        eme_c_observacion
        )
        VALUES
        (
           '" . $params['iNombreInformante'] . "',
           '" . $params['iTelefonoInformante'] . "',
           '" . $params['iNombreEmergencia'] . "',
           '" . $params['iTiposEmergencias'] . "',
           '" . $params['iLugarEmergencia'] . "',
           '" . spanishDateToISO($params['fechaEmergencia']) . "',
           '" . $this->session->userdata('session_cargo') . "',
           '" . spanishDateToISO($params['fechaRecepcion']) . "',
           '" . $this->session->userdata('session_idUsuario') . "',
           '" . $params['ala_ia_id'] . "',
           '" . $params['eme_c_recursos'] . "',   
           '" . $params['eme_c_heridos'] . "',   
           '" . $params['eme_c_fallecidos'] . "',   
           '" . $params['eme_c_riesgo'] . "',   
           '" . $params['eme_c_capacidad'] . "',   
           '" . $params['eme_c_descripcion'] . "',   
           '" . $params['eme_c_acciones'] . "',   
           '" . $params['eme_c_informacion_adicional'] . "',   
           '" . $params['iObservacion'] . "'
        )
        ");

        $ala_ia_id = $this->db->insert_id();
        if ($ala_ia_id && isset($params['iComunas'])) {
            foreach ($params['iComunas'] as $k => $v) {


                $this->db->query("
                INSERT INTO emergencias_vs_comunas (eme_ia_id, com_ia_id)
                VALUES ($ala_ia_id,
                $v
                )
                ");
            }
        }
        if ($query) {
            $this->db->query("
                UPDATE alertas SET est_ia_id = $this->activado WHERE ala_ia_id = '" . $params['ala_ia_id'] . "'");
        }
        return $query;
    }

    public function getAlarma($params) {


        $sql = "
            select
                a.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                GROUP_CONCAT(avc.com_ia_id) comunas
            from
              alertas a join usuarios u on a.usu_ia_id = u.usu_ia_id
              join alertas_vs_comunas avc on a.ala_ia_id = avc.ala_ia_id
            where a.ala_ia_id = " . $params['id'] . "";

        $query = $this->db->query($sql);

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['ala_d_fecha_emergencia'] = ISODateTospanish($resultados['ala_d_fecha_emergencia']);
            $resultados['ala_d_fecha_recepcion'] = ISODateTospanish($resultados['ala_d_fecha_recepcion']);
        }

        echo json_encode($resultados);
    }

    function revisaEstado($params) {

        $sql = "
            select
                a.est_ia_id
            from
              alertas a 
            where a.ala_ia_id = " . $params['id'] . "";

        $query = $this->db->query($sql);
        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0]['est_ia_id'];
        }
        return $resultados;
    }

}
