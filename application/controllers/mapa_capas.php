<?php

class Mapa_capas extends MY_Controller {
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Capa_Detalle_Model
     */
    public $_capa_detalle_model;
    
    /**
     *
     * @var Categoria_Cobertura_Model
     */
    public $_tipo_capa_model;
    
    /**
     *
     * @var Emergencia_Comuna 
     */
    public $emergencia_comuna;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("emergencia/emergencia_comuna");
        $this->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
    }
    
    /**
     * Retorna cantidad de capas por emergencia
     */
    public function ajax_contar_capas_comuna(){
        header('Content-type: application/json');        
        $params = $this->input->post(null, true);
        
        $cantidad = $this->_emergencia_capa_model->contarPorEmergencia($params["id"]);
        
        echo json_encode(array("cantidad" => $cantidad));
    }
    
    /**
     * 
     */
    public function ajax_carga_capa(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_elemento");
        
        $params = $this->input->post(null, true);
        $this->visor_capa_elemento->setEmergencia($params["id_emergencia"]);
        $data = $this->visor_capa_elemento->cargaCapa($params["id"]);
        
        echo json_encode($data);
    }
    
    /**
     * Retorna las capas asociadas a una emergencia y comuna
     */
    public function ajax_capas_comuna_emergencia(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_comuna");
        
        $params = $this->input->post(null, true);
        $data = $this->visor_capa_comuna->cargaCapasEmergencia($params["id"]);
        
        echo json_encode($data);
    }
    
    /**
     * Retorna las capas asociadas a una emergencia
     */
    public function ajax_capas_provincia_emergencia(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_cargar");
        
        $params = $this->input->post(null, true);
        $data = $this->visor_capa_cargar->cargaEmergencia($params["id"]);
        
        echo json_encode($data);
    }
    
    /**
     * Popup que muestra capas
     * @throws Exception
     */
    public function popup_capas_comuna(){
        $this->load->helper(array("modulo/capa/capa",
                                  "modulo/visor/visor"));
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $lista_comunas = $this->emergencia_comuna->listComunas($emergencia->eme_ia_id);
            
            if(count($lista_comunas)>0){
                $lista_capas = array();
                
                $lista_tipos = $this->_tipo_capa_model->listarCategoriasPorComunas($lista_comunas);
                if(count($lista_tipos)>0){
                    foreach($lista_tipos as $tipo){
                        $lista_capas[] = array("id_categoria" => $tipo["ccb_ia_categoria"],
                                               "nombre_categoria" => $tipo["ccb_c_categoria"]);
                    }
                }
                
                $this->load->view("pages/mapa_capas/popup-capas", 
                                   array("capas" => $lista_capas,
                                         "seleccionadas" => $params["capas"],
                                         "comunas" => $lista_comunas));
            }
        } else {
            throw new Exception("La emergencia no existe");
        }
    }
}

