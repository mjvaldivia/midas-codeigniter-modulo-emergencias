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
        $this->load->model("laboratorio_model", "_laboratorio_model");
        
        $this->load->helper(
            array(
                "modulo/usuario/usuario_form",
                "modulo/comuna/form",
                "modulo/marea_roja/permiso"
            )
        );
    }
    
    /**
     *
     */
    public function index()
    {
        $this->template->parse(
            "default", 
            "pages/marea_roja/muestra/index", 
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
                "modulo/laboratorio/form"
            )
        );
        $params = $this->input->get(null, true);

        $caso = $this->_marea_roja_model->getById($params["id"]);
        if (!is_null($caso)) {

            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
           
            $laboratorio = $this->_laboratorio_model->getById($caso->id_laboratorio);
            if(is_null($laboratorio)){
                $laboratorio = $this->_laboratorio_model->getByName($propiedades->{"LABORATORIO"});
            }
            
            $id_laboratorio = "";
            if(!is_null($laboratorio)){
                $id_laboratorio = $laboratorio->id;
            }
            
            
            $data = array(
                "id" => $caso->id,
                "id_laboratorio" => $id_laboratorio
            );
            
            foreach ($propiedades as $nombre => $valor) {
                $data["propiedades"][str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
            $this->layout_assets->addJs("modulo/marea_roja/form.js");
            $this->template->parse("default", "pages/marea_roja/muestra/form", $data);
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
                "lat" => $params["form_coordenadas_latitud"],
                "lng" => $params["form_coordenadas_longitud"]
            );
            
            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            $caso = $this->_marea_roja_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/
            
            
            
            
            /** se preparan datos del formulario **/
            $arreglo = array();
            
            $laboratorio = $this->_laboratorio_model->getById($params["laboratorio"]);
            if(is_null($laboratorio)){
                throw new Exception("No se ingreso el laboratorio");
            }

            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }
            
            $arreglo["LABORATORIO"] = $laboratorio->nombre;
            /*****************************************/
            
            
            if (is_null($caso)) {
                $id = $this->_marea_roja_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "id_region" => $params["region"],
                        "id_comuna" => $params["comuna"],
                        "id_laboratorio" => $laboratorio->id,
                        "numero_muestra" => $params["numero_de_muestra"],
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
                        "id_laboratorio" => $laboratorio->id,
                        "numero_muestra" => $params["numero_de_muestra"],
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                    ),
                    $caso->id
                );
                $id = $caso->id;
            }

            echo json_encode(
                array(
                    "error" => $this->marea_roja_validar->getErrores(),
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
                "modulo/direccion/comuna",
                "modulo/usuario/usuario_form",
                "modulo/laboratorio/form"
            )
        );
        
        $params = $this->uri->uri_to_assoc();
        
        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/form.js");
        $this->template->parse(
            "default",
            "pages/marea_roja/muestra/form",
            array(
                "fecha" => DATE("d/m/Y"),
                "ingresado" => $params["ingreso"],
                "region" => Region_Model::LOS_LAGOS,
                "id_laboratorio" => Laboratorio_Model::LOS_RIOS,
                "latitud" => "-42.92",
                "longitud" => "-73.17"
            )
        );
    }
    
    /**
     * 
     */
    public function ajax_form_excel(){
        $this->load->view("pages/marea_roja/muestra/form_excel", array("fecha" => date("d/m/Y")));
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
                "modulo/comuna/default",
                "modulo/direccion/region"
            )
        );
        
        $this->load->library(
            array(
                "core/fecha/fecha_conversion",
                "core/string/arreglo"
            )
        );
        
        $this->load->model("usuario_region_model","_usuario_region_model");

        //**************** FILTROS DE BUSQUEDA ***************************//
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
        $lista = $this->_marea_roja_model->listar(
            array(
                "region" => $this->arreglo->arrayToArray($lista_regiones, "id_region"),
                "fecha_desde" => $fecha_desde, "fecha_hasta" => $fecha_hasta)
        );
        
        //****************************************************************//
        
        $datos_excel = array();
        if (!is_null($lista)) {
            
            foreach ($lista as $caso) {
                $coordenadas = Zend_Json::decode($caso["coordenadas"]);
                $datos_excel[] = Zend_Json::decode($caso["propiedades"]);
                
                $fila = count($datos_excel)-1;
                
                $datos_excel[$fila]["id"] = $caso["id"];
                $datos_excel[$fila]["fecha_ingreso"] = $caso["fecha"];
                
                $datos_excel[$fila]["latitud"] = $coordenadas["lat"];
                $datos_excel[$fila]["longitud"] = $coordenadas["lng"];
            }

            $excel = $this->excel->nuevoExcel();
            
            $excel->getProperties()
                ->setCreator("Midas - Emergencias")
                ->setLastModifiedBy("Midas - Emergencias")
                ->setTitle("Exportación de marea roja")
                ->setSubject("Emergencias")
                ->setDescription("Marea roja")
                ->setKeywords("office 2007 openxml php emergencias")
                ->setCategory("Midas");

            //*********************** AGREGANDO COLUMNAS **********************************//
            $columnas = reset($datos_excel);

            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, "MUESTREO"); 
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, "FECHA DE TOMA DE MUESTRA"); 
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, "FECHA INGRESO"); 
            
            $i = 3;
            foreach($columnas as $columna => $valor){
                if(!in_array($columna, array("FECHA", "id", "fecha_ingreso", "latitud", "longitud"))){
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $columna);
                $i++;
                }
            }
            
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, "LATITUD");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i + 1, 1, "LONGITUD");
            
            //*****************************************************************************//

            $j = 2;
            foreach ($datos_excel as $id => $valores) {

                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $j, $valores["id"]);
                
                //***********************************************************************************//
                $fecha = $this->fecha_conversion->fechaToDateTime(
                    $valores["FECHA"], 
                    array(
                        "d/m/Y",
                        "d-m-Y"
                    )
                );
                
                if($fecha instanceof DateTime){
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $j, $fecha->format("d/m/Y"));
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $j, "");
                }
                
                $fecha_ingreso = $this->fecha_conversion->fechaToDateTime(
                    $valores["fecha_ingreso"], 
                    array(
                        "Y-m-d H:i:s"
                    )
                );
                
                if($fecha_ingreso instanceof DateTime){
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, $fecha_ingreso->format("d/m/Y"));
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, "");
                }

                //***********************************************************************************//
                
                $i = 3;
                foreach ($columnas as $columna => $valor) {
                    
                    if(!in_array($columna, array("FECHA", "id", "fecha_ingreso", "latitud", "longitud"))){
                        switch ($columna) {
                            case "REGION":
                                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, nombreRegion($valores[$columna]));
                                break;
                            case "COMUNA":
                                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, nombreComuna($valores[$columna]));
                                break;
                            default:
                                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, strtoupper($valores[$columna]));
                                break;
                        }
                    $i++;
                    }
                }
                
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, $valores["latitud"]);
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i+1, $j, $valores["longitud"]);
                
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
        $params = $this->input->post(null, true);
        
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

        
        $lista = $this->_filtros($params);

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
                
                $laboratorio = $this->_laboratorio_model->getById($caso["id_laboratorio"]);
                if(is_null($laboratorio)){
                    $laboratorio_nombre = $propiedades["LABORATORIO"];
                } else {
                    $laboratorio_nombre = $laboratorio->nombre;
                }

                
                $casos[] = array(
                    "id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "numero_muestra" => $caso["numero_muestra"],
                    "fecha_ingreso" => $fecha_ingreso,
                    "fecha_muestra" => $fecha_formato,
                    "recurso" => strtoupper($propiedades["RECURSO"]),
                    "origen" => strtoupper($propiedades["ORIGEN"]),
                    "bo_ingreso_resultado" => $caso["bo_ingreso_resultado"],
                    "comuna" => $caso["id_comuna"],
                    "laboratorio" => $laboratorio_nombre,
                    "resultado" => $propiedades["RESULTADO"]
                );

            }
        }

        $this->load->view("pages/marea_roja/muestra/grilla", array("lista" => $casos));
    }
    
    /**
     * 
     * @param array $params
     * @return array
     */
    protected function _filtros($params){
        return $this->_marea_roja_model->listar(
            array(
                "region" => $this->_filtrosRegion($params),
                "comuna" => $params["comuna"]
            )
        );
    }
    
    /**
     * Filtros de region
     * @param array $params
     * @return array
     */
    protected function _filtrosRegion($params){
        if($params["region"]!=""){
            $lista_regiones[0] = $params["region"];
        } else {
            $lista_regiones = $this->arreglo->arrayToArray(
                $this->_usuario_region_model->listarPorUsuario($this->session->userdata('session_idUsuario')),
                "id_region"
            );
        }
        return $lista_regiones;
    }
}

