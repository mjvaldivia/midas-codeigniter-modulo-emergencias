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
        $html = "";
        foreach($this->_propiedades as $nombre => $valor){
            $html .= "<div class=\"row\">"
                   . "<div class=\"col-ls-4\">" . $nombre . ":</div>"
                   . "<div class=\"col-ls-8\">" . $valor . "</div>"
                   . "</div>";
        }
        return $html;
    }
    
}

