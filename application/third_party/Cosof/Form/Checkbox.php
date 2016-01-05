<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * Clase para crear un elemento select
 */
Class Formulario_View_Helper_Element_Checkbox extends Formulario_View_Helper_Element_Abstract{
    
    /**
     *
     * @var boolean 
     */
    protected $_valor = false;
    
    /**
     * Clase del elemento html
     * @var string 
     */
    protected $_class = "";
    
    /**
     * Setea el valor del check
     * @param int $valor
     */
    public function setValor($valor){
        if($valor == 1){
            $this->_valor = true;
        }
    }
    
    /**
     * 
     * @param string $id
     * @param string $nombre
     * @return string html
     */
    public function render($id, $nombre){
        return "<div class=\"checkbox\">
                    <label>
                      <input ".$this->_checked()." ".$atributos." class=\"" . $this->_class . "\" id=\"".$id."\" name=\"".$id."\" value=\"1\" type=\"checkbox\"/> ".$nombre."
                    </label>
                </div>";
    }
    
    /**
     * 
     * @return string
     */
    protected function _checked(){
        if($this->_valor){
            return "checked=\"checked\"";
        }
    }
}

