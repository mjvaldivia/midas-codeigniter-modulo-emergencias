<?php

Class Arreglo{
    
    /**
     * 
     * @param type $arreglo
     * @param type $subindice
     * @return type
     */
    public function arrayToArray($arreglo, $subindice){
        $salida = array();
        if(count($arreglo)>0){
            if(isset($arreglo[0][$subindice])){
                foreach($arreglo as $valor){
                    $salida[] = $valor[$subindice];
                }
            } else {
                $salida = $arreglo;
            }
        }
        return $salida;
    }
    
    /**
     * 
     * @param array $arreglo
     * @param separador $separador
     * @param indice de los valores del array $subindice
     * @return string
     */
    public function arrayToString($arreglo, $separador, $subindice){
        $string = "";
        $coma   = "";
        if(count($arreglo)>0){
            foreach($arreglo as $valor){
                $string .= $coma.$valor[$subindice];
                $coma = ",";
            }
        }
        return $string;
    }
}

