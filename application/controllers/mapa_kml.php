<?php

class Mapa_kml extends MY_Controller {
        
    /**
     *
     * @var Emergencia_Kml_Model 
     */
    public $_emergencia_kml_model;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_kml_model", "_emergencia_kml_model");
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    /**
     * 
     */
    public function popup_importar_kml(){
        $this->load->view("pages/mapa_kml/popup-importar-kml", array());
    }
    
    /**
     * Retorna cantidad de capas por emergencia
     */
    public function ajax_contar_kml_emergencia(){
        header('Content-type: application/json');        
        $params = $this->input->post(null, true);
        
        $cantidad = $this->_emergencia_kml_model->contarPorEmergencia($params["id"]);
        
        echo json_encode(array("cantidad" => $cantidad));
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
                    $data["resultado"]["elemento"][$elemento["id"]] = array(
                        "id" => $elemento["id"],
                        "tipo" => $elemento["tipo"],
                        "nombre" => $elemento["nombre"]
                    );
                    
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene kml asociadados";
        }
        
        echo json_encode($data);
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
        
        
        foreach($params["images"] as $codigo){
            if($imagen = $cache->load($codigo)){
                $file_path = FCPATH . "media/tmp/" . $imagen["name"];
                file_put_contents($file_path, $imagen["file"]);
                $this->zip->add("icons/" . $imagen["name"], $file_path);
                unlink($file_path);
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

