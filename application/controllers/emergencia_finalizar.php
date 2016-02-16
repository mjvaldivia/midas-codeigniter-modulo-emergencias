<?php

Class Emergencia_finalizar extends MY_Controller {
    
    /**
    *
    * @var Emergencia_Model 
    */
    public $emergencia_model;
    
    /**
    *
    * @var Emergencia_Estado_Model 
    */
    public $emergencia_estado_model;
    
    /**
     *
     * @var Validar 
     */
    public $validar;
    
    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("emergencia_model", "emergencia_model");
        $this->load->model("emergencia_estado_model", "emergencia_estado_model");
        
        $this->load->library(
            array(
                "evento/evento_historial"
            )
        );
        
        sessionValidation();
    }
    
    /**
     * Despliega formulario para cerrar emergencia
     */
    public function form()
    {
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $data = array("id" => $emergencia->eme_ia_id,
                          "nombre" => $emergencia->eme_c_nombre_emergencia,
                          "fecha" => Date("d-m-Y h:i"));
            
            $this->load->view("pages/emergencia_finalizar/form", $data);
        } else {
            show_404();
        }
    }
    
    /**
     * Finaliza una emergencia
     */
    public function save(){
        $this->load->library("validar");
        $correcto = true;
        $error = array();
        
        $params = $this->input->post(null, true);
        $emergencia = $this->emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            if(!$this->validar->validarFechaSpanish($params["fecha_cierre"])){
                $correcto = false;
                $error["fecha-cierre"] = "Debe ingresar una fecha";
            } else {
                $error["fecha-cierre"] = "";
            }
            
            if(!$this->validar->validarVacio($params["comentarios_cierre"])){
                $correcto = false;
                $error["comentarios_cierre"] = "Debe ingresar los comentarios";
            } else {
                $error["comentarios_cierre"] = "";
            }

            if($correcto){
                $data = array("est_ia_id" => Emergencia_Estado_Model::FINALIZADA,
                              "eme_d_fecha_cierre" => spanishDateToISO($params["fecha_cierre"]),
                              "eme_c_comentario_cierre" => $params["comentarios_cierre"]);
                $this->emergencia_model->query()->update($data, "eme_ia_id",  $emergencia->eme_ia_id);
                
                
                Evento_historial::putHistorial(
                    $emergencia->eme_ia_id, 
                    'La emergencia ha sido finalizada: ' . $params["comentarios_cierre"]
                );
                
            }
            
            $respuesta = array("correcto" => $correcto,
                               "error" => $error);
            
            echo json_encode($respuesta);
        } else {
            show_404();
        }
    }
}

