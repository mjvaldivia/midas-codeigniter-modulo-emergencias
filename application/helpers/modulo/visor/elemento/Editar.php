<?php

Class Visor_Elemento_Editar{
    
    /**
     * Color por defecto
     * @var string
     */
    protected $_color = "#ffff00";
    
    /**
     *
     * @var string 
     */
    protected $_tipo;
    
    /**
     *
     * @var array 
     */
    protected $_propiedades;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * 
     * @param array $propiedades
     */
    public function __construct($tipo) {
        $this->_ci =& get_instance();        
        $this->_tipo = $tipo;
    }
    
    /**
     * 
     * @param string $color
     */
    public function setColor($color){
        if(!is_null($color)){
            $this->_color = $color;
        }
    }
    
    /**
     * 
     * @param string $propiedades
     */
    public function setPropiedades($propiedades){
        $this->_propiedades = $propiedades;
    }
    
    /**
     * Retorna propiedades
     * @return string html
     */
    public function render(){
        
        switch ($this->_tipo) {
            case "POLIGONO":
            case "RECTANGULO":
            case "CIRCULO":
                $editar_forma = true;
                break;
            default:
                $editar_forma = false;
                break;
        }
        
        
        return $this->_ci->load->view(
            "pages/mapa/form/elemento-editar", 
            array(
                "tipo" => $this->_tipo,
                "editar_forma" => $editar_forma,
                "color" => $this->_color,
                "propiedades" => $this->_propiedades
            ), 
            true
        );
    }
    
}

