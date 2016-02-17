<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Publico extends MY_Controller 
{
    /**
     *
     * @var Rapanui_Dengue_Model 
     */
    public $_rapanui_dengue_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->model("rapanui_dengue_model", "_rapanui_dengue_model");
    }
    
    /**
     * 
     */
    public function dengue(){
        $this->template->parse("default", "pages/publico/dengue", array());
    }
    
    /**
     * 
     */
    public function form_dengue(){
        
        $this->template->parse(
            "default", 
            "pages/publico/form-dengue", 
            array(
                "latitud" => "-27.11299",
                "longitud" => "-109.34958059999997"
                )
        );
    }
    
    public function editar(){
        $params = $this->input->get(null, true);
        
        $caso = $this->_rapanui_dengue_model->getById($params["id"]);
        if(!is_null($caso)){
            
            $data = array("id" => $caso->id);
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach($propiedades as $nombre => $valor){
                $data[str_replace(" ", "_" ,strtolower($nombre))] = $valor;
            }
            
            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            $this->template->parse("default", "pages/publico/form-dengue", $data);
        }
    }
    
    /**
     * 
     */
    public function guardar_dengue(){
        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        $coordenadas = array("lat" => $params["latitud"],
                             "lng" => $params["longitud"]);

        unset($params["latitud"]);
        unset($params["longitud"]);

        $arreglo = array();
         foreach($params as $nombre => $valor){
             if(TRIM($valor)!=""){
                 $nombre = str_replace("_", " ", $nombre);
                 $arreglo[strtoupper($nombre)] = $valor;
             }
         }
         
        $caso = $this->_rapanui_dengue_model->getById($params["id"]);
        if(is_null($caso)){
            $this->_rapanui_dengue_model->insert(array("fecha" => date("Y-m-d H:i:s"),
                                                   "propiedades" => json_encode($arreglo),
                                                   "coordenadas" => json_encode($coordenadas)));
        } else {
            $this->_rapanui_dengue_model->update(array("propiedades" => json_encode($arreglo),
                                                       "coordenadas" => json_encode($coordenadas)),
                                                 $caso->id);
        }

        
       
        echo json_encode(array("error" => array(),
                              "correcto" => true));
    }
    
    /**
     * 
     */
    public function eliminar(){
        $params = $this->input->post(null, true);
        $this->_rapanui_dengue_model->delete($params["id"]);
        echo json_encode(array("error" => array(),
                              "correcto" => true));
    }
    
    /**
     * 
     */
    public function ajax_lista(){
        $lista = $this->_rapanui_dengue_model->listar();
        
        $casos = array();
        
        if(!is_null($lista)){
            foreach($lista as $caso){
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if($fecha instanceof DateTime){
                    $fecha_formato = $fecha->format("d/m/Y");
                }
                
                $propiedades = json_decode($caso["propiedades"]);
                
                $casos[] = array("id" => $caso["id"],
                                 "fecha" => $fecha_formato,
                                 "nombre" => $propiedades->NOMBRE . " " . $propiedades->APELLIDO,
                                 "direccion" => $propiedades->DIRECCION);
            }
        }
        
        $this->load->view("pages/publico/grilla", array("lista" => $casos));
    }
}

