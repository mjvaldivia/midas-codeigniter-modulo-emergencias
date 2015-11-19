<?php

class Modulo_Model extends MY_Model {
    
    const MODULO_EMERGENCIA = 2;
    
    
    /**
     * Modulos del sistema
     */
    const SUB_MODULO_ALARMA = 6;
    const SUB_MODULO_EMERGENCIA = 7;
    const SUB_MODULO_CAPAS = 41;
    const SUB_SIMULACION   = 42;
    const SUB_DOCUMENTACION = 43;

    /**
     *
     * @var string 
     */
    protected $_tabla = "permisos";
    

}

