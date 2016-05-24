<?php

Class Layout_assets{
    
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
     * Agrega los JS para agregar un mapa al formulario
     */
    public function addMapaFormulario(){
        //$this->addJs("https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBqmaRNgLR0AZU8l7PPITUFJ4EBQD_A_4g");
       // $this->addJs("http://200.55.194.54/emergencias/assets/js/modulo/mapa/formulario.js");
    }
    
    /**
     * Añade css al stack
     * @param string $css
     */
    public function addCss($css){
        
        if(Zend_Registry::isRegistered("css")){
            $lista_css = Zend_Registry::get("css");
        } else {
            $lista_css = array();
        }
        
        $lista_css[] = $css;
        
        Zend_Registry::set("css", $lista_css);
    }
    
    /**
     * Añade JS al stack
     * @param string $js
     */
    public function addJs($js){

        if(Zend_Registry::isRegistered("js")){
            $lista_js = Zend_Registry::get("js");
        } else {
            $lista_js = array();
        }
        
        if(strpos($js, "http") === false){
            $lista_js[] = base_url("assets/js/" . $js);
        } else {
            $lista_js[] = $js;
        }
        
        Zend_Registry::set("js", $lista_js);
        return $this;
    }
}

