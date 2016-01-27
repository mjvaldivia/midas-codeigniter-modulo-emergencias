<?php

class Mapa_capas extends MY_Controller {
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Capa_Geometria_Model
     */
    public $_capa_geometria_model;
    
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
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("capa_geometria_model", "_capa_geometria_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
    }
    
    /**
     * 
     */
    public function ajax_carga_capa_comuna(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_comuna");
        
        $params = $this->input->post(null, true);
        $data = $this->visor_capa_comuna->cargaCapa($params["id"], $params["id_emergencia"]);
        
        echo json_encode($data);
    }
    
    /**
    * 
    */
    public function ajax_carga_capa_region(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_region");
        $params = $this->input->post(null, true);
        
        $carga = $this->visor_capa_region->cargaCapa($params["id_emergencia"]);

        $data = array("correcto" => true,
                      "capa" => $carga);
        
        echo json_encode($data);
    }
    
    /**
    * 
    */
    public function ajax_carga_capa_provincia(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_provincia");
        $params = $this->input->post(null, true);
        
        $carga = array();
        
        $lista_subcapa = $this->_capa_geometria_model->listarGeometriaProvincias();
        if(!is_null($lista_subcapa)){
            foreach($lista_subcapa as $subcapa){
                 $carga = array_merge($carga , $this->visor_capa_provincia->cargaCapa($subcapa["geometria_id"], $params["id_emergencia"]));
            }
        }
        
        $data = array("correcto" => true,
                      "capa" => $carga);
        
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

