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
         header('Content-type: application/json');        
        
        $this->load->library("capa/Capa_region_disponibles");
        
        $params = $this->input->post(null, true);
        $this->capa_region_disponibles->setRegion($params["id"]);
        
        echo json_encode(array("lista" => $this->capa_region_disponibles->getListaCapas()));
    }
}

