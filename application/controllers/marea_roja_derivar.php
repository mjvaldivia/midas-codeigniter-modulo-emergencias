<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once(__DIR__ . "/marea_roja_resultado.php");

class Marea_roja_derivar extends Marea_roja_resultado
{
    /**
     *
     */
    public function index()
    {
        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/base.js");
        $this->layout_assets->addJs("modulo/marea_roja/derivar/index.js");
        $this->layout_template->view(
            "default", 
            "pages/marea_roja/derivar/index", 
            array()
        );
    }
    
    /**
     * Guarda el resultado
     */
    public function guardar(){
        
        $this->load->library(
            array(
                "rut", 
                "marea_roja/marea_roja_derivar_validar"
            )
        );
        
        $params = $this->input->post(null, true);

        
        if ($this->marea_roja_derivar_validar->esValido($params)) {
            $caso = $this->_marea_roja_model->getById($params["id"]);
            if (!is_null($caso)) {

                $this->_marea_roja_model->update(
                    array(
                          "id_laboratorio" => $params["laboratorio"],
                        "tipo_analisis" => implode(',',$params['analisis'])
                    ), 
                    $caso->id
                );
                
                echo json_encode(
                    array(
                        "error" => $this->marea_roja_derivar_validar->getErrores(),
                        "correcto" => true
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "error" => $this->marea_roja_derivar_validar->getErrores(),
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

        $lista_laboratorios = $this->_filtrosLaboratorio();
        if(!is_null($lista_laboratorios)){
            return $this->_marea_roja_model->listar(
                array(
                    "laboratorio" => $lista_laboratorios,
                    "ingreso_resultado" => 0,
                    "numero_muestra" => $params["muestra"]
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
        $this->load->helper("modulo/laboratorio/form");
        $this->load->view("pages/marea_roja/derivar/form", $data);
    }
}

