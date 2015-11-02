<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Sendmail_Model extends CI_Model {

    public $SEREMI = 1;
    public $JEFE_DAS = 2;
    public $JEFE_SP = 3;
    public $EAT_REGIONAL = 5;
    public $JEFE_OFICINA = 6;
    public $EAT_OFICINA = 6;

    public function emailSend($to = null, $cc = null, $bcc = null, $subject = null, $message = null) {

        $this->load->library('email');

        $this->email->from('noresponder@minsal.cl', 'MIDAS - MINSAL');
        $this->email->to($to);
        $this->email->cc($cc);
        if ($bcc != null) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }

    public function get_destinatariosAlarmas($tipo_emergencia = null, $comunas = null) {

        $qry = "
                    SELECT group_concat(distinct(a.usu_c_nombre) SEPARATOR ',') lista FROM (
                    SELECT distinct(usu_c_nombre) usu_c_nombre FROM usuarios u
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE crg_ia_id IN ($this->SEREMI,$this->JEFE_DAS,$this->JEFE_SP)
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1
                UNION 
                    SELECT distinct(usu_c_nombre) usu_c_nombre from usuarios u 
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->JEFE_OFICINA
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1
                UNION 
                    SELECT distinct(usu_c_nombre) usu_c_nombre from usuarios u 
                    join usuarios_vs_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->EAT_REGIONAL
                    AND teva.aux_ia_id = $tipo_emergencia 
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1
                UNION
                    SELECT distinct(usu_c_nombre) usu_c_nombre from usuarios u 
                    join usuarios_vs_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->EAT_OFICINA
                    AND teva.aux_ia_id = $tipo_emergencia
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1) a
               ";
        $row = array();
        if ($result = $this->db->query($qry))
            $row = $result->result_array();
        return $row[0]['lista'];
    }

}
