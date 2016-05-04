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
     * @var Capa_Detalle_Elemento_Model
     */
    public $_capa_detalle_elemento_model;
    
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
     * @var Comuna_Model
     */
    public $_comuna_model;
    
    /**
     *
     * @var Emergencia_Mapa_Configuracion_Model; 
     */
    public $_emergencia_mapa_configuracion_model;
    
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
        sessionValidation();
        $this->load->library("emergencia/emergencia_comuna");
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("emergencia_capa_model", "_emergencia_capas_model");
        $this->load->model("emergencia_elemento_model", "_emergencia_elementos_model");
        $this->load->model("emergencia_mapa_configuracion_model","_emergencia_mapa_configuracion_model");
        $this->load->model("emergencia_comuna_model","_emergencia_comuna_model");
        $this->load->model("alarma_model", "_alarma_model");
        $this->load->model("capa_model", "_capa_model");
        $this->load->model("comuna_model", "_comuna_model");
        $this->load->model("capa_detalle_elemento_model", "_capa_detalle_elemento_model");
        $this->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
        $this->load->model("archivo_model", "_archivo_model");
    }
    
    /**
     * Carga de mapa para emergencia
     * @throws Exception
     */
    public function index(){
        $this->load->helper("modulo/visor/visor");
        $params = $this->uri->uri_to_assoc();
        

        $emergencia = $this->_emergencia_model->getById($params["id"]);

        $this->load->model('Permiso_Model','PermisoModel');
        $this->load->model('Modulo_Model','ModuloModel');
        $guardar = $this->PermisoModel->tienePermisoVisorEmergenciaGuardar($this->session->userdata('session_roles'),7);

        if(!is_null($emergencia)){
            $data = array("id" => $params["id"],
                          "guardar" => $guardar,
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
                  "visor/guardar/visor_guardar_kml",
                  "visor/guardar/visor_guardar_configuracion" 
                 )
        );
        
        header('Content-type: application/json');
        
        //$params = $this->input->post(null, true);
        
        $emergencia = $this->_emergencia_model->getById($_POST["id"]);
        if(!is_null($emergencia)){
            
            $elementos = array();
            if(isset($_POST["elementos"])){
                $elementos = $_POST["elementos"];
            }
            
            $this->visor_guardar_elemento->setEmergencia($emergencia->eme_ia_id)
                                         ->guardar($elementos);
            
            
            $capas = array();
            if(isset($_POST["capas"])){
                $capas = $_POST["capas"];
            }
            
            $this->_emergencia_capas_model->query()
                                          ->insertOneToMany("id_emergencia", 
                                                            "id_geometria", 
                                                            $emergencia->eme_ia_id, 
                                                            $capas);
            
            $kml = array();
            if(isset($_POST["kmls"])){
                $kml = $_POST["kmls"];
            }
            
            
            $this->visor_guardar_kml->setEmergencia($emergencia->eme_ia_id)
                                    ->guardar($kml);
            
            $this->visor_guardar_configuracion
                 ->setEmergencia($emergencia->eme_ia_id)
                 ->setZoom($_POST["zoom"])
                 ->setLatitud($_POST["latitud"])
                 ->setLongitud($_POST["longitud"])
                 ->setSidcoConaf($_POST["sidco"])
                 ->setCasosFebriles($_POST["casos_febriles"])
                 ->setCasosFebrilesZona($_POST["casos_febriles_zona"])
                 ->setTipoMapa($_POST["tipo_mapa"])
                 ->setMareaRoja($_POST["marea_roja"])
                 ->guardar();
            
            
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
    public function info_rabia_vacunacion(){
        $this->load->helper("modulo/usuario/usuario");
        header('Content-type: application/json'); 
        $casos = array();
        $this->load->model("rabia_vacunacion_model", "_rabia_vacunacion_model");
        
        $lista = $this->_rabia_vacunacion_model->listar();
        if($lista != null){
            foreach($lista as $row){

                $propiedades = Zend_Json::decode($row["propiedades"]);
                $propiedades["INGRESADO POR"] = (string) nombreUsuario($row["id_usuario"]);
                $propiedades["TIPO"] = "VACUNACIÓN RABIA";

                
                $coordenadas = json_decode($row["coordenadas"]);
                $casos[] = array("id" => $row["id"],
                                 "propiedades" => $propiedades,
                                 "lat" => $coordenadas->lat,
                                 "lng" => $coordenadas->lng);
            }
        }
        
        echo json_encode(array(
            "correcto" => true,
            "lista" => $casos)
        );
    }
    
    /**
     * 
     */
    public function info_marea_roja(){
        $this->load->helper("modulo/usuario/usuario");
        header('Content-type: application/json'); 
        $casos = array();
        $this->load->model("marea_roja_model", "_marea_roja_model");
        
        $lista = $this->_marea_roja_model->listar();
        if($lista != null){
            foreach($lista as $row){
                $propiedades = array("MUESTREO N°" => $row["id"]);
                
                $json = Zend_Json::decode($row["propiedades"]);
                
                foreach($json as $key => $value){
                    $propiedades[$key] = $value;
                }
                
                $propiedades["INGRESADO POR"] = (string) nombreUsuario($row["id_usuario"]);
                $propiedades["TIPO"] = "MAREA ROJA";
 
                $coordenadas = Zend_Json::decode($row["coordenadas"]);
                
                $casos[] = array(
                    "id" => $row["id"],
                    "resultado" => $propiedades["RESULTADO"],
                    "fecha" => $propiedades["FECHA"],
                    "propiedades" => $propiedades,
                    "lat" => $coordenadas["lat"],
                    "lng" => $coordenadas["lng"]
                );
            }
        }
        
        echo Zend_Json::encode(
            array(
                "correcto" => true,
                "lista" => $casos
            )
        );
    }
    
    /**
     * 
     */
    public function info_rapanui_embarazadas(){
        $this->load->helper("modulo/usuario/usuario");
        header('Content-type: application/json'); 
        $casos = array();
        $this->load->model("embarazos_model", "_embarazos_model");
        
        $lista = $this->_embarazos_model->listarPorFecha(date("Y-m-d"));
        if($lista != null){
            foreach($lista as $row){

                $propiedades = Zend_Json::decode($row["propiedades"]);
                $propiedades["INGRESADO POR"] = (string) nombreUsuario($row["id_usuario"]);
                $propiedades["TIPO"] = "EMBARAZADA";
               
                $fecha_fur = DateTime::createFromFormat("Y-m-d", $row["FUR"]);
                if($fecha_fur instanceof DateTime){
                    $hoy = New DateTime("now");
                    $interval = $fecha_fur->diff($hoy);
                    $semana = (int) ( ( ((int) $interval->format('%R%a'))/7 ) - ((int) $interval->format('%R%a'))%7 );
                }
                
                if(!puedeVerFormularioDatosPersonales("casos_febriles")) {
                    unset($propiedades["RUN"]);
                    unset($propiedades["NOMBRE"]);
                    unset($propiedades["APELLIDO"]);
                    unset($propiedades["TELEFONO"]);
                    unset($propiedades["NUMERO PASAPORTE"]);
                }
                
                $coordenadas = json_decode($row["coordenadas"]);
                $casos[] = array("id" => $row["id"],
                                 "id_estado" => $row["id_estado"],
                                 "propiedades" => $propiedades,
                                 "lat" => $coordenadas->lat,
                                 "lng" => $coordenadas->lng,
                                 "semana" => $semana);
            }
        }
        
        echo json_encode(array(
            "correcto" => true,
            "lista" => $casos)
        );
    }
    
    /**
     * Trae datos de casos de fiebre
     */
    public function info_rapanui_dengue(){
        $this->load->helper("modulo/usuario/usuario");
        header('Content-type: application/json'); 
        $casos = array();
        
        $params = $this->input->post(null, true);
        
        /*$fecha_desde = null;
        $fecha_hasta = null;
        
        $fecha = DateTime::createFromFormat("d/m/Y", $params["desde"]);
        if($fecha instanceof DateTime){
            $fecha_desde = $fecha;
        }
        
        $fecha = DateTime::createFromFormat("d/m/Y", $params["hasta"]);
        if($fecha instanceof DateTime){
            $fecha_hasta = $fecha;
        }*/
        
        
        $this->load->model("casos_febriles_estado_model");
        $this->load->model("casos_febriles_enfermedades_model", "_casos_febriles_enfermedades_model");
        $this->load->model("casos_febriles_model", "_rapanui_dengue_model");
        
        $lista = $this->_rapanui_dengue_model->listar();
        if($lista != null){
            foreach($lista as $row){
                $ok = true;
                $propiedades = Zend_Json::decode($row["propiedades"]);
                
                /*$fecha_sintomas = DateTime::createFromFormat("d/m/Y", $propiedades["FECHA DE INICIO DE SINTOMAS"]);
                if($fecha_desde instanceof DateTime){
                   
                    if($fecha_sintomas instanceof DateTime){
                        if($fecha_desde > $fecha_sintomas){
                            $ok = false;
                        }
                    }
                }
                
                if($fecha_hasta instanceof DateTime){
                   
                    if($fecha_sintomas instanceof DateTime){
                        if($fecha_hasta < $fecha_sintomas){
                            $ok = false;
                        }
                    }
                }*/

                if($ok){
                    $propiedades["MÉDICO"] = (string) nombreUsuario($row["id_usuario"]);

                    if(!puedeVerFormularioDatosPersonales("casos_febriles")) {
                        unset($propiedades["RUN"]);
                        unset($propiedades["NOMBRE"]);
                        unset($propiedades["APELLIDO"]);
                        unset($propiedades["TELEFONO"]);
                        unset($propiedades["NUMERO PASAPORTE"]);
                    }

                    $enfermedades_confirmadas = array();
                    if($row["id_estado"] == Casos_Febriles_Estado_Model::CONFIRMADO){
                        $lista_enfermedades = $this->_casos_febriles_enfermedades_model->listarPorCaso($row["id"]);
                        if(!is_null($lista_enfermedades)){
                            foreach($lista_enfermedades as $enfermedad){
                                $enfermedades_confirmadas[] = array(
                                    "id" => $enfermedad["id_enfermedad"],
                                    "letra" => strtoupper(substr($enfermedad["nombre"], 0, 1)),
                                    "nombre" => strtoupper($enfermedad["nombre"])
                                );
                            }
                        }
                    }

                    $coordenadas = json_decode($row["coordenadas"]);
                    
                    $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $row["fecha"]);
                    
                    $casos[] = array(
                        "id" => $row["id"],
                        "fecha_ingreso" => $fecha->format("d/m/Y"),
                        "id_estado" => $row["id_estado"],
                        "propiedades" => $propiedades,
                        "enfermedades" => $enfermedades_confirmadas,
                        "lat" => $coordenadas->lat,
                        "lng" => $coordenadas->lng
                    );
                }
            }
        }
        
        echo json_encode(array(
            "correcto" => true,
            "lista" => $casos)
        );
    }
    
    public function popup_marcador_editar(){
        $this->load->library("String");
        $params = $this->input->post(null, true);        
        $this->load->view("pages/mapa/popup-marcador-editar", array("html" => $params["html"]));
    }
    
    /**
     * 
     */
    public function ajax_contar_elementos(){
        header('Content-type: application/json');        
        $params = $this->input->post(null, true);
        
        $cantidad = $this->_emergencia_elementos_model->contarPorEmergencia($params["id"]);
        
        echo json_encode(array("cantidad" => $cantidad));
    }

    /**
     * 
     */
    public function popup_lugar_emergencia(){
        $this->load->view("pages/mapa/popup-lugar-emergencia", array());
    }
    
    /**
     * 
     */
    public function popup_elemento_info(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = json_decode($params["informacion"]);
        
        $this->load->view(
            "pages/mapa/popup-elemento-informacion", 
            array(
                "tipo" => $params["tipo"],
                "color" => $params["color"],
                "radio" => $params["radio"],
                "informacion" => $informacion,
                "identificador" => $params["identificador"],
                "clave" => $params["clave"],
                "lista_formas" => json_decode($params["formas"]),
                "lista_marcadores"  => json_decode($params["marcadores"])
            )
        );
    }
    
    /**
     * Muestra información del poligono
     */
    public function popup_elemento_edicion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = json_decode($params["informacion"]);
        
        $this->load->view(
            "pages/mapa/popup-elemento-edicion", 
            array(
                "tipo" => $params["tipo"],
                "color" => $params["color"],
                "informacion" => $informacion,
                "identificador" => $params["identificador"],
                "clave" => $params["clave"],
                "lista_formas" => json_decode($params["formas"]),
                "lista_marcadores"  => json_decode($params["marcadores"])
            )
        );
        
    }
    
    /**
     * Muestra información del poligono
     */
    public function popup_lugar_emergencia_edicion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = json_decode($params["informacion"]);
        
        $this->load->view(
            "pages/mapa/popup-lugar-emergencia-edicion", 
            array(
                "tipo" => $params["tipo"],
                "color" => $params["color"],
                "metros" => $params["radio"],
                "informacion" => $informacion,
                "identificador" => $params["identificador"],
                "clave" => $params["clave"],
                "lista_formas" => json_decode($params["formas"]),
                "lista_marcadores"  => json_decode($params["marcadores"])
                )
        );
        
    }
    
    /**
     * Valida el lugar de la emergencia
     */
    public function ajax_valida_lugar_emergencia(){
        header('Content-type: application/json');
        
        $retorno = array("correcto" => false);
        
        $params = $this->input->post(null, true);

            
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
        $elemento = $this->_capa_detalle_elemento_model->getById($params["id"]);
        if(!is_null($elemento)){
            $subcapa = $this->_capa_detalle_model->getById($elemento->poligono_capitem);
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
     * Carga configuracion de mapa
     */
    public function ajax_mapa_configuracion(){
        header('Content-type: application/json');
        $resultado = array("correcto" => true,
                           "resultado" => array("sidco" => 0,
                                                "tipo_mapa" => ""));
        $params = $this->input->post(null, true);

        $configuracion = $this->_emergencia_mapa_configuracion_model->getByEmergencia($params["id"]);
        if(!is_null($configuracion)){
            $resultado["resultado"] = array(
                "sidco" => $configuracion->kml_sidco,
                "casos_febriles" => $configuracion->bo_casos_febriles,
                "casos_febriles_zona" => $configuracion->bo_casos_febriles_zona,
                "marea_roja" => $configuracion->bo_marea_roja,
                "tipo_mapa" => $configuracion->tipo_mapa
            );
        }
        
        echo json_encode($resultado);
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
    public function ajax_posicion_lugar_emergencia(){

        header('Content-type: application/json');
        $data = array("correcto" => false);
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $configuracion = $this->_emergencia_mapa_configuracion_model->getByEmergencia($emergencia->eme_ia_id);
            if(!is_null($configuracion) && ($configuracion->latitud!="" && $configuracion->longitud!="")){
                $latitud = $configuracion->latitud;
                $longitud = $configuracion->longitud;
                $zoom = $configuracion->zoom;
            } else {
                $lugar_emergencia = $this->_emergencia_elementos_model->getPrimerLugarEmergencia($emergencia->eme_ia_id);
                if(!is_null($lugar_emergencia)){
                    $coordenadas = Zend_Json::decode($lugar_emergencia->coordenadas);
                    $latitud = $coordenadas["center"]["lat"];
                    $longitud = $coordenadas["center"]["lng"];
                } else {
                    $latitud = $emergencia->eme_c_utm_lat;
                    $longitud = $emergencia->eme_c_utm_lng;
                }
                $zoom = 17;
            }

            $data = array(
                "correcto"  => true,
                "resultado" => array(
                    "lat" => $latitud,
                    "lon" => $longitud,
                    "nombre" => $emergencia->eme_c_nombre_emergencia,
                    "zoom" => $zoom)
            );
            
        } else {
            $data["error"] = "La emergencia no existe";
        }
        
        echo json_encode($data);
    }
}
