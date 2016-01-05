<?php

Class Layout_Menu_Collapse{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var CI_Session 
     */
    protected $session;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
        $this->session = New CI_Session();
    }
    
    /**
     * 
     * @return string
     */
    public function render($html_object){
        $menu_collapse = $this->session->userdata("menu_collapse");
        if($menu_collapse){
            return "";
        } else {
            return $this->_returnClass($html_object);
        }
    }
    
    /**
     * Retorna clase
     * @param string $html_object
     * @return string
     */
    protected function _returnClass($html_object){
        if($html_object == "navbar"){
            return "collapsed";
        } else {
            return "collapse";
        }
    }
}

