<?php

Class Validar{
    
    /**
     * 
     * @param string $fecha fecha
     * @param string $formato formato de entrada
     * @return boolean
     */
    public function validarFechaSpanish($fecha, $formato = "d-m-Y H:i"){
        $date = DateTime::createFromFormat($formato, $fecha);
        if($date instanceof DateTime){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param string $string
     * @return boolean
     */
    public function validarVacio($string){
        if(strip_tags(TRIM($string)) == ""){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 
     * @param array $array
     * @return boolean
     */
    public function validarArregloVacio($array){
        if(count($array)>0){
            return true;
        } else {
            return false;
        }
    }

    public function validarNumero($number){
        if(is_numeric($number)){
            return true;
        }else{
            return false;
        }
    }
}

