<?php

class Visor extends MY_Controller {
    
     /**
     * Carga de mapa para emergencia
     * @throws Exception
     */
    public function index(){
        $this->load->helper("modulo/visor/visor");
        $data = array("js" => $this->load->view("pages/mapa/js-plugins", array(), true));
        $this->template->parse("default", "pages/visor/index", $data);
    }
}

