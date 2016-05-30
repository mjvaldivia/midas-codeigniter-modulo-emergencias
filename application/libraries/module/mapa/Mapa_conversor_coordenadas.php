<?php

Class Mapa_conversor_coordenadas{
    
    /**
     * De grados decimales a grados, minutos y segundos
     * @param float $coordenada
     */
    public function gradosToGms($coordenada){
        $coordenada = abs((float) $coordenada);
        fb($coordenada);
        $grados = (int) $coordenada;
        
        $decimales = ($coordenada - $grados);
        fb($decimales);
        
        $minutos = (($decimales)* 60);
        
        fb($minutos);
        
        $segundos = (int) ( ($minutos - ((int) $minutos)) * 60 );
        
        return array("grados" => (string) $grados . "°",
                     "minutos" => (string)( (int) $minutos ) . "''",
                     "segundos" => (string) ($segundos) .  "'");
    }
}

