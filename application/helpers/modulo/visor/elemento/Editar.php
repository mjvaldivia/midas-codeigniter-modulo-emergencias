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
        
        switch ($tipo) {
            case "CIRCULO":
            case "RECTANGULO":
            case "POLIGONO":
                break;
            default:
                break;
        }
        
        $this->_tipo = $tipo;
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
        return $this->_ci->load->view("pages/mapa/form-editar-elemento", array("propiedades" => $this->_propiedades), true);
    }
    
}

