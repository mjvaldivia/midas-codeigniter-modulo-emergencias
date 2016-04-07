<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Rabia_vacunacion extends MY_Controller
{
    
    /**
     *
     * @var Rabia_Vacunacion_Model 
     */
    public $_rabia_vacunacion_model;
    
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        sessionValidation();
        $this->load->model("rabia_vacunacion_model", "_rabia_vacunacion_model");
    }
    
    /**
     *
     */
    public function index()
    {
        $this->template->parse("default", "pages/rabia_vacunacion/index", array("vacuna_fecha" => date("d/m/Y")));
    }
    
    /**
     *
     */
    public function editar()
    {
       $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario"
            )
        );
        $params = $this->input->get(null, true);

        $caso = $this->_rabia_vacunacion_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id);
            
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            

            $this->template->parse("default", "pages/rabia_vacunacion/form", $data);
        }
    }
    
    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_rabia_vacunacion_model->delete($params["id"]);
        echo json_encode(array("error" => array(),
            "correcto" => true));
    }
    
    /**
     *
     */
    public function guardar()
    {
        $this->load->library(
            array(
                "rut", 
                "rabia/rabia_vacunacion_validar"
            )
        );

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->rabia_vacunacion_validar->esValido($params)) {
            
            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["latitud"],
                "lng" => $params["longitud"]
            );
            
            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

           
            $caso = $this->_rabia_vacunacion_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/

            /** se preparan datos del formulario **/
            $arreglo = array();
            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }
            /**************************************/


            if (is_null($caso)) {
                $id = $this->_rabia_vacunacion_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("session_idUsuario")
                    )
                );
            } else {
                $this->_rabia_vacunacion_model->update(
                    array(
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas)
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
                    "error" => $this->rabia_vacunacion_validar->getErrores(),
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
                "modulo/formulario/formulario"
            )
        );
        $params = $this->uri->uri_to_assoc();

        $this->template->parse(
            "default",
            "pages/rabia_vacunacion/form",
            array(
                "ingresado" => $params["ingreso"],
                "latitud" => "",
                "longitud" => ""
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
        $lista = $this->_rabia_vacunacion_model->listar();

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                
                $fecha_formato = "";
                $fecha = DateTime::createFromFormat("Y-m-d", $caso["fecha"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }
                
                $propiedades = json_decode($caso["propiedades"]);

                $casos[] = array("id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "fecha" => $fecha_formato,
                    "nombre_animal" => $propiedades->{"NOMBRE ANIMAL"},
                    "especie" => $propiedades->{"ESPECIE ANIMAL"},
                    "run" => $propiedades->RUN,
                    "nombre" => strtoupper($propiedades->NOMBRE . " " . $propiedades->APELLIDO),
                    "direccion" => strtoupper($propiedades->DIRECCION)
                );
            }
        }

        $this->load->view("pages/rabia_vacunacion/grilla", array("lista" => $casos));
    }
}

