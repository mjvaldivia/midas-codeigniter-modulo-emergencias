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
     * @var Emergencia_Kml_Model 
     */
    public $_emergencia_kml_model;
    
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
        $this->load->model("emergencia_kml_model", "_emergencia_kml_model");
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
        
        $this->load->library(
            array(
                  "visor/guardar/visor_guardar_elemento",
                  "visor/guardar/visor_guardar_kml" 
                 )
        );
        
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $elementos = array();
            if(isset($params["elementos"])){
                $elementos = $params["elementos"];
            }
            
            $this->visor_guardar_elemento->setEmergencia($emergencia->eme_ia_id)
                                         ->guardar($elementos);
            
            
            $capas = array();
            if(isset($params["capas"])){
                $capas = $params["capas"];
            }
            
            $this->_emergencia_capas_model->query()
                                          ->insertOneToMany("id_emergencia", 
                                                            "id_geometria", 
                                                            $emergencia->eme_ia_id, 
                                                            $capas);
            
            $kml = array();
            if(isset($params["kmls"])){
                $kml = $params["kmls"];
            }
            
            
            $this->visor_guardar_kml->setEmergencia($emergencia->eme_ia_id)
                                    ->guardar($kml);
            
            
            $data = array("correcto" => true,
                          "error" => "");
        } else {
            $data = array("correcto" => false,
                          "error" => "La emergencia no existe");
        }
        
        echo json_encode($data);
    }
    
    public function ajax_contar_elementos(){
        header('Content-type: application/json');        
        $params = $this->input->post(null, true);
        
        $cantidad = $this->_emergencia_elementos_model->contarPorEmergencia($params["id"]);
        
        echo json_encode(array("cantidad" => $cantidad));
    }
    
    /**
     * 
     */
    public function popup_importar_kml(){
        $this->load->view("pages/mapa/popup-importar-kml", array());
    }
    
    /**
     * 
     */
    public function kml(){
         $params = $this->uri->uri_to_assoc();
         $kml = $this->_emergencia_kml_model->getById($params["id"]);
         if(!is_null($kml)){
            header("Content-Type: text/plain");
            header("Content-Disposition: inline;filename=archivo." . $kml->tipo); 
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public'); 
            echo $kml->kml;
         }
    }
    
    /**
     * Muestra KML temporal
     * @throws Exception
     */
    public function kml_temporal(){
        $this->load->library(array("cache"));
        $params = $this->uri->uri_to_assoc();
        $cache = Cache::iniciar();
        if($archivo = $cache->load($params["hash"])){
            
            switch ($archivo["tipo"]) {
                case "kml":
                    $content_type = "text/plain";  
                    break;
                case "kmz":
                    $content_type = "text/plain"; 
                    break;
                default:
                    throw new Exception(__METHOD__ . " - El tipo de archivo no es valido");
                    break;
            }

            header("Content-Type: " . $content_type);
            header("Content-Disposition: inline;filename=" . $archivo["archivo_nombre"]); 
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public'); 
            echo $archivo["archivo"];
        }
    }
    
    /**
     * Sube KML a archivo temporal
     */
    public function upload_kml(){
        header('Content-type: application/json');
        
        $this->load->library(array(
            "visor/upload/visor_upload_temp_kml")
        );
        
        $params = $this->input->post(null, true);
        
        $correcto = true;
        $error    = array("nombre" => "",
                          "archivo" => "");
        
        if(trim($params["nombre"])== ""){
            $correcto = false;
            $error["nombre"] = "Debe ingresar un nombre";
        }
        
        
        $retorno_archivo = $this->visor_upload_temp_kml->upload(); 
        if(!$retorno_archivo["correcto"]){
            $correcto = false;
            $error["archivo"] = $retorno_archivo["mensaje"];  
        }  
        
        $retorno = array("correcto" => $correcto,
                         "nombre" => $params["nombre"],
                         "tipo" => $retorno_archivo["tipo"],
                         "hash" => $retorno_archivo["hash"],
                         "errores" => $error);
        
        echo json_encode($retorno);
    }
    
    /**
     * 
     */
    public function popup_lugar_emergencia(){
        $this->load->view("pages/mapa/popup-lugar-emergencia", array());
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
                           "propiedades" => unserialize($elemento->poligono_propiedades),
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
     * Carga elementos custom
     */
    public function ajax_kml_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => true,
                      "resultado" => array("elemento" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $lista_elementos = $this->_emergencia_kml_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_elementos)>0){
                foreach($lista_elementos as $elemento){

                    $data["correcto"] = true;
                    $data["resultado"]["elemento"][$elemento["id"]] = array("id" => $elemento["id"],
                                                                            "tipo" => $elemento["tipo"],
                                                                            "nombre" => $elemento["nombre"]);
                    
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene kml asociadados";
        }
        
        echo json_encode($data);
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
}
