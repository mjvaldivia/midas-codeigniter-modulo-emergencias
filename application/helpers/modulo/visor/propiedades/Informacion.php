<?php

Class Visor_Propiedades_Informacion{
    
    /**
     *
     * @var array 
     */
    protected $_propiedades;
    
    /**
     * 
     * @param array $propiedades
     */
    public function __construct($propiedades) {
        $this->_propiedades = $propiedades;
    }
    
    /**
     * Retorna propiedades
     * @return string html
     */
    public function render(){
        $html = "<div class=\"row\">";
        foreach($this->_propiedades as $nombre => $valor){
            $html .= "<div class=\"col-lg-2 text-right\"><strong>" . $nombre . ":</strong></div>"
                   . "<div class=\"col-lg-4 text-left\">" . $valor . "</div>";
                   
        }
        $html .= "</div>";
        return $html;
    }
    
}

