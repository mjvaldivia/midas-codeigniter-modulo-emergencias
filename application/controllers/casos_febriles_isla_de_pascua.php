<?php

require_once(FCPATH . "application/third_party/Vigilancia/controllers/casos_febriles.php");

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Casos_febriles_isla_de_pascua extends Vigilancia_Casos_febriles
{
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_id_region = Region_Model::REGION_VALPARAISO;
        $this->_id_comuna = Comuna_Model::ISLA_DE_PASCUA;
    }
       
}

