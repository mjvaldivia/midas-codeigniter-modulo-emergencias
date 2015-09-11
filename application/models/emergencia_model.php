<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emergencia_Model extends CI_Model {

    public $activado = 1;
    public $rechazado = 2;
    public $revision = 3;

    public function guardarEmergencia($params) {

        $this->load->helper('utils');
        $res = array();
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
           '" . $this->session->userdata('session_idCargo') . "',
           '" . spanishDateToISO($params['fechaRecepcion']) . "',
           '" . $this->session->userdata('session_idUsuario') . "',
           '" . $params['ala_ia_id'] . "',
           '" . $params['iObservacion'] . "'
        )
        ");

        $eme_ia_id = $this->db->insert_id();
        if ($eme_ia_id && isset($params['iComunas'])) {
            foreach ($params['iComunas'] as $k => $v) {


                $this->db->query("
                INSERT INTO emergencias_vs_comunas (eme_ia_id, com_ia_id)
                VALUES ($eme_ia_id,
                $v
                )
                ");
            }
            $comunas_query = $this->db->query("
            SELECT GROUP_CONCAT(com_c_nombre) comunas from comunas c join emergencias_vs_comunas evc
            on evc.com_ia_id = c.com_ia_id
            where evc.eme_ia_id = $eme_ia_id"); 
            $comunas = $comunas_query->result_array();
            
            $params['lista_comunas'] = $comunas[0]['comunas'];
        }
        if ($query) {
            $this->db->query("
                UPDATE alertas SET est_ia_id = $this->activado WHERE ala_ia_id = '" . $params['ala_ia_id'] . "'");
            $params['eme_ia_id'] = $eme_ia_id;
            $res['res_mail'] = ($this->enviaMsjEmergencia($params))? 'enviado correctamente': 'error al enviar';
        }
        $res['eme_ia_id']= $eme_ia_id;
         
         return json_encode($res);
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

    public function filtrarEmergencias($params) {
        $mapeo = array(
            "tipoEmergencia" => "e.tip_ia_id",
            "anio" => "year(e.eme_d_fecha_emergencia)"
        );

        $where = "1=1";
        $queryParams = array();

        foreach ($params as $llave => $valor) {
            $queryParams[] = $valor;
            $where .= " and " . $mapeo[$llave] . " = ?";
        }

        $sql = "
            select
                e.*,
                te.aux_c_nombre as eme_c_tipo_emergencia
            from
              emergencias e
              inner join auxiliar_emergencias_tipo te on e.tip_ia_id = te.aux_ia_id
              where
                $where
            order by e.eme_d_fecha_emergencia desc
        ";

        $query = $this->db->query($sql, $queryParams);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function getEmergencia($params) {


        $sql = "
            select
                e.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                GROUP_CONCAT(evc.com_ia_id) comunas
            from
              emergencias e join usuarios u on e.usu_ia_id = u.usu_ia_id
              join emergencias_vs_comunas evc on e.eme_ia_id = evc.eme_ia_id
            where e.eme_ia_id = " . $params['id'] . "";

        $query = $this->db->query($sql);

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['eme_d_fecha_emergencia'] = ISODateTospanish($resultados['eme_d_fecha_emergencia']);
            $resultados['eme_d_fecha_recepcion'] = ISODateTospanish($resultados['eme_d_fecha_recepcion']);
        }

        echo json_encode($resultados);
    }

    public function editarEmergencia($params) {

        $this->load->helper('utils');

        $query = $this->db->query("
        UPDATE emergencias SET 
        eme_c_nombre_informante = '" . $params['iNombreInformante'] . "',
        eme_c_telefono_informante ='" . $params['iTelefonoInformante'] . "',
        eme_c_nombre_emergencia = '" . $params['iNombreEmergencia'] . "',
        tip_ia_id = '" . $params['iTiposEmergencias'] . "',
        eme_c_lugar_emergencia = '" . $params['iLugarEmergencia'] . "',
        eme_d_fecha_emergencia = '" . spanishDateToISO($params['fechaEmergencia']) . "',
        eme_d_fecha_recepcion = '" . spanishDateToISO($params['fechaRecepcion']) . "',
        eme_c_recursos = '" . $params['eme_c_recursos'] . "',
        eme_c_heridos = '" . $params['eme_c_heridos'] . "',
        eme_c_fallecidos = '" . $params['eme_c_fallecidos'] . "',
        eme_c_riesgo = '" . $params['eme_c_riesgo'] . "',
        eme_c_capacidad = '" . $params['eme_c_capacidad'] . "',
        eme_c_descripcion = '" . $params['eme_c_descripcion'] . "',
        eme_c_acciones = '" . $params['eme_c_acciones'] . "',
        eme_c_informacion_adicional = '" . $params['eme_c_informacion_adicional'] . "',
        eme_c_observacion = '" . $params['iObservacion'] . "'
        WHERE eme_ia_id =  '" . $params['eme_ia_id'] . "'");

        if ($query) {
            $this->db->query("DELETE from emergencias_vs_comunas WHERE eme_ia_id = '" . $params['eme_ia_id'] . "'");
        }
        if ($query && isset($params['iComunas'])) {
            foreach ($params['iComunas'] as $k => $v) {
                $this->db->query("
                INSERT INTO emergencias_vs_comunas (eme_ia_id, com_ia_id)
                VALUES ('" . $params['eme_ia_id'] . "',
                $v
                )
                ");
            }
        }
        return $query;
    }

    public function rechazaEmergencia($params) {


        $query = $this->db->query("
        UPDATE alertas SET  est_ia_id = " . $this->rechazado . " WHERE ala_ia_id = " . $params['ala_ia_id'] . "");
        return $query;
    }

    public function enviaMsjEmergencia($params) {

        $this->load->helper('utils');
        $mensaje = "<b>SIPRESA: Confirmación de una situación de emergencia</b><br><br>";
        $mensaje .= "Se ha activado la emergencia código ".$params['eme_ia_id']."<br><br>";
        $mensaje .= "Nombre de la emergencia: " . $params['iNombreEmergencia'] . "<br>";
        $mensaje .= "Tipo de emergencia: " . $params['iTiposEmergencias'] . "<br>";
        $mensaje .= "Lugar o dirección de la emergencia: " . $params['iLugarEmergencia'] . "<br>";
        $mensaje .= "Comuna(s): " . $params['lista_comunas'] . "<br>";
        $mensaje .= "Fecha de la emergencia: " . spanishDateToISO($params['fechaEmergencia']) . "<br>";
        $mensaje .= "Fecha recepción de la emergencia: " . spanishDateToISO($params['fechaRecepcion']) . "<br>";
        $mensaje .= "Nombre del informante: " . $params['iNombreInformante'] . "<br>";
        $mensaje .= "Teléfono del informante: " . $params['iTelefonoInformante'] . "<br><br>";
        $mensaje .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'></img><br>";

        //$to = 'rukmini.tonacca@redsalud.gov.cl';
        $to = 'vladimir@cosof.cl';
        $subject = "SIPRESA: Confirmación de una situación de emergencia";


        $this->load->model("Sendmail_Model", "SendmailModel");

        return $this->SendmailModel->emailSend($to, null, null, $subject, $mensaje);
    }

}
