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
        $this->template->parse("default", "pages/publico/form-dengue", array());
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
                 $arreglo[strtoupper($nombre)] = strtoupper($valor);
             }
         }

        $this->_rapanui_dengue_model->insert(array("fecha" => date("Y-m-d H:i:s"),
                                                   "propiedades" => json_encode($arreglo),
                                                   "coordenadas" => json_encode($coordenadas)));
       
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

