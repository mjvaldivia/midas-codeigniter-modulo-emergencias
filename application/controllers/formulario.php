<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Formulario extends MY_Controller
{
    /**
     *
     * @var Rapanui_Dengue_Model
     */
    public $_rapanui_dengue_model;

    /**
     *
     * @var Rapanui_Dengue_Estado_Model
     */
    public $_rapanui_dengue_estado_model;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        sessionValidation();
        $this->load->library("session");
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->model("rapanui_dengue_model", "_rapanui_dengue_model");
        $this->load->model("rapanui_dengue_estado_model", "_rapanui_dengue_estado_model");
    }

    /**
     *
     */
    public function index()
    {

        $params = $this->uri->uri_to_assoc();
        $puedeVerGraficos = false;
        if($this->session->userdata('session_roles') == 27)
            $puedeVerGraficos = true;

        if (puedeVerReporteEmergencia("casos_febriles") || puedeEditar("casos_febriles") || puedeEliminar("casos_febriles")) {
            $this->template->parse("default", "pages/formulario/dengue", array('puedeVerGraficos'=>$puedeVerGraficos));
        } else {
            if (isset($params["ingresado"]) && $params["ingresado"] == "correcto") {
                redirect(base_url("formulario/form_dengue/ingreso/correcto"));
            } else {
                redirect(base_url("formulario/form_dengue"));
            }
        }
    }

    /**
     *
     */
    public function form_dengue()
    {
        $this->load->helper("modulo/emergencia/emergencia");
        $params = $this->uri->uri_to_assoc();

        $this->template->parse(
            "default",
            "pages/formulario/form-dengue",
            array(
                "ingresado" => $params["ingreso"],
                "latitud" => "-27.11299",
                "longitud" => "-109.34958059999997"
            )
        );
    }

    /**
     *
     */
    public function editar()
    {
        $this->load->helper("modulo/emergencia/emergencia");
        $params = $this->input->get(null, true);

        $caso = $this->_rapanui_dengue_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id);
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;

            $estado = $this->_rapanui_dengue_estado_model->getById($caso->id_estado);
            if (!is_null($estado)) {
                $data["conclusion_del_caso"] = $estado->id;
            }

            $this->template->parse("default", "pages/formulario/form-dengue", $data);
        }
    }

    /**
     *
     */
    public function guardar_dengue()
    {
        $this->load->library(array("rut", "formulario/formulario_dengue_validar"));

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->formulario_dengue_validar->esValido($params)) {

            $coordenadas = array("lat" => $params["latitud"],
                "lng" => $params["longitud"]);
            unset($params["latitud"]);
            unset($params["longitud"]);

            $caso = $this->_rapanui_dengue_model->getById($params["id"]);
            unset($params["id"]);

            $id_estado = null;
            $estado = $this->_rapanui_dengue_estado_model->getById($params["conclusion_del_caso"]);
            if (!is_null($estado)) {
                $id_estado = $estado->id;
            }
            unset($params["conclusion_del_caso"]);

            $enviado = 0;
            if (isset($params["enviado"])) {
                $enviado = $params["enviado"];
                unset($params["enviado"]);
            }

            $arreglo = array();
            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }

            if (is_null($caso)) {
                $this->_rapanui_dengue_model->insert(array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("session_idUsuario"),
                        "id_estado" => $id_estado,
                        "enviado_epidemilogico" => $enviado)
                );
            } else {
                $this->_rapanui_dengue_model->update(array("propiedades" => json_encode($arreglo),
                    "coordenadas" => json_encode($coordenadas),
                    "id_estado" => $id_estado,
                    "enviado_epidemilogico" => $enviado),
                    $caso->id);
            }

            echo json_encode(array("error" => array(),
                "correcto" => true));
        } else {
            echo json_encode(array("error" => $this->formulario_dengue_validar->getErrores(),
                "correcto" => false));
        }
    }

    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_rapanui_dengue_model->delete($params["id"]);
        echo json_encode(array("error" => array(),
            "correcto" => true));
    }

    /**
     * Genera excel para casos de dengue
     */
    public function excel()
    {

        $this->load->helper(
            array(
                "modulo/usuario/usuario",
                "modulo/formulario/formulario"
            )
        );

        $this->load->library("excel");
        $lista = $this->_rapanui_dengue_model->listar();

        $datos_excel = array();
        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                $datos_excel[] = Zend_Json::decode($caso["propiedades"]);
                $datos_excel[count($datos_excel) - 1]["id"] = $caso["id"];
                $datos_excel[count($datos_excel) - 1]["id_usuario"] = $caso["id_usuario"];
                $datos_excel[count($datos_excel) - 1]["id_estado"] = $caso["id_estado"];
            }

            $excel = $this->excel->nuevoExcel();
            $excel->getProperties()
                ->setCreator("Midas - Emergencias")
                ->setLastModifiedBy("Midas - Emergencias")
                ->setTitle("Exportación de casos febriles")
                ->setSubject("Emergencias")
                ->setDescription("Casos febriles")
                ->setKeywords("office 2007 openxml php sumanet")
                ->setCategory("Midas");

            $columnas = reset($datos_excel);

            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, "CASO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, "ESTADO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, "MÉDICO");

            $i = 2;
            foreach ($columnas as $columna => $valor) {

                $exportar = $this->_boExportarColumnaExcel($columna);

                if ($exportar) {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $columna);
                    $i++;
                }

            }

            $j = 2;
            foreach ($datos_excel as $id => $valores) {

                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $j, $valores["id"]);
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $j, (string)nombreFormularioEstado($valores["id_estado"]));
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $j, (string)nombreUsuario($valores["id_usuario"]));

                unset($valores["id_usuario"]);

                $i = 3;
                foreach ($valores as $columna => $valor) {
                    $exportar = $this->_boExportarColumnaExcel($columna);
                    if ($exportar) {
                        $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, strtoupper($valor));
                        $i++;
                    }
                }
                $j++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="casos_febriles.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            echo "No hay registros para generar el excel";
        }
    }

    /**
     *
     * @param type $columna
     * @return boolean
     */
    protected function _boExportarColumnaExcel($columna)
    {
        $exportar = true;
        if (!puedeVerFormularioDatosPersonales("casos_febriles")) {
            switch ($columna) {
                case "NOMBRE":
                case "APELLIDO":
                case "RUN";
                case "NUMERO PASAPORTE":
                case "TELEFONO":
                    $exportar = false;
                    break;
            }
        }
        return $exportar;
    }

    /**
     * Genera en pdf
     */
    public function pdf()
    {

        $this->load->helper(array(
                "modulo/usuario/usuario",
                "modulo/formulario/formulario"
            )
        );

        $this->load->library("pdf");
        $params = $this->uri->uri_to_assoc();
        $formulario = $this->_rapanui_dengue_model->getById($params["id"]);
        if (!is_null($formulario)) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline;filename=formulario.pdf");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            $propiedades = Zend_Json::decode($formulario->propiedades);

            $datos = array();
            foreach ($propiedades as $nombre => $valor) {
                $datos[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }
            $datos["estado"] = $formulario->id_estado;
            $datos["id_usuario"] = $formulario->id_usuario;
            $datos["id"] = $formulario->id;
            $html = $this->load->view("pages/formulario/pdf", $datos, true);
            $pdf = $this->pdf->load();
            $pdf->imagen_logo = file_get_contents(FCPATH . "/assets/img/top_logo.png");
            $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
            $pdf->WriteHTML($html);
            echo $pdf->Output('formulario.pdf', 'S');
        }
    }

    /**
     *
     */
    public function ajax_lista()
    {
        $this->load->helper(array(
                "modulo/emergencia/emergencia",
                "modulo/usuario/usuario",
                "modulo/formulario/formulario"
            )
        );
        $lista = $this->_rapanui_dengue_model->listar();

        $casos = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }

                $propiedades = json_decode($caso["propiedades"]);

                $casos[] = array("id" => $caso["id"],
                    "enviado" => $caso["enviado_epidemilogico"],
                    "id_usuario" => $caso["id_usuario"],
                    "id_estado" => $caso["id_estado"],
                    "fecha" => $fecha_formato,
                    "semana" => $propiedades->{"SEMANA EPIDEMIOLOGICA"},
                    "run" => $propiedades->RUN,
                    "diagnostico" => strtoupper($propiedades->{"DIAGNOSTICO CLINICO"}),
                    "nombre" => strtoupper($propiedades->NOMBRE . " " . $propiedades->APELLIDO),
                    "direccion" => strtoupper($propiedades->DIRECCION));
            }
        }

        $this->load->view("pages/formulario/grilla", array("lista" => $casos));
    }


    public function dengue_reporte_grafico()
    {

        $lista = $this->_rapanui_dengue_model->listar();



        /* estados febriles */
        $arr_estados = array('sospechoso' => 0, 'positivo' => 0, 'negativo' => 0, 'no_concluyente' => 0);
        $arr_semanas = array();
        $arr_semanas_labels = array();
        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                if ($caso['id_estado'] == 1) {
                    $arr_estados['positivo'] += 1;
                } elseif ($caso['id_estado'] == 2) {
                    $arr_estados['negativo'] += 1;
                } elseif ($caso['id_estado'] == 3) {
                    $arr_estados['no_concluyente'] += 1;
                } else {
                    $arr_estados['sospechoso'] += 1;
                }


                $propiedades = json_decode($caso["propiedades"]);

                if (isset($arr_semanas[$propiedades->{"SEMANA EPIDEMIOLOGICA"}])) {

                    if ($caso['id_estado'] == 1) {
                        $arr_semanas[$propiedades->{"SEMANA EPIDEMIOLOGICA"}]['positivo'] += 1;
                    } elseif ($caso['id_estado'] == 2) {
                        $arr_semanas[$propiedades->{"SEMANA EPIDEMIOLOGICA"}]['negativo'] += 1;
                    } elseif ($caso['id_estado'] == 3) {
                        $arr_semanas[$propiedades->{"SEMANA EPIDEMIOLOGICA"}]['no_concluyente'] += 1;
                    } else {
                        $arr_semanas[$propiedades->{"SEMANA EPIDEMIOLOGICA"}]['sospechoso'] += 1;
                    }
                } else {

                    $tmp = explode(" ", $propiedades->{"SEMANA EPIDEMIOLOGICA"});
                    $i = (int)$tmp[0];
                    if(!in_array($i,$arr_semanas_labels))
                        $arr_semanas_labels[] = (int)$tmp[0];

                    if ($caso['id_estado'] == 1) {
                        $arr_semanas_positivo[$i] += 1;
                    } elseif ($caso['id_estado'] == 2) {
                        $arr_semanas_negativo[$i] += 1;
                    } elseif ($caso['id_estado'] == 3) {
                        $arr_semanas_no_concluyente[$i] += 1;
                    } else {
                        $arr_semanas_sospechoso[$i] += 1;
                    }

                }

            }
        }


        sort($arr_semanas_labels);
        foreach($arr_semanas_labels as $label){
            $semanas_positivo[] = $arr_semanas_positivo[$label];
            $semanas_negativo[] = $arr_semanas_negativo[$label];
            $semanas_no_concluyente[] = $arr_semanas_no_concluyente[$label];
            $semanas_sospechoso[] = $arr_semanas_sospechoso[$label];
        }

        $estados[] = array('value' => $arr_estados['positivo'], 'label' => 'Positivo', 'color' => '#e74c3c');
        $estados[] = array('value' => $arr_estados['negativo'], 'label' => 'Negativo', 'color' => '#16a085');
        $estados[] = array('value' => $arr_estados['no_concluyente'], 'label' => 'No Concluyente', 'color' => '#2980b9');
        $estados[] = array('value' => $arr_estados['sospechoso'], 'label' => 'Sospechoso', 'color' => '#f39c12');

        $data = array(
            'estados' => json_encode($arr_estados),
            'semanas_labels' => json_encode($arr_semanas_labels),
            'semanas_positivo' => json_encode($semanas_positivo),
            'semanas_negativo' => json_encode($semanas_negativo),
            'semanas_no_concluyente' => json_encode($semanas_no_concluyente),
            'semanas_sospechoso' => json_encode($semanas_sospechoso)
        );

        $this->template->parse('default', 'pages/formulario/reporte_grafico', $data);
    }


}

