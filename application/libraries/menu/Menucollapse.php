<?php

Class Menucollapse{
    
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
     * Setea el menu
     */
    public function setCollapse(){
        $menu_collapse = $this->session->userdata("menu_collapse");
        if($menu_collapse){
            $this->session->set_userdata("menu_collapse", false);
        } else {
            $this->session->set_userdata("menu_collapse", true);
        }
    }
}

