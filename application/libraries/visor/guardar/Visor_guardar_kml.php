<?php

Class Visor_guardar_kml{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_kml_Model 
     */
    protected $_emergencia_kml_model;
    
    /**
     *
     * @var Emergencia_Kml_Elemento_Model 
     */
    protected $_emergencia_kml_elemento_model;
    
    /**
     *
     * @var array 
     */
    protected $_lista_iconos = array();
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
        /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library(array("cache", "core/string/random"));
        $this->_ci->load->model("emergencia_kml_model");
        $this->_ci->load->model("emergencia_kml_elemento_model");
        $this->_emergencia_kml_model = $this->_ci->emergencia_kml_model;
        $this->_emergencia_kml_elemento_model = $this->_ci->emergencia_kml_elemento_model;
    }
    
    /**
     * Setea emergencia
     * @param int $id
     * @return \Visor_guardar_elemento
     */
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    /**
     * 
     * @param array $lista_kml
     */
    public function guardar($lista_kml){
        $guardados = array();
        if(count($lista_kml)>0){
            foreach($lista_kml as $kml_seleccionado){
                $kml = $this->_emergencia_kml_model->getById($kml_seleccionado["id"]);
                if(is_null($kml)){
                    
                    $cache = Cache::iniciar();
                    $file = $cache->load($kml_seleccionado["hash"]);
                    
                    $data = array(
                        "id_emergencia" => $this->_id_emergencia,
                        "tipo" => $kml_seleccionado["tipo"],
                        "archivo" => $kml_seleccionado["archivo"],
                        "nombre" => $kml_seleccionado["nombre"],
                        "kml"    =>$file["archivo"]
                    );
                    
                    $id = $this->_emergencia_kml_model->query()->insert($data);             
                    $guardados[] = $id;
                } else {
                    $id = $kml->id;
                    $guardados[] = $kml->id;
                }
                
                $elementos_guardados = array();
                if(count($kml_seleccionado["elementos"])>0){
                    foreach($kml_seleccionado["elementos"] as $elemento_json){
                        $elemento = Zend_Json::decode($elemento_json);
                        
                        switch ($elemento["tipo"]) {
                            case "PUNTO":
                                $coordenadas = array("lat" => $elemento["coordenadas"]["lat"], "lon" => $elemento["coordenadas"]["lng"]);
                                break;
                            case "POLIGONO":
                                $coordenadas = array("poligono" => array());
                                foreach($elemento["coordenadas"] as $elemento_coordenada){
                                    $coordenadas["poligono"][] = array($elemento_coordenada["lng"], $elemento_coordenada["lat"]);
                                }
                                break;
                            case "LINEA":
                                $coordenadas = array("linea" => array());
                                foreach($elemento["coordenadas"] as $elemento_coordenada){
                                    $coordenadas["linea"][] = array($elemento_coordenada["lat"], $elemento_coordenada["lng"]);
                                }
                                break;
                            default:
                                break;
                        }
                        
                        
                        $data_elemento = array(
                            "id_kml" => $id,
                            "nombre" => $elemento["nombre"],
                            "tipo" => $elemento["tipo"],
                            "propiedades" => Zend_Json::encode($elemento["propiedades"]),
                            "coordenadas" => Zend_Json::encode($coordenadas)
                        );

                        if($elemento["tipo"] == "PUNTO"){
                            $data_elemento["icono"] = $this->_saveIcon($id, $elemento["primaria"], $elemento["icono"]);
                        }

                        if($elemento["tipo"] == "MULTIPOLIGONO" || $elemento["tipo"] == "POLIGONO" || $elemento["tipo"] == "LINEA"){
                            $data_elemento["color"] = $elemento["color"];
                        }
                        
                        $existe = $this->_emergencia_kml_elemento_model->getById($elemento["primaria"]);

                        if(!is_null($existe)){
                            $this->_emergencia_kml_elemento_model->update($data_elemento, $existe->id);
                            $elementos_guardados[] = $existe->id;
                        } else {
                            $elementos_guardados[] = $this->_emergencia_kml_elemento_model->insert(
                                $data_elemento
                            );
                        }
                    }
                }
                
                $this->_emergencia_kml_elemento_model->deleteNotIn($id, $elementos_guardados);
            }    
        }
        
        $this->_emergencia_kml_model->deleteNotIn($this->_id_emergencia, $guardados);
        $this->_limpiarIconosEliminados();
        
    }
    
    /**
     * 
     */
    protected function _limpiarIconosEliminados(){
        if(count($this->_lista_iconos) > 0){
            foreach($this->_lista_iconos as $icono){
                if(is_file($icono)){
                    unlink($icono);
                }
            }
        }
    }
    
    /**
     * Guarda el icono
     * @param int $id_kml
     * @param string $icono_path
     * @return string
     */
    protected function _saveIcon($id_kml, $id_elemento, $icono_path){
        
        if(!is_dir(FCPATH . "media/doc/kml")){
            mkdir(FCPATH . "media/doc/kml");
        }

        if(!is_dir(FCPATH . "media/doc/kml/" . $id_kml)){
            mkdir(FCPATH . "media/doc/kml/" . $id_kml);
        }

        $relative_path = str_replace(base_url(), "", $icono_path);
        
        $icono_anterior = "";
        if($id_elemento != ""){
            $elemento = $this->_emergencia_kml_elemento_model->getById($id_elemento);
            if(!is_null($elemento)){
                $icono_anterior = $elemento->icono;
            }
        }
        
       
        
        if($icono_anterior != $relative_path && is_file($relative_path)){
            $info = pathinfo(FCPATH . $relative_path);
            $icono = file_get_contents(FCPATH . $relative_path);
            
            $relative_path_final = "media/doc/kml/" . $id_kml . "/" . $this->_ci->random->rand_string(20) . "." . $info["extension"];
            
            $file = FCPATH . $relative_path_final;
            file_put_contents($file, $icono);
            
            $this->_lista_iconos[] = FCPATH . $relative_path;
            //unlink(FCPATH . $relative_path);

            return $relative_path_final;
        } else {
            return $icono_anterior;
        }

    }
}

