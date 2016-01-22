<?php

class Mapa extends MY_Controller {
    
    /**
     *
     * @var template
     */
    public $template;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $_emergencia_comuna_model;
    
    /**
     *
     * @var Alarma_Model 
     */
    public $_alarma_model;
    
    /**
     *
     * @var Capa_Model 
     */
    public $_capa_model;
    
    /**
     *
     * @var Archivo_Model 
     */
    public $_archivo_model;
    
    /**
     *
     * @var Emergencia_Capa_Model 
     */
    public $_emergencia_capas_model;
    
    /**
     *
     * @var Emergencia_Elemento_Model 
     */
    public $_emergencia_elementos_model;
    
    /**
     *
     * @var Capa_Poligono_Informacion_Model
     */
    public $_capa_poligono_informacion_model;
    
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
     * @var Comuna_Model
     */
    public $_comuna_model;
    
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
        $this->load->model("emergencia_capa_model", "_emergencia_capas_model");
        $this->load->model("emergencia_elemento_model", "_emergencia_elementos_model");
        $this->load->model("emergencia_comuna_model","_emergencia_comuna_model");
        $this->load->model("alarma_model", "_alarma_model");
        $this->load->model("capa_model", "_capa_model");
        $this->load->model("comuna_model", "_comuna_model");
        $this->load->model("capa_poligono_informacion_model", "_capa_poligono_informacion_model");
        $this->load->model("capa_geometria_model", "_capa_geometria_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
        $this->load->model("archivo_model", "_archivo_model");
    }
    
    /**
     * Carga de mapa para emergencia
     * @throws Exception
     */
    public function index(){
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));
            $this->template->parse("default", "pages/mapa/index", $data);
        } else {
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
    
    /**
     * Guarda configuracion del mapa
     */
    public function save(){
        $this->load->library("visor/guardar/visor_guardar_elemento");
        
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $this->visor_guardar_elemento->setEmergencia($emergencia->eme_ia_id)
                                         ->guardar($params["elementos"]);
            
            
            
            $this->_emergencia_capas_model->query()
                                          ->insertOneToMany("id_emergencia", 
                                                            "id_geometria", 
                                                            $emergencia->eme_ia_id, 
                                                            $params["capas"]);
            $data = array("correcto" => true,
                          "error" => "");
        } else {
            $data = array("correcto" => false,
                          "error" => "La emergencia no existe");
        }
        
        echo json_encode($data);
    }
    
    /**
     * 
     */
    public function popup_lugar_emergencia(){
        $this->load->view("pages/mapa/popup-lugar-emergencia", array());
    }
    
    /**
     * Popup que muestra capas
     * @throws Exception
     */
    public function popup_capas(){
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
                
                $this->load->view("pages/mapa/popup-capas", 
                                   array("capas" => $lista_capas,
                                         "seleccionadas" => $params["capas"],
                                         "comunas" => $lista_comunas));
            }
        } else {
            throw new Exception("La emergencia no existe");
        }
    }
    
    /**
     * Muestra información del poligono
     */
    public function popup_informacion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = json_decode($params["informacion"]);
        
        $subcapa = $this->_capa_geometria_model->getById($params["capa"]);
        
        if(is_null($subcapa)){
            $nombre_subcapa = "";
            $nombre_capa    = "";
            $nombre_tipo    = "";
        } else {
            $capa    = $this->_capa_model->getById($subcapa->geometria_capa);
            $tipo    = $this->_tipo_capa_model->getById($capa->ccb_ia_categoria);
            $nombre_subcapa  = $subcapa->geometria_nombre;
            $nombre_capa     = $capa->cap_c_nombre;
            $nombre_tipo     = $tipo["ccb_c_categoria"];
        }        

        $this->load->view("pages/mapa/popup-informacion", 
                          array("nombre_subcapa" => $nombre_subcapa,
                                "tipo" => $params["tipo"],
                                "color" => $params["color"],
                                "nombre_capa"    => $nombre_capa,
                                "nombre_tipo"   => $nombre_tipo,
                                "informacion" => $informacion,
                                "lista_marcadores"  => json_decode($params["marcadores"])));
    }
    
    /**
     * Valida el lugar de la emergencia
     */
    public function ajax_guardar_lugar_emergencia(){
        header('Content-type: application/json');
        
        $retorno = array("correcto" => false);
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $filter = New Zend_Filter_Digits();
            $metros = $filter->filter($params["metros"]);
            if($metros == ""){
                $retorno["error"] = array("metros" => "Debe ingresar un valor numerico");
            } else {
                $data = array("eme_radio" => $metros,
                              "eme_c_utm_lat" => $params["lat"],
                              "eme_c_utm_lng" => $params["lon"]);
                //$this->_emergencia_model->update($data, $emergencia->eme_ia_id);
                $retorno = array("correcto" => true,
                                 "error" => array("metros" => ""));
            }
        }
        echo json_encode($retorno);
    }
    
    /**
     * 
     */
    public function ajax_elemento(){
        $this->load->helper(array("modulo/capa/capa"));
        $json = array();
        header('Content-type: application/json');
        $data = array("correcto" => false,
                      "error" => "");
        $params = $this->input->post(null, true);
        $elemento = $this->_capa_poligono_informacion_model->getById($params["id"]);
        if(!is_null($elemento)){
            $subcapa = $this->_capa_geometria_model->getById($elemento->poligono_capitem);
            $capa    = $this->_capa_model->getById($subcapa->geometria_capa);
            
            if($subcapa->geometria_icono != ""){
                $icono = base_url($subcapa->geometria_icono);
            } else {
                $icono = base_url($capa->icon_path);
            }
            
            $json = array("id" => $elemento->poligono_id,
                           "id_subcapa" => $elemento->poligono_capitem,
                           "propiedades" => $this->_limpiarUnserialize($elemento->poligono_propiedades),
                           "geojson"     => unserialize($elemento->poligono_geometria),
                           "zona" => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                           "color" => $capa->color,
                           "icono" => $icono);
        }
        $data["correcto"] = true;
        $data["resultado"] = $json;
        echo json_encode($data);
    }
    
    /**
     * Carga datos de una capa
     */
    public function ajax_capa(){
        header('Content-type: application/json');
        $data = array("correcto" => false,
                      "error" => "La capa no existe o no pudo ser cargada");
        
        $params = $this->input->post(null, true);
        
        if($params["id_emergencia"] != "" AND $params["id_emergencia"] != "null"){
            $lista_comunas = $this->emergencia_comuna->listComunas($params["id_emergencia"]);
        } else {
            $comunas = array();
            $lista_comunas_all = $this->_comuna_model->listar();
            fb($lista_comunas_all);
            if(count($lista_comunas_all)>0){
                foreach($lista_comunas_all as $comuna){
                    $comunas[] = $comuna["com_ia_id"];
                }
            }
            $lista_comunas = $comunas;
        }
        
        
        
        if(count($lista_comunas)>0){
            $resultado = $this->_cargaCapa($params["id"], $lista_comunas);
            if(!is_null($resultado)){
                $data = array("correcto" => true,
                              "capa" => $resultado);
            }
        }
        
        echo Zend_Json_Encoder::encode($data);
    }
    
    /**
     * Carga elementos custom
     */
    public function ajax_elementos_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => true,
                      "resultado" => array("elemento" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $lista_elementos = $this->_emergencia_elementos_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_elementos)>0){
                foreach($lista_elementos as $elemento){

                    $clave = "elemento_" . $elemento["id"];
                    
                    
                    $data["correcto"] = true;
                    $data["resultado"]["elemento"][$elemento["id"]] = array("tipo" => $elemento["tipo"],
                                                                            "propiedades" => json_decode($elemento["propiedades"]),
                                                                            "coordenadas" => json_decode($elemento["coordenadas"]),
                                                                            "color" => $elemento["color"],
                                                                            "icono" => $elemento["icono"],
                                                                            "clave" => $clave);
                    
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene elementos asociadados";
        }
        
        echo json_encode($data);
    }
    
    /**
     * Retorna las capas asociadas a una emergencia
     */
    public function ajax_capas_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => true,
                      "resultado" => array("capas" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $lista_comunas = $this->emergencia_comuna->listComunas($emergencia->eme_ia_id);

            $lista_capas = $this->_emergencia_capas_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_capas)>0){
                foreach($lista_capas as $capa){
                    $resultado = $this->_cargaCapa($capa["id_geometria"], $lista_comunas);
                    if(!is_null($resultado)){
                        $data["correcto"] = true;
                        $data["resultado"]["capas"][$capa["id_geometria"]] = $resultado;
                    }
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene capas asociadas";
        }
        
        echo json_encode($data);
    }
    
    /**
     * 
     */
    public function ajax_marcador_lugar_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => false);
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $alarma = $this->_alarma_model->getById($emergencia->ala_ia_id);
            if(!is_null($alarma)){
                $data = array("correcto"  => true,
                              "resultado" => array("lat" => $emergencia->eme_c_utm_lat,
                                                   "lon" => $emergencia->eme_c_utm_lng,
                                                   "radio" => $emergencia->eme_radio,
                                                   "nombre" => $emergencia->eme_c_nombre_emergencia,
                                                   "zona" => $alarma->ala_c_geozone));
            } else {
                $data["error"] = "La alarma no existe";
            }
            
        } else {
            $data["error"] = "La emergencia no existe";
        }
        
        echo json_encode($data);
    }
    
    /**
     * Retorna datos de ubicacion de la alarma
     * @throws Exception
     */
    public function ajax_marcador_lugar_alarma(){
        header('Content-type: application/json');
        $data = array("correcto" => false);
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $alarma = $this->_alarma_model->getById($emergencia->ala_ia_id);
            if(!is_null($alarma)){
                $data = array("correcto"  => true,
                              "resultado" => array("lat" => $alarma->ala_c_utm_lat,
                                                   "lon" => $alarma->ala_c_utm_lng,
                                                   "nombre" => $alarma->ala_c_nombre_informante,
                                                   "zona" => $alarma->ala_c_geozone));
            } else {
                $data["error"] = "La alarma no existe";
            }
            
        } else {
            $data["error"] = "La emergencia no existe";
        }
        
        echo json_encode($data);
    }
    
    /**
     * Carga datos de una capa
     * @param int $id_capa
     * @return array
     */
    protected function _cargaCapa(
        $id_subcapa, 
        array $comunas = array()
    ){
        fb("Cargando capa " . $id_subcapa);
        $retorno = null;
        
        $subcapa = $this->_capa_geometria_model->getById($id_subcapa);
        if(!is_null($subcapa)){
            $capa = $this->_capa_model->getById($subcapa->geometria_capa);
            if(!is_null($capa)){
                $json = array();
                $lista_poligonos = $this->_capa_poligono_informacion_model->listarPorSubcapaComuna($subcapa->geometria_id, $comunas);
                if(count($lista_poligonos)>0){
                    foreach($lista_poligonos as $poligono){
                        $json[] = array(
                            "id" => $poligono["poligono_id"],
                            "propiedades" => unserialize($poligono["poligono_propiedades"]),
                            "geojson"     => unserialize($poligono["poligono_geometria"])
                            );
                    }
                }
                
                $icono = "";
                if(!empty($subcapa->geometria_icono)){
                    $icono = base_url($subcapa->geometria_icono);
                } else {
                    if(!empty($capa->icon_path)){
                        $icono = base_url($capa->icon_path);
                    }
                }
                
                $retorno = array("zona"  => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                                 "icono" => $icono,
                                 "color" => $capa->color,
                                 "json"  => $json);

            }
        }
        return $retorno;
    }
    
    /**
     * Limpia datos de caracteres extraños
     * para envio como parametros
     * @param string $string
     * @return array
     */
    protected function _limpiarUnserialize($string){

        $filter = New Zend_Filter_Alnum();
        
        $nuevo = array();
        
        $array = unserialize($string);
        if(count($array)>0){
            foreach($array as $nombre => $valor){
                $nuevo[$filter->filter($nombre)] = $valor;
            }    
        }
         return $nuevo;
    }
}
