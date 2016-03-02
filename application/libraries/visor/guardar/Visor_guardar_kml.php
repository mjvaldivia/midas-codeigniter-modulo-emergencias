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
        $this->_ci->load->library(array("cache"));
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
       
                    if(count($file["elementos"])>0){
                        foreach($file["elementos"] as $elemento){
                            
                            $data_elemento = array(
                                "id_kml" => $id,
                                "nombre" => $elemento["nombre"],
                                "tipo" => $elemento["tipo"],
                                "propiedades" => $elemento["descripcion"],
                                "coordenadas" => Zend_Json::encode($elemento["coordenadas"])
                            );
                            
                            if($elemento["tipo"] == "PUNTO"){
                                $data_elemento["icono"] = $this->_saveIcon($id, $elemento["icono"]);
                            }
                            
                            $this->_emergencia_kml_elemento_model->insert(
                                $data_elemento
                            );
                        }
                    }
                    
                    
                    $guardados[] = $id;
                } else {
                    $guardados[] = $kml->id;
                }
            }    
        }
        $this->_emergencia_kml_model->deleteNotIn($this->_id_emergencia, $guardados);
    }
    
    /**
     * Guarda el icono
     * @param int $id_kml
     * @param string $icono_path
     * @return string
     */
    protected function _saveIcon($id_kml, $icono_path){
        
        $existe = array_search($icono_path, $this->_lista_iconos);
        if($existe === false){
            if(!is_dir(FCPATH . "media/doc/kml")){
                mkdir(FCPATH . "media/doc/kml");
            }

            if(!is_dir(FCPATH . "media/doc/kml/" . $id_kml)){
                mkdir(FCPATH . "media/doc/kml/" . $id_kml);
            }

            $info = pathinfo(FCPATH . $icono_path);

            $icono = file_get_contents(FCPATH . $icono_path);
            
            $file = FCPATH . "media/doc/kml/" . $id_kml . "/" . $info["filename"] . "." . $info["extension"];
            file_put_contents($file, $icono);
            
            $this->_lista_iconos["media/doc/kml/" . $id_kml . "/" . $info["filename"] . "." . $info["extension"]] = $icono_path;
            
            unlink(FCPATH . $icono_path);
            
            return "media/doc/kml/" . $id_kml . "/" . $info["filename"] . "." . $info["extension"];
        }
        
        return $existe;
    }
}

