<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Alarma_Model extends CI_Model {

    public $activado = 1;
    public $rechazado = 2;

    const REVISION = 3;

    /**
     *
     * @var Query 
     */
    protected $_query;

    /**
     *
     * @var string 
     */
    protected $_tabla = "alertas";

    /**
     * 
     */
    public function getById($id) {
        return $this->_query->getById("ala_ia_id", $id);
    }

    public function obtenerEstados() {
        $query = $this->db->query("select * from estados_alertas order by est_c_nombre;");

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function filtrarAlarmas($params) {
        $mapeo = array(
            "estado" => "a.est_ia_id",
            "tipoEmergencia" => "a.tip_ia_id",
            "anio" => "year(a.ala_d_fecha_recepcion)"
        );

        $where = "1=1";
        $queryParams = array();

        foreach ($params as $llave => $valor) {
            $queryParams[] = $valor;
            $where .= " and " . $mapeo[$llave] . " = ?";
        }

        $sql = "
            select
                a.*,
                te.aux_c_nombre as ala_c_tipo_emergencia
            from
              alertas a
              left join auxiliar_emergencias_tipo te on a.tip_ia_id = te.aux_ia_id
              where
                $where
            order by a.ala_ia_id desc , est_ia_id desc
        ";

        $query = $this->db->query($sql, $queryParams);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function obtenerTodas() {
        $sql = "
            select
                a.*
            from
              alertas a
            order by a.ala_ia_id desc
        ";

        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function guardarAlarma($params) {


        $comunas_query = $this->db->query("
            SELECT GROUP_CONCAT(com_c_nombre) comunas, GROUP_CONCAT(c.com_ia_id) id_comunas from comunas c join alertas_vs_comunas avc
        on avc.com_ia_id = c.com_ia_id
        where avc.ala_ia_id = " . $params["ala_ia_id"]);

        $tipo_query = $this->db->query("select aux_c_nombre nombre from auxiliar_emergencias_tipo where aux_ia_id = '" . $params['iTiposEmergencias'] . "'");


        $tipo_emergencia = $tipo_query->result_array();
        $comunas = $comunas_query->result_array();


        $params['lista_comunas'] = $comunas[0]['comunas'];
        $params['lista_id_comunas'] = $comunas[0]['id_comunas'];
        $params['tipo_emergencia'] = $tipo_emergencia[0]['nombre'];

        return ($this->enviaMsjAlarma($params)) ? 'enviado correctamente' : 'error al enviar';
    }

    public function enviaMsjAlarma($params) {
        $error = 0;
        $this->load->helper('utils');
        $this->load->helper('session');
        $this->load->model("usuario_model", "UsuarioModel");
        $key_id = $this->UsuarioModel->generaKeyId($this->session->userdata('session_idUsuario'));
        $mensaje = "<b>SIPRESA: Revisión de Alarma</b><br><br>";
        $mensaje .= $this->session->userdata('session_nombres') . " ha registrado la alarma código : " . $params['ala_ia_id'] . "<br><br>";
        $mensaje .= "<b>Nombre de la emergencia:</b> " . $params['iNombreEmergencia'] . "<br>";
        $mensaje .= "<b>Tipo de emergencia:</b> " . $params['tipo_emergencia'] . "<br>";
        $mensaje .= "<b>Lugar o dirección de la emergencia:</b> " . $params['iLugarEmergencia'] . "<br>";
        $mensaje .= "<b>Comuna(s):</b> " . $params['lista_comunas'] . "<br>";
        $mensaje .= "<b>Fecha de la emergencia:</b> " . spanishDateToISO($params['fechaEmergencia']) . "<br>";
        $mensaje .= "<b>Fecha recepción de la emergencia:</b> " . spanishDateToISO($params['fechaRecepcion']) . "<br>";
        $mensaje .= "<b>Nombre del informante:</b> " . $params['iNombreInformante'] . "<br>";
        $mensaje .= "<b>Teléfono del informante:</b> " . $params['iTelefonoInformante'] . "<br><br>";


        //$to = 'rukmini.tonacca@redsalud.gov.cl';
        //$to = 'vladimir@cosof.cl';
        $subject = "SIPRESA: Revisión de Alarma";


        $this->load->model("Sendmail_Model", "SendmailModel");


        //obtengo al CRE activo y le mando el mail con la url de activacion
        $qry_usu_cre = $this->db->query("
                SELECT u.usu_ia_id,u.usu_c_email from usuarios u
                JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                WHERE crg_ia_id = 4 and usu_b_cre_activo=1
                AND ovc.com_ia_id IN (".$params['lista_id_comunas'].") limit 1");

        $id_usuario_excluir = null;
        if ($usu_cre = $qry_usu_cre->result_array()) {
            $mensajeCRE = $mensaje;
            $mensajeCRE .= "<a href='" . site_url('emergencia/generaEmergencia/id/' . $params['ala_ia_id'] . '/k/' . $key_id) . "'>URL de la alarma a revisar</a><br>";
            $mensajeCRE .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'></img><br>";
            //envio mail al CRE
            $this->SendmailModel->emailSend($usu_cre[0]['usu_c_email'], null, null, $subject, $mensajeCRE);
            if ($this->session->userdata('session_idUsuario') == $usu_cre[0]['usu_ia_id']) {
                $id_usuario_excluir = $usu_cre[0]['usu_ia_id'];
            }
        } else {
            $error++;
        }


        // mando mail al resto
        $mensaje .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'></img><br>";
        $to = $this->SendmailModel->get_destinatariosCorreo($params['iTiposEmergencias'], $params['lista_id_comunas'], $id_usuario_excluir);
        if (!$this->SendmailModel->emailSend($to, null, null, $subject, $mensaje)) {
            $error++;
        }
        return ($error==0)?true:false;
    }

    public function eliminarAlarma($id = 0) {
        $error = false;
        $this->db->trans_begin();

        $this->db->query("delete from alertas where ala_ia_id=$id");
        $this->db->query("delete from alertas_vs_comunas where ala_ia_id=$id");

        if ($this->db->trans_status() === FALSE) {
            $error = true;
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $error;
    }

}
