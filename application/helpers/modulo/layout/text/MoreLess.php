<?php

Class Layout_Text_MoreLess{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var string 
     */
    protected $_string;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    /**
     * 
     * @param string $string
     */
    public function setString($string){
        $this->_string = $string;
    }
    
    /**
     * 
     * @return string
     */
    public function getCompleteString(){
        return $this->_string;
    }
    
    /**
     * 
     * @return string
     */
    public function getTeaserString(){
        return substr(strip_tags($this->_string), 0, 30);
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        
       $texto_completo = $this->getCompleteString();
       $texto_corto    = $this->getTeaserString();
       
       if($texto_completo != $texto_corto){
       
            $html = "<span class=\"teaser\">".$texto_corto." ...</span> \n"
                   ."<span class=\"text-complete\">".$texto_completo."</span> \n"
                   ."<span class=\"text-more small\">[Ver mas]</span>";
            return $html;
       } else {
           return $texto_completo;
       }
    }
}

