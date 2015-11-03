<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * Clase para crear un elemento select
 */
Class Cosof_Form_Select extends Cosof_Form_Abstract{
        
    /**
     * Campo para valor del option
     * @var string
     */
    protected $_option_val = "id";
    
    /**
     * Campo para el nombre del option
     * @var string 
     */
    protected $_option_name = "nombre";
    
    /**
     * Valores
     * @var  
     */
    protected $_valores = array();
    
    /**
     *
     * @var string 
     */
    protected $_nombre;
    
    /**
     * Funcion que devuelve resultados
     */
    public function populate($array){
        $this->_valores = $array;
    }
    
    /**
     * Nombre de input
     * @param string $nombre
     */
    public function setNombre($nombre){
        $this->_nombre = $nombre;
    }
    
    /**
     * Nombre del metodo para sacarl el nombre del option
     * @param string $string
     */
    public function setOptionName($string){
        $this->_option_name = $string;
    }
    
     /**
     * Nombre del metodo para sacarl el value del option
     * @param string $string
     */
    public function setOptionId($string){
        $this->_option_val = $string;
    }
    
    
    
    /**
     * Genera el elemento select
     * @param string $id identificador y nombre del elemento select
     * @param string $default valor seleccionado por defecto
     * @return string
     */
    public function render($id, $default){
        $atributos = "";
        foreach($this->_atributos as $nombre => $valor){
            $atributos .= " " . $nombre . "=\"".$valor."\"";
        }

        $html = "<select name=\"" . $this->_nombre . "\" id=\"" . $this->_limpiaId($id) . "\" ".$atributos." class=\"" . $this->_class . "\">";
        $html.= "<option value=\"\">Seleccione un valor</option>";
        foreach($this->_valores as $row){
            $selected = "";

            if(!is_array($default)){
                if($default == $row[$this->_option_val]){
                    $selected = "selected=\"selected\"";
                }
            } else {
                $existe = array_search($row[$this->_option_val], $default);
                if($existe === false){
                    //void
                } else {
                    $selected = "selected=\"selected\"";
                }
            }

            $html .= "<option value=\"".$row[$this->_option_val]."\" " . $selected . ">"
                    . $row[$this->_option_name]
                   . "</option>";
        }
        $html .= "</select>";

        return $html;
    }
    
    /**
     * Limpia el id del input para multiselect
     * @param string $string
     * @return string
     */
    protected function _limpiaId($string){
       return str_replace("]", "", str_replace("[", "", $string));
    }
}

