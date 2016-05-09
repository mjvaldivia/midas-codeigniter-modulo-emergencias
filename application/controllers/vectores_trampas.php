<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");

class Vectores_trampas extends MY_Controller
{

    public $_trampas_model;


    public function __construct()
    {
        parent::__construct();
        $this->login_authentificate->validar();
        $this->load->model("trampas_model", "_trampas_model");
    }


    public function index()
    {
        /*$this->layout_assets->addMapaFormulario();
        $this->layout_assets->addJs("trampas/form.js");*/
        $this->load->helper(array(
                "module/emergencia/emergencia",
                "module/usuario/usuario",
            )
        );
        $lista = $this->_trampas_model->listar();

        $trampas = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {

                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fc_fecha_trampa"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }

                $propiedades = json_decode($caso["gl_propiedades_trampa"]);

                $casos[] = array(
                    "id" => $caso["id_trampa"],
                    "id_usuario" => $caso["cd_usuario_trampa"],
                    "fecha" => $fecha_formato,
                    "direccion" => strtoupper($propiedades->DIRECCION),
                    "fecha_instalacion" => $propiedades->FECHA,
                    "tipo" => $propiedades->TIPO
                );

            }
        }

        $data = array(
            'grilla' => $this->load->view('pages/trampas/grilla', array('lista' => $casos), true)
        );

        $this->layout_template->view("default", "pages/trampas/index", $data);
    }


    public function ajax_lista()
    {
        $this->load->helper(array(
                "module/emergencia/emergencia",
                "module/usuario/usuario",
            )
        );
        $lista = $this->_trampas_model->listar();

        $trampas = array();

        if (!is_null($lista)) {
            foreach ($lista as $caso) {

                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fc_fecha_trampa"]);
                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }

                $propiedades = json_decode($caso["gl_propiedades_trampa"]);

                $casos[] = array(
                    "id" => $caso["id_trampa"],
                    "id_usuario" => $caso["cd_usuario_trampa"],
                    "fecha" => $fecha_formato,
                    "direccion" => strtoupper($propiedades->DIRECCION),
                    "fecha_instalacion" => $propiedades->FECHA,
                    "tipo" => $propiedades->TIPO
                    );

            }
        }

        $this->load->view("pages/trampas/grilla", array("lista" => $casos));
    }


    public function nuevo()
    {
        $this->load->helper(
            array(
                "module/emergencia/emergencia",
                "module/formulario/formulario"
            )
        );
        $params = $this->uri->uri_to_assoc();

        $this->layout_assets->addMapaFormulario();
        //$this->layout_assets->addJs("mapa/formulario.js");
        /*<?= loadJS("assets/js/library/jquery.typing-0.2.0/jquery.typing.min.js") ?>*/
        $this->layout_assets->addJs("trampas/form.js");
        $this->layout_template->view(
            "default",
            "pages/trampas/form",
            array(
                "ingresado" => $params["ingreso"],
                "latitud" => "",
                "longitud" => ""
            )
        );
    }


    public function guardar()
    {
        $this->load->library(array("formulario/formulario_trampas_validar"));

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->formulario_trampas_validar->esValido($params)) {

            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["latitud"],
                "lng" => $params["longitud"]
            );

            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            /** caso febril **/
            $caso = $this->_trampas_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/

            /** se preparan datos del formulario **/
            $arreglo = array();
            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }


            if (is_null($caso)) {
                $id = $this->_trampas_model->insert(
                    array(
                        "fc_fecha_trampa" => date("Y-m-d H:i:s"),
                        "cd_usuario_trampa" => $this->session->userdata("id"),
                        "gl_propiedades_trampa" => json_encode($arreglo),
                        "gl_coordenadas_trampa" => json_encode($coordenadas)
                    )
                );
            } else {
                $this->_trampas_model->update(
                    array(
                        "gl_propiedades_trampa" => json_encode($arreglo),
                        "gl_coordenadas_trampa" => json_encode($coordenadas)
                    ),
                    $caso->id_trampa
                );
                $id = $caso->id_trampa;
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
                    "error" => $this->formulario_trampas_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }


    public function editar()
    {
        $this->load->helper(
            array(
                "module/emergencia/emergencia",
                "module/formulario/formulario"
            )
        );

        $this->load->library('Fechas');

        $params = $this->input->get(null, true);

        $caso = $this->_trampas_model->getById($params["id"]);
        if (!is_null($caso)) {

            $data = array("id" => $caso->id_trampa);

            $inspecciones = array();

            $propiedades = json_decode($caso->gl_propiedades_trampa);
            $coordenadas = json_decode($caso->gl_coordenadas_trampa);
            foreach ($propiedades as $nombre => $valor) {
                $data[str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $arr_inspecciones = array();
            $inspecciones = $this->_trampas_model->getInspeccionesTrampa($caso->id_trampa);

            if($inspecciones){
                foreach($inspecciones as $inspeccion){
                    $arr_inspecciones['inspecciones'][] = $inspeccion;
                }
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            $data["inspecciones"] = $inspecciones;
            $data["grilla_inspecciones"] = $this->load->view('pages/trampas/grilla_inspecciones',$arr_inspecciones , true);

            $this->layout_assets->addMapaFormulario();
            //$this->layout_assets->addJs("mapa/formulario.js");
            /*<?= loadJS("assets/js/library/jquery.typing-0.2.0/jquery.typing.min.js") ?>*/
            $this->layout_assets->addJs("trampas/form.js");
            $this->layout_template->view("default", "pages/trampas/form", $data);
        }
    }


    public function guardarInspeccion()
    {

        $this->load->library(array("formulario/formulario_trampas_validar","Fechas"));

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        $date = Fechas::formatearBaseDatos($params["fecha_inspeccion"]);


        if ($this->formulario_trampas_validar->validarInspeccion($params)) {
            $data = array(
                'trampa' => $params['id_trampa'],
                'usuario' => $this->session->userdata('id'),
                'fecha' => $date,
                'hallazgo' => $params['hallazgo_inspeccion'],
                'cantidad' => $params['cantidad_inspeccion'],
                'observaciones' => $params['observaciones_inspeccion']
            );

            if ($this->_trampas_model->guardarInspeccion($data)) {

                $arr_inspecciones = array();
                $inspecciones = $this->_trampas_model->getInspeccionesTrampa($params["id_trampa"]);
                if($inspecciones){
                    foreach($inspecciones as $inspeccion){
                        $arr_inspecciones['inspecciones'][] = $inspeccion;
                    }
                }

                $grilla = $this->load->view('pages/trampas/grilla_inspecciones', $arr_inspecciones, true);
                echo json_encode(
                    array(
                        "error" => array(),
                        "correcto" => true,
                        "grilla" => $grilla
                    )
                );
            }else{
                echo json_encode(
                    array(
                        "error" => array(),
                        "correcto" => true
                    )
                );
            }

        } else {
            echo json_encode(
                array(
                    "error" => $this->formulario_trampas_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }


}