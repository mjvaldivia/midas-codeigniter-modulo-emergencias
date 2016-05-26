<?php

Class Random{
    
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
   
}

