<?php

/**
 * Clase para crear un elemento select
 */
Abstract Class Cosof_Form_Abstract {
    
    /**
     * Atributos del elemento
     * @var array 
     */
    protected $_atributos = array();
    
    /**
     * Clase del elemento html
     * @var string 
     */
    protected $_class = "form-control";
    
    /**
     * Agregar los atributos
     * @param array $array
     */
    public function addAtributos($array){
        $this->_atributos = $array;
    }
    
    /**
     * Añadir la clase del elemento html
     * @param string $string
     */
    public function addClass($string){
        $this->_class = $string;
    }
}

