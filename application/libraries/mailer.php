<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class mailer {
    
    function email()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($exceptions=false)
    {
        include_once APPPATH.'/third_party/phpmailer/class.phpmailer.php';
         include_once APPPATH.'/third_party/phpmailer/class.smtp.php';
       
         
        return new PHPMailer($exceptions);
    }
}

