<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Hospital extends MY_Controller
{
    
    /**
     *
     * @var Hospital_Model 
     */
    public $_hospital_model;
    
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        sessionValidation();
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->model("hospital_model", "_hospital_model");
    }
    
    /**
     *
     */
    public function index()
    {
        $this->template->parse("default", "pages/hospital/index", array());
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

        $caso = $this->_hospital_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id);
            
            
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            

            $this->template->parse("default", "pages/hospital/form", $data);
        }
    }
    
    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_embarazos_model->delete($params["id"]);
        echo json_encode(array("error" => array(),
            "correcto" => true));
    }
    
    
    
    /**
     *
     */
    public function guardar()
    {
        $this->load->library(array("rut", "formulario/formulario_hospital_validar"));

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->formulario_hospital_validar->esValido($params)) {
            
            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["latitud"],
                "lng" => $params["longitud"]
            );
            
            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            /** caso febril **/
            $caso = $this->_hospital_model->getById($params["id"]);
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
                $id = $this->_hospital_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("session_idUsuario"),
                        "id_estado" => $params["estado"]
                    )
                );
            } else {
                $this->_hospital_model->update(
                    array(
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_estado" => $params["estado"]
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
                    "error" => $this->formulario_hospital_validar->getErrores(),
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
            "pages/hospital/form",
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
        $lista = $this->_hospital_model->listar();

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                $propiedades = json_decode($caso["propiedades"]);

                $casos[] = array("id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "nombre" => strtoupper($propiedades->NOMBRE),
                    "direccion" => strtoupper($propiedades->DIRECCION));
            }
        }

        $this->load->view("pages/hospital/grilla", array("lista" => $casos));
    }
}