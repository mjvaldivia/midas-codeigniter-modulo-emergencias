<?php

class Mapa_kml extends MY_Controller {
        
    /**
     *
     * @var Emergencia_Kml_Model 
     */
    public $_emergencia_kml_model;
    
    /**
     *
     * @var Emergencia_Kml_Elemento_Model 
     */
    public $_emergencia_kml_elemento_model;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Mapa_Configuracion_Model 
     */
    public $_emergencia_mapa_configuracion_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_kml_model", "_emergencia_kml_model");
        $this->load->model("emergencia_kml_elemento_model", "_emergencia_kml_elemento_model");
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("emergencia_mapa_configuracion_model","_emergencia_mapa_configuracion_model");
    }
    
    /**
     * Popup que permite subir un archivo
     * y cargarlo en el mapa
     */
    public function popup_importar_kml(){
        $this->load->view("pages/mapa_kml/popup-importar-kml", array());
    }
    
    /**
     * 
     */
    public function popup_informacion_archivo(){
        $params = $this->input->post(null, true);
        $archivo = $this->_emergencia_kml_model->getById($params["id"]);
        if(!is_null($archivo)){
            
            $puntos = $this->_emergencia_kml_elemento_model->listaPorTipo($params["id"], array("PUNTO"));
            $zonas  = $this->_emergencia_kml_elemento_model->listaPorTipo(
                $params["id"], 
                array(
                    "POLIGONO",
                    "MULTIPOLIGONO"
                )
            );
            
            
            $data = array("id" => $archivo->id,
                          "archivo" => $archivo->archivo,
                          "nombre" => $archivo->nombre,
                          "tipo" => $archivo->tipo,
                          "puntos" => $puntos,
                          "zonas"  => $zonas);
            $this->load->view("pages/mapa_kml/popup-informacion", $data);
        }
    }
    
    /**
     * Retorna cantidad de archivos subidos por una emergencia
     */
    public function ajax_contar_kml_emergencia(){
        header('Content-type: application/json');        
        $params = $this->input->post(null, true);
        
        $cantidad = $this->_emergencia_kml_model->contarPorEmergencia($params["id"]);
        
        echo json_encode(array("cantidad" => $cantidad));
    }
    
    /**
     * Carga archivos asociados a una emergencia al mapa
     */
    public function ajax_kml_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => true,
                      "resultado" => array("elemento" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            
            $configuracion = array();
            $mapa = $this->_emergencia_mapa_configuracion_model->getByEmergencia($params["id"]);
            if(!is_null($mapa)){
                $configuracion = Zend_Json::decode($mapa->configuracion);    
            }
            
            
            $lista_elementos = $this->_emergencia_kml_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_elementos)>0){
                foreach($lista_elementos as $elemento){
                    $oculto = false;
                    if(isset($configuracion["archivos_ocultos"]) && in_array($elemento["id"], $configuracion["archivos_ocultos"])){
                        $oculto = true;
                    }
                    
                    $data["correcto"] = true;
                    $data["resultado"]["elemento"][$elemento["id"]] = array(
                        "id" => $elemento["id"],
                        "hash" => "archivo_importado_" . $elemento["id"],
                        "oculto" => $oculto,
                        "tipo" => strtoupper($elemento["tipo"]),
                        "nombre" => strtoupper($elemento["nombre"]),
                        "archivo" => $elemento["archivo"],
                        "elementos" => $this->_emergencia_kml_elemento_model->listaPorKml($elemento["id"])
                    );
                    
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene kml asociadados";
        }
        
        echo json_encode($data);
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
                    $content_type = "application/vnd.google-earth.kml+xml";  
                    break;
                case "kmz":
                    $content_type = "application/vnd.google-earth.kmz"; 
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
        
        $this->load->library(
            array(
                "visor/upload/visor_upload_temp_kml",
                "kml/kml_descomponer"
            )
        );
        
        $params = $this->input->post(null, true);
        
        $correcto = true;
        $error    = array("nombre" => "",
                          "archivo" => "");
        
        if(trim($params["nombre"])== ""){
            $correcto = false;
            $error["nombre"] = "Debe ingresar un nombre";
        }
        
        $elementos = array();
        $retorno_archivo = $this->visor_upload_temp_kml->upload(); 
        if(!$retorno_archivo["correcto"]){
            $correcto = false;
            $error["archivo"] = $retorno_archivo["mensaje"];  
        } else {
            $this->kml_descomponer->setFileHash($retorno_archivo["hash"]);
            $elementos = $this->kml_descomponer->process();
        }
        
        $retorno = array("correcto" => $correcto,
                         "nombre" => strtoupper($params["nombre"]),
                         "archivo" => $retorno_archivo["archivo_nombre"],
                         "tipo" => $retorno_archivo["tipo"],
                         "hash" => $retorno_archivo["hash"],
                         "elementos" => $elementos,
                         "errores" => $error);
        
        echo json_encode($retorno);
    }
    
    /**
     * Genera archivo KMZ con elementos del visor
     */
    public function ajax_generar_kmz(){
        header('Content-type: application/json');
        $correcto = true;
        
        $params = $this->input->post(null, true);
        $this->load->library(
            array(
                "cache",
                "string",
                "zip"
                )
        );
        
        $file_paths = array();
        $cache = Cache::iniciar();
        
        $hash = $params["kml"];
        
        $file_path = FCPATH . "media/tmp/" . $hash . ".kml";
        $file_paths[] = $file_path;
        $file = $cache->load($hash);
        file_put_contents($file_path, $file);
        $this->zip->add($hash . ".kml", $file_path);
        unlink($file_path);
        
        if(count($params["images"])>0){
        foreach($params["images"] as $codigo){
            if($imagen = $cache->load($codigo)){
                $file_path = FCPATH . "media/tmp/" . $imagen["name"];
                file_put_contents($file_path, $imagen["file"]);
                $this->zip->add("icons/" . $imagen["name"], $file_path);
                unlink($file_path);
            }
        }
        }

        $kmz = file_get_contents($this->zip->create());
        $this->zip->clear();
        
        $kmz_hash = $this->string->rand_string(25);
        $cache->save(array("tipo" => "kmz",
                           "archivo_nombre" => $kmz_hash . ".kmz",
                           "archivo" => $kmz), 
                    $kmz_hash);
        
        echo Zend_Json::encode(
            array(
                "hash" => $kmz_hash,
                "correcto" => $correcto
            )
        );
    }
    
    /**
     * Crea archivo kml temporal
     */
    public function ajax_exportar_kml_elemento(){
        ini_set('error_reporting', E_ALL ^ E_WARNING);
        $correcto = true;
        
        header('Content-type: application/json');
        
        $params = $this->input->post(null, true);
        
        $this->load->library(
            array(
                "kml/kml_create", 
                "cache",
                "string"
                )
        );
        
        $clave = $this->string->rand_string(20);
        
        try{
            $cache = Cache::iniciar();
            
            
            $lista_elementos = Zend_Json::decode($params["elemento"]);
            
            foreach($lista_elementos as $elemento){
                $this->kml_create->addPoligon("PRUEBA", $elemento["coordenadas"], $elemento["color"], $elemento["informacion"]);
            }
            
    
            $lista_marcadores = Zend_Json::decode($params["marcadores"]);
            foreach($lista_marcadores as $marcador){
                $this->kml_create->addMarker($marcador["posicion"], $marcador["icono"], $marcador["informacion"]);
            }
            
            $cache->save(
                    $this->kml_create->getKml(), 
                    $clave
            );
        } catch (Exception $e){
            $correcto = false;
        }
        
        echo Zend_Json::encode(
            array(
                "file" => $clave,
                "images" => $this->kml_create->getStyleIcons(),
                "correcto" => $correcto
            )
        );
    }
}

