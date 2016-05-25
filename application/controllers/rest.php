<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Rest extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("vectores_model", "_vectores_model");
        $this->load->model("hallazgos_model", "_hallazgos_model");
    }

    /**
     * Servicio para retornar oficinas
     * de acuerdo a la region
     */
    public function oficinas()
    {
        header('Content-type: application/json');

        $this->load->model("oficina_model", "oficina_model");

        $params = $this->uri->uri_to_assoc();
        $lista_oficinas = array();


        $regiones = array();
        if (!empty($params["region"]) and $params["region"] != "null") {
            $regiones = explode(",", $params["region"]);
        }

        if (count($regiones) > 0) {
            $lista_oficinas = $this->oficina_model->listarPorRegiones($regiones);
            if (is_null($lista_oficinas)) {
                $lista_oficinas = array();
            }
        } else {
            $lista_oficinas = $this->oficina_model->listar();
        }

        echo json_encode($lista_oficinas);
    }


    public function getDataVectores()
    {
        $listado = $this->_vectores_model->listar();

        $this->load->library('Fechas');

        $json = array();
        if ($listado) {
            $json['correcto'] = true;
            $i = 0;
            foreach ($listado as $item) {
                if ($item['cd_estado_vector'] == 1 or $item['cd_estado_vector'] == 2) {
                    $json['data'][$i]['id'] = $item["id_vector"];
                    $json['data'][$i]['lon'] = $item['cd_longitud_vector'];
                    $json['data'][$i]['lat'] = $item['cd_latitud_vector'];
                    if ($item['cd_estado_vector'] == 1) {
                        $json['data'][$i]['resultado'] = 'Aedes';
                        if ($item['cd_estado_desarrollo_vector'] == 1)
                            $json['data'][$i]['estado_desarrollo'] = 'Larva';
                        elseif ($item['cd_estado_desarrollo_vector'] == 2)
                            $json['data'][$i]['estado_desarrollo'] = 'Pupa';
                        elseif ($item['cd_estado_desarrollo_vector'] == 3)
                            $json['data'][$i]['estado_desarrollo'] = 'Adulto';
                        else
                            $json['data'][$i]['estado_desarrollo'] = 'No definido';
                    } elseif ($item['cd_estado_vector'] == 2) {
                        $json['data'][$i]['resultado'] = 'Culex';
                    } elseif ($item['cd_estado_vector'] == 3) {
                        $json['data'][$i]['resultado'] = 'Anopheles';
                    } elseif ($item['cd_estado_vector'] == 2) {
                        $json['data'][$i]['resultado'] = 'No culicido ('.$item['gl_nombre_mosquito_vector'].')';
                    }
                    $json['data'][$i]['fecha_hallazgo'] = Fechas::formatearHtml($item['fc_fecha_hallazgo_vector']);
                    $json['data'][$i]['fecha_resultado'] = Fechas::formatearHtml($item['fc_fecha_resultado_vector']);
                    $json['data'][$i]['observaciones'] = Fechas::formatearHtml($item['gl_observaciones_resultado_vector']);
                    $json['data'][$i]['direccion'] = $item['gl_direccion_vector'] . ' ' . $item['gl_referencias_vector'];

                    $i++;
                }

            }
        }


        echo json_encode($json);
    }


    public function getDataHallazgos()
    {
        $listado = $this->_hallazgos_model->listar();

        $this->load->library('Fechas');

        $json = array();
        if ($listado) {
            $json['correcto'] = true;
            $i = 0;
            foreach ($listado as $item) {
                if ($item['cd_estado_hallazgo'] == 1 or $item['cd_estado_hallazgo'] == 2) {
                    $json['data'][$i]['id'] = $item["id_hallazgo"];
                    $json['data'][$i]['lon'] = $item['cd_longitud_hallazgo'];
                    $json['data'][$i]['lat'] = $item['cd_latitud_hallazgo'];
                    if ($item['cd_estado_hallazgo'] == 1) {
                        $json['data'][$i]['resultado'] = 'Positivo';

                        if ($item['cd_estado_desarrollo_hallazgo'] == 1)
                            $json['data'][$i]['estado_desarrollo'] = 'Larva';
                        elseif ($item['cd_estado_desarrollo_hallazgo'] == 2)
                            $json['data'][$i]['estado_desarrollo'] = 'Pupa';
                        elseif ($item['cd_estado_desarrollo_hallazgo'] == 3)
                            $json['data'][$i]['estado_desarrollo'] = 'Adulto';
                        else
                            $json['data'][$i]['estado_desarrollo'] = 'No definido';
                    } elseif ($item['cd_estado_hallazgo'] == 2) {
                        $json['data'][$i]['resultado'] = 'Culex';
                    } elseif ($item['cd_estado_hallazgo'] == 3) {
                        $json['data'][$i]['resultado'] = 'Anopheles';
                    } elseif ($item['cd_estado_hallazgo'] == 2) {
                        $json['data'][$i]['resultado'] = 'No culicido ('.$item['gl_nombre_mosquito_vector'].')';
                    }
                    $json['data'][$i]['fecha_hallazgo'] = Fechas::formatearHtml($item['fc_fecha_hallazgo_hallazgo']);
                    $json['data'][$i]['fecha_resultado'] = Fechas::formatearHtml($item['fc_fecha_resultado_hallazgo']);
                    $json['data'][$i]['direccion'] = $item['gl_direccion_hallazgo'];

                    $i++;
                }
            }
        }


        echo json_encode($json);
    }

}



