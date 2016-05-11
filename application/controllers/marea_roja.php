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
        $this->load->model("modulo_model", "_modulo_model");
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
        ini_set('display_errors', 1);
        error_reporting(E_ALL ^ E_NOTICE);
        $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario",
                "modulo/direccion/region",
                "modulo/direccion/comuna",
                "modulo/usuario/usuario_form"
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
    public function ajax_form_excel(){
        $this->load->view("pages/marea_roja/form_excel", array("fecha" => date("d/m/Y")));
    }
    
    /**
     * Genera excel para casos de dengue
     */
    public function excel()
    {

        $params = $this->uri->uri_to_assoc();
        
        $this->load->helper(
            array(
                "modulo/usuario/usuario",
                "modulo/formulario/formulario",
                "modulo/comuna/default"
            )
        );
        
        $this->load->library(
            array(
                "core/fecha/fecha_conversion",
                "core/string/arreglo"
            )
        );
        
        $this->load->model("usuario_region_model","_usuario_region_model");

        $fecha_desde = null;
        if($params["fecha_desde"]!=""){
            $fecha_desde = DateTime::createFromFormat("d_m_Y", $params["fecha_desde"]);
        }
        
        $fecha_hasta = null;
        if($params["fecha_hasta"]!=""){
            $fecha_hasta = DateTime::createFromFormat("d_m_Y", $params["fecha_hasta"]);
        }
        
        $lista_regiones = $this->_usuario_region_model->listarPorUsuario($this->session->userdata('session_idUsuario'));

        $this->load->library("excel");
        $lista = $this->_marea_roja_model->listar(array("region" => $this->arreglo->arrayToArray($lista_regiones, "id_region"),"fecha_desde" => $fecha_desde, "fecha_hasta" => $fecha_hasta));
        //DIE();
        $datos_excel = array();
        if (!is_null($lista)) {
            
            foreach ($lista as $caso) {
                $datos_excel[] = Zend_Json::decode($caso["propiedades"]);
                $datos_excel[count($datos_excel)-1]["id"] = $caso["id"];
                $datos_excel[count($datos_excel)-1]["fecha_ingreso"] = $caso["fecha"];
            }

            $excel = $this->excel->nuevoExcel();
            
            $excel->getProperties()
                ->setCreator("Midas - Emergencias")
                ->setLastModifiedBy("Midas - Emergencias")
                ->setTitle("Exportación de marea roja")
                ->setSubject("Emergencias")
                ->setDescription("Marea roja")
                ->setKeywords("office 2007 openxml php sumanet")
                ->setCategory("Midas");

            $columnas = reset($datos_excel);

            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, "MUESTREO"); 
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, "FECHA DE TOMA DE MUESTRA"); 
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, "FECHA INGRESO"); 
            
            $i = 3;
            foreach($columnas as $columna => $valor){
                if($columna != "FECHA" and $columna != "id" and $columna!="fecha_ingreso"){
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $columna);
                $i++;
                }
            }

            $j = 2;
            foreach ($datos_excel as $id => $valores) {

                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $j, $valores["id"]);
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $j, $valores["FECHA"]);
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, $valores["fecha_ingreso"]);
                
                $i = 3;
                foreach ($columnas as $columna => $valor) {
               
                    if($columna != "FECHA" and $columna != "id" and $columna!="fecha_ingreso"){
                        if($columna == "COMUNA"){
                            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, nombreComuna($valores[$columna]));
                        } else {
                            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, strtoupper($valores[$columna]));
                        }
                    $i++;
                    }
                    
                }
                $j++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="marea_roja_'.date('d-m-Y').'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            echo "No hay registros para generar el excel";
        }
    }
    
    /**
     *
     */
    public function ajax_lista()
    {
        
        $this->load->model("usuario_region_model","_usuario_region_model");
        
        $this->load->helper(array(
                "modulo/emergencia/emergencia",
                "modulo/usuario/usuario",
                "modulo/comuna/default"
            )
        );
        
        $this->load->library(
            array(
                "core/fecha/fecha_conversion",
                "core/string/arreglo"
            )
        );
        
        $lista_regiones = $this->_usuario_region_model->listarPorUsuario($this->session->userdata('session_idUsuario'));
        
        $lista = $this->_marea_roja_model->listar(array("region" => $this->arreglo->arrayToArray($lista_regiones, "id_region")));

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                
                $fecha_formato = "";
                $fecha_ingreso = "";
                
                $propiedades = Zend_Json::decode($caso["propiedades"]);
                
                
                $fecha = $this->fecha_conversion->fechaToDateTime(
                    $propiedades["FECHA"],
                    array(
                        "d-m-Y",
                        "d/m/Y"
                    )
                );
                
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }
                
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if($fecha instanceof DateTime){
                    $fecha_ingreso = $fecha->format("d/m/Y");
                }
                
                $casos[] = array(
                    "id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "fecha_ingreso" => $fecha_ingreso,
                    "fecha_muestra" => $fecha_formato,
                    "recurso" => strtoupper($propiedades["RECURSO"]),
                    "origen" => strtoupper($propiedades["ORIGEN"]),
                    "comuna" => $caso["id_comuna"],
                    "resultado" => $propiedades["RESULTADO"]
                );

            }
        }

        $this->load->view("pages/marea_roja/grilla", array("lista" => $casos));
    }
}

