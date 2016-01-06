<?php

Class Alarma_Form_Value_EmergenciaTipoChecked{
    
    /**
     *
     * @var string 
     */
    protected $_value;
    
    /**
     * 
     * @param string $value
     */
    public function setValue($value){
        $this->_value = $value;
    }
    
    /**
     * Retorna el valor y si esta seleccionado o no
     * @param string $selected valor seleccionado
     * @return string html
     */
    public function render($selected){
        if($selected == $this->_value) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        }
        return " value=\"".$this->_value."\" " . $checked . " ";
    }
}

