<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Marea_roja extends MY_Controller
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
    }
    
    /**
     *
     */
    public function index()
    {
        $this->template->parse(
            "default", 
            "pages/marea_roja/index", 
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
                "modulo/direccion/comuna"
            )
        );
        $params = $this->input->get(null, true);

        $caso = $this->_marea_roja_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id);

            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
           
            $this->template->parse("default", "pages/marea_roja/form", $data);
        }
    }
    
    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_marea_roja_model->delete($params["id"]);
        echo json_encode(
            array(
                "error" => array(),
                "correcto" => true
            )
        );
    }
    
    
    
      /**
     *
     */
    public function guardar()
    {
        $this->load->library(
            array(
                "rut", 
                "marea_roja/marea_roja_validar"
            )
        );

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->marea_roja_validar->esValido($params)) {
            
            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["latitud"],
                "lng" => $params["longitud"]
            );
            
            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            $caso = $this->_marea_roja_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/

            /** se preparan datos del formulario **/
            $arreglo = array();
            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }
            
            if (is_null($caso)) {
                $id = $this->_marea_roja_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "id_region" => $params["region"],
                        "id_comuna" => $params["comuna"],
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("session_idUsuario"),
                    )
                );
            } else {
                $this->_marea_roja_model->update(
                    array(
                        "id_region" => $params["region"],
                        "id_comuna" => $params["comuna"],
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                    ),
                    $caso->id
                );
                $id = $caso->id;
            }

            echo json_encode(
                array(
                    "error" => array(),
                    "correcto" => true
                )
            );
            
        } else {
            echo json_encode(
                array(
                    "error" => $this->marea_roja_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }
    
    /**
     * 
     */
    public function nuevo(){
        $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario",
                "modulo/direccion/region",
                "modulo/direccion/comuna"
            )
        );
        
        $params = $this->uri->uri_to_assoc();

        $this->template->parse(
            "default",
            "pages/marea_roja/form",
            array(
                "fecha" => DATE("d/m/Y"),
                "ingresado" => $params["ingreso"],
                "region" => Region_Model::LOS_LAGOS,
                "latitud" => "-42.92",
                "longitud" => "-73.17"
            )
        );
    }
    
    /**
     *
     */
    public function ajax_lista()
    {
        $this->load->helper(array(
                "modulo/emergencia/emergencia",
                "modulo/usuario/usuario",
            )
        );
        $lista = $this->_marea_roja_model->listar();

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }

                $propiedades = json_decode($caso["propiedades"]);

                $casos[] = array(
                    "id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "fecha" => $fecha_formato,
                    "recurso" => strtoupper($propiedades->RECURSO),
                    "origen" => strtoupper($propiedades->ORIGEN),
                    "comuna" => $caso->id_comuna,
                    "resultado" => $propiedades->RESULTADO
                );

            }
        }

        $this->load->view("pages/marea_roja/grilla", array("lista" => $casos));
    }
}

