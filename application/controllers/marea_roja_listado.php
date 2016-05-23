<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once(__DIR__ . "/marea_roja.php");

class Marea_roja_listado extends Marea_roja
{
    /**
     *
     */
    public function index()
    {
        $this->layout_assets->addJs("modulo/marea_roja/listado/index.js");
        $this->layout_template->view(
            "default", 
            "pages/marea_roja_listado/index", 
            array()
        );
    }
}

