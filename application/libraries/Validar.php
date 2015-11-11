<?php

Class Validar{
    
    /**
     * 
     * @param string $fecha
     * @return boolean
     */
    public function validarFechaSpanish($fecha){
        $date = DateTime::createFromFormat("d-m-Y h:i", $fecha);
        if($date instanceof DateTime){
            return true;
        } else {
            return false;
        }
    }
    
    public function validarVacio($string){
        if(strip_tags(TRIM($string)) == ""){
            return false;
        } else {
            return true;
        }
    }
}

