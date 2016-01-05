<?php

Class Layout_Text_MoreLess{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * Largo en caracteres
     * @var int
     */
    protected $_largo;
    
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
     * @param int $largo
     */
    public function setLargo($largo){
        $this->_largo = $largo;
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
        return substr(strip_tags($this->_string), 0, $this->_largo);
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        
       $texto_completo = $this->getCompleteString();
       $texto_corto    = $this->getTeaserString();
       
       if($texto_completo != $texto_corto){
       
            $html = "<div>"
                   ."<span class=\"more-less teaser\">".$texto_corto." ...</span> \n"
                   ."<span class=\"more-less text-complete\">".$texto_completo."</span> \n"
                   ."<span class=\"more-less text-more small\">[Ver mas]</span>"
                   ."</div>";
            return $html;
       } else {
           return $texto_completo;
       }
    }
}

