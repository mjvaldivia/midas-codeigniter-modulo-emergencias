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
        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->library("emergencia/emergencia_comuna");
        $this->load->model("emergencia_mapa_configuracion_model", "_emergencia_mapa_configuracion_model");
        $this->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->load->model("capa_detalle_elemento_model", "_capa_detalle_elemento_model");
        $this->load->model("capa_model", "_capa_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
    }
    
    /**
     * 
     */
    public function json_capa_hospital(){
        header('Content-type: application/json');  
        $params = $this->input->post(null, true);
        $lista = $this->_capa_detalle_elemento_model->listarPorComunaRegion($params["subcapa"], $params["region"]);
        
        $retorno = array();
        foreach($lista as $capa){
            $retorno[] = array(
                "id" => $capa["poligono_id"],
                "propiedades" => unserialize($capa["poligono_propiedades"])
            );
        }
        echo Zend_Json::encode($retorno);
    }
    
    /**
     * 
     */
    public function json_capa_elemento(){
        header('Content-type: application/json');  
        $params = $this->input->post(null, true);
        $lista = $this->_capa_detalle_elemento_model->getById($params["id"]);
        echo Zend_Json::encode($lista);
    }
    
    /**
     * Muestra información del poligono
     */
    public function popup_informacion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = json_decode($params["informacion"]);
        $coordenadas = Zend_Json::decode($params["geometry"]);
        $subcapa = $this->_capa_detalle_model->getById($params["capa"]);
        
        if(!is_null($subcapa)){
            $capa    = $this->_capa_model->getById($subcapa->geometria_capa);
            $tipo    = $this->_tipo_capa_model->getById($capa->ccb_ia_categoria);
            $nombre_subcapa  = $subcapa->geometria_nombre;
            $nombre_capa     = $capa->cap_c_nombre;
            $nombre_tipo     = $tipo["ccb_c_categoria"];
             

            $this->load->view(
                "pages/mapa_capas/popup-informacion", 
                array(
                    "nombre_subcapa" => $nombre_subcapa,
                    "tipo" => $params["tipo"],
                    "color" => $params["color"],
                    "identificador" => $params["identificador"],
                    "clave" => $params["clave"],
                    "nombre_capa"    => $nombre_capa,
                    "nombre_tipo"   => $nombre_tipo,
                    "informacion" => $informacion,
                    "coordenadas" => $coordenadas,
                    "lista_formas" => json_decode($params["formas"]),
                    "lista_marcadores"  => json_decode($params["marcadores"]))
                );
        } else {
            throw new Exception(__METHOD__ . " - La capa no existe");
        }
    }
    
    /**
     * Devuelve menu de capas fijas
     */
    public function ajax_menu_capas_fijas(){
        $this->load->view("pages/mapa_capas/menu-capas-fijas", array());
    }
    
    /**
     * 
     */
    public function ajax_form_filtros_casos_febriles(){
        $this->load->helper(array(
                "modulo/formulario/formulario"
            )
        );
        $this->load->view("pages/mapa_capas/form-filtros-casos", array());
    }
    
    /**
     * 
     */
    public function ajax_form_filtros_vectores(){
        $this->load->helper(array(
                "modulo/formulario/formulario"
            )
        );
        $this->load->view("pages/mapa_capas/form-filtros-vectores", array());
    }
    
    /**
     * 
     */
    public function ajax_form_filtros_marea_roja(){
        $this->load->helper(array(
                "modulo/formulario/formulario"
            )
        );
        $this->load->view("pages/mapa_capas/form-filtros-marea-roja", array());
    }
    
    /**
     * Devuelve json con capas validas para la emergencia
     */
    public function ajax_capas_disponibles_emergencia(){
        header('Content-type: application/json');        
        
        $this->load->library("emergencia/emergencia_capas_disponibles");
        
        $params = $this->input->post(null, true);
        $this->emergencia_capas_disponibles->setEmergencia($params["id"]);
        
        echo json_encode(array("lista" => $this->emergencia_capas_disponibles->getListaCapas()));
    }
    
    /**
     * Informacion de emergencia
     */
    protected function _informacionEmergencia($id_emergencia){
        $this->load->model("emergencia_comuna_model", "_emergencia_comuna_model");

        $retorno = array(
            "comunas" => array(),
            "provincias" => array(),
            "regiones" => array()
        );
        
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($id_emergencia);
        foreach($lista_comunas as $comuna){
            $retorno["comunas"][] = $comuna["com_ia_id"];
        }
        
        $lista_provincias = $this->_emergencia_comuna_model->listaProvinciasPorEmergencia($id_emergencia);
        foreach($lista_provincias as $provincia){
            $retorno["provincias"][] = $provincia["prov_ia_id"];
        }
        
        $lista_regiones = $this->_emergencia_comuna_model->listaRegionesPorEmergencia($id_emergencia);
        foreach($lista_regiones as $region){
            $retorno["regiones"][] = $region["reg_ia_id"];
        }
        
        return $retorno;
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
     * 
     */
    public function ajax_capas_emergencia(){
        $params = $this->input->post(null, true);
        
        $lista_capas = $this->_emergencia_capa_model->listaIdsPorEmergencia($params["id"]);
        $configuracion = $this->_emergencia_mapa_configuracion_model->getByEmergencia($params["id"]);
        
        echo json_encode(
            array(
                "capas" => $lista_capas,
                "capas_fijas" => array(
                    "conaf" => $configuracion->kml_sidco,
                    "casos_febriles" => $configuracion->bo_casos_febriles,
                    "casos_febriles_zona" => $configuracion->bo_casos_febriles_zona
                )
            )
        );
    }
    
    /**
     * Retorna las capas asociadas a una emergencia y comuna
     */
    public function ajax_capas_comuna_emergencia(){
        header('Content-type: application/json');
        $this->load->library("visor/capa/visor_capa_elemento");
        
        $params = $this->input->post(null, true);
        $data = $this->visor_capa_elemento->cargaCapasEmergencia($params["id"]);
        
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

