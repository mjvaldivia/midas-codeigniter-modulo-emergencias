<?php
/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Sendmail_Model extends CI_Model {

    public function emailSend($to = null, $cc = null, $bcc = null, $subject = null, $message = null) {
        
        $this->load->library('email');

        $this->email->from('noresponder@minsal.cl', 'MIDAS - MINSAL');
        $this->email->to($to);
        $this->email->cc($cc);
        if($bcc!=null)
        {   
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }

}
