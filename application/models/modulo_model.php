<?php

class Modulo_Model extends MY_Model {
    
    const MODULO_EMERGENCIA = 2;
    
    
    /**
     * Modulos del sistema
     */
    const SUB_MODULO_ALARMA = 6;
    const SUB_MODULO_EMERGENCIA = 7;
    const SUB_MODULO_CAPAS = 40;
    const SUB_SIMULACION   = 41;
    const SUB_DOCUMENTACION = 42;

    /**
     *
     * @var string 
     */
    protected $_tabla = "permisos";
    

}

