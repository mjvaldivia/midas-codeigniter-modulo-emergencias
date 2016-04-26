<?php

Class String{
    
    /**
     * Genera un nombre aleatorio para el archivo temporal
     * @param int $length
     * @return string
     */
    public function rand_string( $length ) {
        $str = "";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
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

