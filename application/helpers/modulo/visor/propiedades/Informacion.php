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
                   . "<div class=\"col-lg-4\">" . $nombre . ":</div>"
                   . "<div class=\"col-lg-8\">" . utf8_encode($valor) . "</div>"
                   . "</div>";
        }
        return $html;
    }
    
}
