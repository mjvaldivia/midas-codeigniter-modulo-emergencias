<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Sendmail_Model extends MY_Model {

    public $SEREMI = 1;
    public $JEFE_DAS = 2;
    public $JEFE_SP = 3;
    public $EAT_REGIONAL = 5;
    public $JEFE_OFICINA = 6;
    public $EAT_OFICINA = 6;
    public $CRE = 4;

    public function emailSend($to = null, $cc = null, $bcc = null, $subject = null, $message = null, $dry_run = false, $attach = array()) {
        
        $this->load->library('mailer');
        $mail = $this->mailer->load();
        $mail->IsSMTP(); // telling the class to use SMTP
        try {
            $mail->Host = "mail.minsal.cl";           // SMTP server
            //$mail->SMTPDebug  = 2;                         // enables SMTP debug information (for testing)
            $mail->SMTPAuth = true;                         // enable SMTP authentication
            $mail->Port = 25;                      // set the SMTP port for the GMAIL server 465
            $mail->Username = "sistemas";            // SMTP account username
            $mail->Password = "siste14S";               // SMTP account password
            if($bcc!==null){
                $mail->AddBCC($bcc);
            }
            if($cc!==null){
                $mail->AddCC($cc);
            }

            $array_to=  explode(',', $to);

            foreach ($array_to as $to) {
                $mail->AddAddress($to);
            }
            foreach ($attach as $ruta){
            $mail->AddAttachment($ruta);
            }
            $mail->AddReplyTo("noresponder@minsal.cl", 'MIDAS - MINSAL');
            $mail->SetFrom('noresponder@minsal.cl', 'MIDAS - MINSAL');
            
            
            //$mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
            $mail->Subject = utf8_decode($subject);
            $mail->IsHTML(true);
            $mail->MsgHTML(utf8_decode($message));
            
            if ($dry_run) {
            var_dump($mail);return;
        }else{
            $mail->Send();
        }
            
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
            return false;
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
            return false;
        }
        return true;
        
    }

    public function get_destinatariosCorreo($tipo_emergencia = null, $comunas = null, $id_usuario_excluir = null) {

        $excluir_str = ($id_usuario_excluir == null) ? "" : " AND u.usu_ia_id <> $id_usuario_excluir";

        $qry = "
                    SELECT group_concat(distinct(a.usu_c_email) SEPARATOR ',') lista FROM (
                    SELECT distinct(usu_c_email) usu_c_email FROM usuarios u
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE crg_ia_id IN ($this->SEREMI,$this->JEFE_DAS,$this->JEFE_SP)
                    AND ovc.com_ia_id IN ($comunas) 
                    AND u.est_ia_id = 1 $excluir_str
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->CRE AND usu_b_cre_activo = 1 
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str limit 1
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->JEFE_OFICINA
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str
                
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    join usuarios_vs_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->EAT_REGIONAL
                    AND teva.aux_ia_id = $tipo_emergencia 
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str
                UNION
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    join usuarios_vs_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = $this->EAT_OFICINA
                    AND teva.aux_ia_id = $tipo_emergencia
                    AND ovc.com_ia_id IN ($comunas) $excluir_str
                    AND u.est_ia_id = 1) a
               ";
        $row = array();
        if ($result = $this->db->query($qry))
            $row = $result->result_array();
        return $row[0]['lista'];
    }

}
