<?php

Class Layout_template{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    /**
     * 
     * @param type $template
     * @param type $content
     * @param type $params
     */
    public function view($template, $content, $params){
        $body = $this->_ci->load->view($content, $params, true);
        $this->_ci->load->view("templates/" . $template, array("content" => $body));
    }
}

