<?php

Class Visor_Elemento_Informacion_Totales{
    
    /**
     * Tipos de columna con totales
     * @var array
     */
    protected $_tipos = array(
        "VIVIENDAS"
    );
    
    /**
     *
     * @var array 
     */
    protected $_lista = array();
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * 
     * @param array $lista
     */
    public function __construct($lista) {
        $this->_ci =& get_instance();
        $this->_lista = $lista;
    }
    
    /**
     * 
     */
    public function render(){
        $totales = $this->_getTotales();
        if(count($totales)>0){
            return $this->_ci->load->view(
                "pages/mapa/popup-informacion/totales", 
                array("totales" => $totales), 
                true
            );
        }
    }
    
    /**
     * 
     * @return array
     */
    protected function _getTotales(){
        $totales = array();
        foreach($this->_lista as $item){
            foreach($item->informacion as $key => $valor){
                $existe = array_search($key, $this->_tipos);
                if($existe === false){
                    
                } else {
                    if(!isset($totales[$key])){
                        $totales[$key] = 0;
                    }
                    
                    $totales[$key] += $valor;
                }
                
            }
        }
        return $totales;
    }
}

