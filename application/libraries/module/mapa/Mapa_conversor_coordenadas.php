<?php

Class Mapa_conversor_coordenadas{
    
    /**
     * De grados decimales a grados, minutos y segundos
     * @param float $coordenada
     */
    public function gradosToGms($coordenada){
        if($coordenada != ""){
            $coordenada = abs((float) $coordenada);

            $grados = (int) $coordenada;

            $decimales = ($coordenada - $grados);


            $minutos = (($decimales)* 60);



            $segundos = (int) ( ($minutos - ((int) $minutos)) * 60 );

            return array("grados" => (string) $grados . "°",
                         "minutos" => (string)( (int) $minutos ) . "''",
                         "segundos" => (string) ($segundos) .  "'");
        } else {
            return array("grados" => "",
                         "minutos" => "",
                         "segundos" => "");
        }
    }
}

