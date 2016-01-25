<?php
if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Alarma_Historial_Model extends MY_Model {

    protected $_tabla = "alertas_historial";

    function __construct()
    {
        parent::__construct();
    }


}