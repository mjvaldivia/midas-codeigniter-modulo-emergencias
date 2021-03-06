<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Embarazo extends MY_Controller
{
    
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
        sessionValidation();
        $this->load->model("embarazos_model", "_embarazos_model");
    }
    
    /**
     *
     */
    public function index()
    {
        $this->template->parse("default", "pages/embarazos/index", array());
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

            $this->template->parse("default", "pages/embarazos/form", $data);
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
    public function cargaExcel(){
        $filtro = New Zend_Filter_Alpha();
        $this->load->library("excel");
        $excel = $this->excel->leerExcel(BASEPATH . "../media/embarazos.xlsx");
        
        $columnas = array();
        
        $worksheet = $excel->setActiveSheetIndex(0);

        $primera = true;
        
        foreach ($worksheet->getRowIterator() as $row) {
            
            if(!$primera){
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(true); // Loop all cells, even if it is not set

                $apellido_paterno = "";
                $apellido_materno = "";
                $propiedades = array();
                $FPP = "";
                $FUR = "";

                foreach ($cellIterator as $cell) {

                        if (!is_null($cell) AND $cell->getCalculatedValue()!="") {

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="A"){
                                    $propiedades["RUN"] = $cell->getCalculatedValue();
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="B"){
                                    $apellido_paterno = $cell->getCalculatedValue();
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="C"){
                                    $apellido_materno = $cell->getCalculatedValue();
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="D"){
                                    $propiedades["NOMBRE"] = $cell->getCalculatedValue();
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="E"){
                                    $propiedades["EDAD"] = $cell->getCalculatedValue();
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="F"){
                                    
                                    if(PHPExcel_Shared_Date::isDateTime($cell)) {
                                        $fecha = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
                                        $FPP = $fecha;
                                    }
                                }

                                if($filtro->filter(trim(substr($cell->getCoordinate(),0, 2)))=="G"){
                                     if(PHPExcel_Shared_Date::isDateTime($cell)) {
                                        $fecha = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
                                        $FUR = $fecha;
                                    }
                                }
                        }
                }

                $propiedades["APELLIDO"] = $apellido_paterno . " " . $apellido_materno;
                
                
                $this->_embarazos_model->insert(
                    array("fecha" => DATE("Y-m-d"),
                          "propiedades" => json_encode($propiedades),
                          "FUR" => $FUR,
                          "id_usuario" => 1,
                          "FPP" => $FPP)
                );
            }
            
            $primera = false;
        }   
        
       // print_r($columnas);
    }
    
      /**
     *
     */
    public function guardar()
    {
        $this->load->library(array("rut", "formulario/formulario_intoxicacion_validar"));

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->formulario_intoxicacion_validar->esValido($params)) {
            
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
                        "id_usuario" => $this->session->userdata("session_idUsuario"),
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
                    "error" => $this->formulario_embarazada_validar->getErrores(),
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
            "pages/embarazos/form",
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
        $lista = $this->_embarazos_model->listar();

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

