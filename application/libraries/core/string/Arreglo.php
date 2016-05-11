<?php

Class Arreglo{
    
    public function arrayToArray($arreglo, $subindice){
        $salida = array();
        if(count($arreglo)>0){
            foreach($arreglo as $valor){
                $salida[] = $valor[$subindice];
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

