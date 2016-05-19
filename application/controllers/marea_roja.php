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
            if (is_null($laboratorio)) {
                $laboratorio = $this->_laboratorio_model->getByName($propiedades->{"LABORATORIO"});
            }

            $id_laboratorio = "";
            if (!is_null($laboratorio)) {
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
            $this->layout_assets->addJs("modulo/marea_roja/muestra/form.js");
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
            if (is_null($laboratorio)) {
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
                
                // parche para no borrar resultado si ya fue ingresado
                $propiedades = Zend_Json::decode($caso->propiedades);
                if(isset($propiedades["RESULTADO"])){
                    $arreglo["RESULTADO"] = $propiedades["RESULTADO"];
                }
                
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
    public function nuevo()
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

        $params = $this->uri->uri_to_assoc();

        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/muestra/form.js");
        $this->template->parse(
            "default",
            "pages/marea_roja/muestra/form",
            array(
                "fecha" => DATE("d/m/Y"),
                "ingresado" => $params["ingreso"],
                "region" => Region_Model::LOS_LAGOS,
                //"id_laboratorio" => Laboratorio_Model::LOS_RIOS,
                "latitud" => "-39.770306907243636",
                "longitud" => "-73.73030273437502"
            )
        );
    }

    /**
     *
     */
    public function ajax_form_excel()
    {
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
                "core/string/arreglo",
                "excel"
            )
        );

        $this->load->model("usuario_region_model", "_usuario_region_model");

        //**************** FILTROS DE BUSQUEDA ***************************//
        $lista = $this->_filtrosExcel($params);
        //****************************************************************//

        $datos_excel = array();
        if (!is_null($lista)) {

            foreach ($lista as $caso) {
                $coordenadas = Zend_Json::decode($caso["coordenadas"]);
                $datos_excel[] = Zend_Json::decode($caso["propiedades"]);

                $fila = count($datos_excel) - 1;

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
            foreach ($columnas as $columna => $valor) {
                if (!$this->_quitarColumnaExcel($columna)) {
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

                if ($fecha instanceof DateTime) {
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

                if ($fecha_ingreso instanceof DateTime) {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, $fecha_ingreso->format("d/m/Y"));
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, "");
                }

                //***********************************************************************************//

                $i = 3;
                foreach ($columnas as $columna => $valor) {

                    if (!$this->_quitarColumnaExcel($columna)) {
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
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i + 1, $j, $valores["longitud"]);

                $j++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="marea_roja_' . date('d-m-Y') . '.xlsx"');
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

        $this->load->model("usuario_region_model", "_usuario_region_model");

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
            $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

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
                if ($fecha instanceof DateTime) {
                    $fecha_ingreso = $fecha->format("d/m/Y");
                }

                $laboratorio = $this->_laboratorio_model->getById($caso["id_laboratorio"]);
                if (is_null($laboratorio)) {
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
                    "resultado" => $propiedades["RESULTADO"],
                    "actas" => $this->MareaRojaActasModel->listar(array('id_marea' => $caso['id']))
                );

            }
        }

        $this->load->view("pages/marea_roja/muestra/grilla", array("lista" => $casos));
    }

    /**
     * Filtros para la lista
     * @param array $params
     * @return array
     */
    protected function _filtros($params)
    {
        return $this->_marea_roja_model->listar(
            array(
                "region" => $this->_filtrosRegion($params),
                "comuna" => $params["comuna"]
            )
        );
    }
    
    /**
     * Filtros para la descarga de excel
     * @param array $params
     * @return array
     */
    protected function _filtrosExcel($params){
        $fecha_desde = null;
        if ($params["fecha_desde"] != "") {
            $fecha_desde = DateTime::createFromFormat("d_m_Y", $params["fecha_desde"]);
        }

        $fecha_hasta = null;
        if ($params["fecha_hasta"] != "") {
            $fecha_hasta = DateTime::createFromFormat("d_m_Y", $params["fecha_hasta"]);
        }
        
        return $this->_marea_roja_model->listar(
            array(
                "region" => $this->arreglo->arrayToArray(
                    $this->_filtrosRegion($params), 
                    "id_region"
                ),
                "fecha_desde" => $fecha_desde, 
                "fecha_hasta" => $fecha_hasta
            )
        );
    }
    
    /**
     * Quita columnas del excel
     * @param array $columna
     * @return boolean
     */
    protected function _quitarColumnaExcel($columna){
        
        $quitar = array(
            "FECHA", "id", "fecha_ingreso", "latitud", "longitud",
            "FORM COORDENADAS TIPO",
            "FORM COORDENADAS GMS GRADOS LAT",
            "FORM COORDENADAS GMS MINUTOS LAT",
            "FORM COORDENADAS GMS SEGUNDOS LAT",
            "FORM COORDENADAS GMS GRADOS LNG",
            "FORM COORDENADAS GMS MINUTOS LNG",
            "FORM COORDENADAS GMS SEGUNDOS LNG",
            "FORM COORDENADAS UTM ZONA",
            "FORM COORDENADAS UTM LATITUD",
            "FORM COORDENADAS UTM LONGITUD",
            "FORM COORDENADAS LATITUD",
            "FORM COORDENADAS LONGITUD"
        );
        
        if (!in_array($columna, $quitar)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Filtros de region
     * @param array $params
     * @return array
     */
    protected function _filtrosRegion($params)
    {
        if ($params["region"] != "") {
            $lista_regiones[0] = $params["region"];
        } else {
            $lista_regiones = $this->arreglo->arrayToArray(
                $this->_usuario_region_model->listarPorUsuario($this->session->userdata('session_idUsuario')),
                "id_region"
            );
        }
        return $lista_regiones;
    }


    public function adjuntarActa()
    {
        $params = $this->uri->uri_to_assoc();

        $data = array(
            'id' => $params['id']
        );
        $this->load->view('pages/marea_roja/muestra/acta', $data);
    }


    public function subir_acta()
    {

        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];

        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->library("cache");
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $tmp_name = $_FILES['acta']['tmp_name'];
        $total = count($tmp_name);
        $nombres = $_FILES['acta']['name'];
        $size = $_FILES['acta']['size'];
        $type = $_FILES['acta']['type'];

        $binary_path = ('media/doc/marea_roja/muestra/' . $id);
        if (!is_dir($binary_path)) {
            @mkdir($binary_path, 0777, true);
        }

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $json = array();
        $valido = 0;
        for ($i = 0; $i < $total; $i++) {
            $fp = file_get_contents($tmp_name[$i], 'r');

            $nombre = str_replace(' ', '_', $nombres[$i]);
            $sha = sha1($nombre);
            $mime = $type[$i];
            $ruta_archivo = $binary_path . '/' . $nombre;
            $ftmp = fopen($ruta_archivo, 'w');
            fwrite($ftmp, $fp);
            fclose($ftmp);
            if (is_file($ruta_archivo) and is_readable($ruta_archivo)) {
                $data = array(
                    'id_marea' => $id,
                    'id_usuario' => $this->session->userdata('session_idUsuario'),
                    'fc_fecha_acta' => date('Y-m-d H:i:s'),
                    'gl_nombre_acta' => $nombre,
                    'gl_ruta_acta' => $ruta_archivo,
                    'gl_mime_acta' => $mime,
                    'gl_sha_acta' => $sha
                );

                if($this->MareaRojaActasModel->insert($data)){
                    $valido++;
                }
            }

        }

        if($total == $valido){
            $json['estado'] = true;
            $json['mensaje'] = 'Archivo(s) subido(s) correctamente';
        }elseif($valido > 0 and $total>$valido){
            $json['estado'] = true;
            $json['mensaje'] = 'Hubieron algunos archivos que no se subieron';
        }elseif($valido == 0){
            $json['estado'] = false;
            $json['mensaje'] = 'Errores al subir archivos';
        }

        echo json_encode($json);

    }


    public function verActas(){
        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $arr_actas = array();
        $listado = $this->MareaRojaActasModel->listar(array('id_marea' => $id));
        if($listado){
            $arr_actas = $listado;
        }

        $this->load->view('pages/marea_roja/muestra/grilla_actas',array('listado'=>$arr_actas));
    }


    public function ver_acta(){
        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];
        $sha = $params['token'];

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $acta = $this->MareaRojaActasModel->getById($id);

        header('Content-type:'.$acta->gl_mime_acta);
        header('Content-disposition: inline; filename="'.$acta->gl_nombre_acta.'"');
        echo file_get_contents(FCPATH .$acta->gl_ruta_acta);
    }

}

