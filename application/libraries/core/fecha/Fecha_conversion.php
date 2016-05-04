<?php

Class Fecha_conversion{
    
    /**
     * Convierte string a datetime de acuerdo a los formatos de fecha
     * @param string $fecha
     * @param string $formatos
     * @return \DateTime
     */
    public function fechaToDateTime($fecha, $formatos = array()){
        
        $fecha_final = null;
        foreach($formatos as $formato){
            $fecha_final = DateTime::createFromFormat($formato, $fecha);
            if($fecha_final instanceof DateTime){
                break;
            }
        }
        return $fecha_final;
        
    }
}

