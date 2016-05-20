<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once(__DIR__ . "/marea_roja.php");

class Marea_roja_resultado extends Marea_roja
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
        
        $this->load->helper(
            array(
                "modulo/usuario/usuario_form",
                "modulo/comuna/form"
            )
        );
    }
    
    /**
     *
     */
    public function index()
    {
        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/base.js");
        $this->layout_assets->addJs("modulo/marea_roja/resultado/index.js");
        $this->layout_template->view(
            "default", 
            "pages/marea_roja/resultado/index", 
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
                "modulo/comuna/default"
            )
        );
        $params = $this->input->post(null, true);

        $caso = $this->_marea_roja_model->getById($params["id"]);
        if (!is_null($caso)) {

            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
           
            $data = array("id" => $caso->id);
            
            foreach ($propiedades as $nombre => $valor) {
                $data["propiedades"][str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $analisis = explode(',',$caso->tipo_analisis);

            $data['analisis'] = $analisis;
            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            $this->_viewEditar($data);
        }
    }
    
    /**
     * Guarda el resultado
     */
    public function guardar(){
        
        $this->load->library(
            array(
                "rut", 
                "marea_roja/marea_roja_resultado_validar"
            )
        );
        
        $params = $this->input->post(null, true);
        if ($this->marea_roja_resultado_validar->esValido($params)) {
            $caso = $this->_marea_roja_model->getById($params["id"]);
            if (!is_null($caso)) {
                $propiedades = Zend_Json::decode($caso->propiedades);
                $propiedades["RESULTADO"] = $params["resultado"];
                $propiedades["RESULTADO FECHA"] = $params["resultado_fecha"];
                
                $this->_marea_roja_model->update(
                    array("propiedades" => Zend_Json::encode($propiedades),
                          "id_usuario_resultado" => $this->session->userdata('session_idUsuario'),
                          "bo_ingreso_resultado" => 1), 
                    $caso->id
                );
                
                echo json_encode(
                    array(
                        "error" => $this->marea_roja_resultado_validar->getErrores(),
                        "correcto" => true
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "error" => $this->marea_roja_resultado_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }
    
    /**
     * 
     * @param array $params
     * @return array
     */
    protected function _filtros($params){
        $this->load->model("usuario_laboratorio_model","_usuario_laboratorio_model");
        $this->load->model("usuario_region_model", "_usuario_region_model");
        
        $laboratorios = null;
        
        $lista_laboratorios = $this->_filtrosLaboratorio();
        if(!is_null($lista_laboratorios)){
            return $this->_marea_roja_model->listar(
                array(
                    "laboratorio" => $lista_laboratorios,
                    "numero_muestra" => $params["muestra"]
                )
            );
        } else {
            return array();
        }
    }
    
    /**
     * Filtros por laboratorio
     * @return array
     */
    protected function _filtrosLaboratorio(){
        
        $lista_laboratorios = $this->_usuario_laboratorio_model->listarPorUsuario(
            $this->session->userdata('session_idUsuario')
        );
        
        //si no tiene laboratorio asociado, se ve por region
        if(is_null($lista_laboratorios)){
            $lista_regiones = $this->_usuario_region_model->listarRegionPorUsuario(
                $this->session->userdata('session_idUsuario')
            );

            $lista_laboratorios = $this->_laboratorio_model->listar(
                array("regiones" => $this->arreglo->arrayToArray($lista_regiones, "id_region"))
            );
            
            return $this->arreglo->arrayToArray($lista_laboratorios, "id");
        } else {
            return $this->arreglo->arrayToArray($lista_laboratorios, "id_laboratorio");
        }
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
        
        $lista_laboratorios = $this->_filtrosLaboratorio();
        
        if(!is_null($lista_laboratorios)){
            return $this->_marea_roja_model->listar(
                array(
                    "laboratorio" => $this->arreglo->arrayToArray($lista_laboratorios, "id_laboratorio"),
                    "fecha_desde" => $fecha_desde, 
                    "fecha_hasta" => $fecha_hasta
                )
            );
        } else {
            return array();
        }
    }
    
     
    
    /**
     * Funcion para cambiar vista de edicion
     * @param array $data
     */
    protected function _viewEditar($data){
        $this->load->view("pages/marea_roja/resultado/form", $data);
    }
}

