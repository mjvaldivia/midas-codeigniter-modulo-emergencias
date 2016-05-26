<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once(FCPATH . "application/third_party/Vigilancia/controllers/casos_febriles.php");

class Casos_febriles_arica_y_parinacota extends Vigilancia_Casos_febriles
{
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_id_region = Region_Model::REGION_ARICA;
    }
       
}

