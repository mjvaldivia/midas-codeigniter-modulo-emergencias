<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Vigilancia_Embarazos extends MY_Controller
{
    /**
     * Filtro por la region
     * @var int 
     */
    protected $_id_region = null;
    
    /**
     * Filtro por la comuna
     * @var int 
     */
    protected $_id_comuna = null;
    
    /**
     *
     * @var Embarazos_Model 
     */
    public $_embarazos_model;
    
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("region_model");
        $this->load->model("comuna_model");
        $this->load->model("embarazos_model", "_embarazos_model");
        
        $this->load->library(
            array(
                "core/string/random",
                "module/casos_febriles/permiso"
            )
        );
        
        
        
        $this->login_authentificate->validar();
    }
    
    /**
     *
     */
    public function index()
    {
        $this->layout_assets->addJs("embarazos/index.js");
        $this->layout_template->view("default", "pages/embarazos/index", array());
    }
    
    /**
     * 
     */
    public function nuevo(){
        
        $this->load->helper(
            array(
                "core/default_form",
                "module/casos_febriles/form",
                "module/casos_febriles/permiso"
            )
        );

        
        $this->layout_assets->addMapaFormulario();
        $this->layout_assets->addJs("embarazos/form.js");
        
        $this->layout_template->view(
            "default", 
            "pages/embarazos/form", 
                array(
                "id" => "",
                "latitud" => "",
                "longitud" => ""
            )
        );

    }
    
    /**
     *
     */
    public function editar()
    {
       $this->load->helper(
            array(
                "core/default_form",
                "module/casos_febriles/form",
                "module/casos_febriles/permiso"
            )
        );
       
        $params = $this->input->get(null, true);

        $caso = $this->_embarazos_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id);
            
            
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            $fecha = DateTime::createFromFormat("Y-m-d", $caso->FUR);
            if($fecha instanceof DateTime){
                $data["fecha_fur"] = $fecha->format("d/m/Y");
            }
            
            $fecha = DateTime::createFromFormat("Y-m-d", $caso->FPP);
            if($fecha instanceof DateTime){
                $data["fecha_fpp"] = $fecha->format("d/m/Y");
            }

            $this->layout_assets->addMapaFormulario();
            $this->layout_assets->addJs("embarazos/form.js");

            $this->layout_template->view(
                "default", 
                "pages/embarazos/form", 
                $data
            );
        }
    }
    
    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_embarazos_model->delete($params["id"]);
        echo json_encode(
            array(
                "error" => array(),
                "correcto" => true)
        );
    }
    
    /**
     *
     */
    public function guardar()
    {
        $this->load->library(
            array("module/embarazos/validar")
        );
        
        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->validar->esValido($params)) {
            
            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["latitud"],
                "lng" => $params["longitud"]
            );
            
            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            /** caso febril **/
            $caso = $this->_embarazos_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/

            /** se preparan datos del formulario **/
            $arreglo = array();
            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }
            /**************************************/
            $fecha_fur = NULL;
            $fecha = DateTime::createFromFormat("d/m/Y", $params["fecha_fur"]);
            if($fecha instanceof DateTime){
                $fecha_fur = $fecha->format("Y-m-d");
            }
            unset($params["fecha_fur"]);
            
            $fecha_fpp = NULL;
            $fecha = DateTime::createFromFormat("d/m/Y", $params["fecha_fpp"]);
            if($fecha instanceof DateTime){
                $fecha_fpp = $fecha->format("Y-m-d");
            }
            unset($params["fecha_fpp"]);

            if (is_null($caso)) {
                $id = $this->_embarazos_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("id"),
                        "id_region" => $this->_id_region,
                        "id_comuna" => $this->_id_comuna,
                        "FUR" => $fecha_fur,
                        "FPP" => $fecha_fpp
                    )
                );
            } else {
                $this->_embarazos_model->update(
                    array(
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "FUR" => $fecha_fur,
                        "FPP" => $fecha_fpp
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
                    "error" => $this->validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }
    
    /**
     *
     */
    public function ajax_lista()
    {
        $this->load->helper(array(
                "module/casos_febriles/permiso",
                "module/casos_febriles/estado"
            )
        );
        $lista = $this->_embarazos_model->listar(
            array(
                "region" => $this->_id_region,
                "comuna" => $this->_id_comuna
            )
        );

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }
                
                $fecha = DateTime::createFromFormat("Y-m-d", $caso["FPP"]);
                if ($fecha instanceof DateTime) {
                    $fecha_parto = $fecha->format("d/m/Y");
                }

                $propiedades = json_decode($caso["propiedades"]);

                $casos[] = array("id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "fecha" => $fecha_formato,
                    "fpp" => $fecha_parto,
                    "run" => $propiedades->RUN,
                    "nombre" => strtoupper($propiedades->NOMBRE . " " . $propiedades->APELLIDO),
                    "direccion" => strtoupper($propiedades->DIRECCION));

            }
        }

        $this->load->view("pages/embarazos/grilla", array("lista" => $casos));
    }
}

