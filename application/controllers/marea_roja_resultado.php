<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once(__DIR__ . "/marea_roja.php");

class Marea_roja_resultado extends Marea_roja
{
    /**
     *
     * @var Marea_Roja_Model 
     */
    public $_marea_roja_model;
    
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        sessionValidation();
        $this->load->model("marea_roja_model", "_marea_roja_model");
        $this->load->model("region_model", "_region_model");
        $this->load->model("modulo_model", "_modulo_model");
        
        $this->load->helper(
            array(
                "modulo/usuario/usuario_form",
                "modulo/comuna/form"
            )
        );
    }
    
    /**
     *
     */
    public function index()
    {
        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/resultado/index.js");
        $this->layout_template->view(
            "default", 
            "pages/marea_roja/resultado/index", 
            array()
        );
    }
    
    /**
     *
     */
    public function editar()
    {
        $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario",
                "modulo/direccion/region",
                "modulo/direccion/comuna",
                "modulo/usuario/usuario_form",
                "modulo/comuna/default"
            )
        );
        $params = $this->input->post(null, true);

        $caso = $this->_marea_roja_model->getById($params["id"]);
        if (!is_null($caso)) {

            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
           
            $data = array("id" => $caso->id);
            
            foreach ($propiedades as $nombre => $valor) {
                $data["propiedades"][str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            $this->load->view("pages/marea_roja/resultado/form", $data);
            //$this->template->parse("default", "pages/marea_roja/resultado/form", $data);
        }
    }
    
    /**
     * Guarda el resultado
     */
    public function guardar(){
        
        $this->load->library(
            array(
                "rut", 
                "marea_roja/marea_roja_resultado_validar"
            )
        );
        
        $params = $this->input->post(null, true);
        if ($this->marea_roja_resultado_validar->esValido($params)) {
            $caso = $this->_marea_roja_model->getById($params["id"]);
            if (!is_null($caso)) {
                $propiedades = Zend_Json::decode($caso->propiedades);
                $propiedades["RESULTADO"] = $params["resultado"];
                $propiedades["RESULTADO FECHA"] = $params["resultado_fecha"];
                
                $this->_marea_roja_model->update(
                    array("propiedades" => Zend_Json::encode($propiedades),
                          "id_usuario_resultado" => $this->session->userdata('session_idUsuario'),
                          "bo_ingreso_resultado" => 1), 
                    $caso->id
                );
                
                echo json_encode(
                    array(
                        "error" => $this->marea_roja_resultado_validar->getErrores(),
                        "correcto" => true
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "error" => $this->marea_roja_resultado_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }
}

