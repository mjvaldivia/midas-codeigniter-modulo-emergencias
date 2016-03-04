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
    
    /**
     * 
     */
    public function ajax_carga_capa(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_elemento_region");
        
        $params = $this->input->post(null, true);
        $this->visor_capa_elemento_region->setRegion($params["id_region"]);
        $data = $this->visor_capa_elemento_region->cargaCapa($params["id"]);
        
        echo json_encode($data);
    }
    
    /**
     * Carga capas para region
     */
    public function ajax_capas_region(){
        $this->load->helper("modulo/visor/visor");
        $id = $this->input->post('id');
        $this->load->view("pages/visor/capas", array("id" => $id), false);
    }
}

