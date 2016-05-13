<?php

Class Layout_Assets_View{
    
        /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    /**
     * 
     * @return string
     */
    public function cssToHtml(){
        $html = "";
        if(Zend_Registry::isRegistered("css")){
            $lista = Zend_Registry::get("css");
            foreach($lista as $css){
                $html .= "<link rel=\"stylesheet\" href=\"".($css)."\" type=\"text/css\"/> \n";
            }
        }
        return $html;
    }
    
    /**
     * 
     * @return string
     */
    public function jsToHtml(){
        $html = "";
        if(Zend_Registry::isRegistered("js")){
            $lista = Zend_Registry::get("js");
            foreach($lista as $js){
                $html .= "<script type=\"text/javascript\" src=\"".($js)."\"></script>\n";
            }
        }
        return $html;
    }
}
