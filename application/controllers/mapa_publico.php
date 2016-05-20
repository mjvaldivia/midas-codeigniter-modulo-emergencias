<?php

require_once(__DIR__ . "/mapa.php");

/**
 * 
 */
class Mapa_publico extends Mapa {
        
    /**
     * Carga de mapa publico
     * @throws Exception
     */
    public function index(){
        $this->load->helper("modulo/visor/visor");
        $params = $this->uri->uri_to_assoc();
        
        $emergencia = $this->_emergencia_model->getByHash($params["evento"]);

        $this->load->model('Permiso_Model','PermisoModel');
        $this->load->model('Modulo_Model','ModuloModel');
        $guardar = false;
        
        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                          "guardar" => $guardar,
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));

            $this->load->view("pages/mapa_publico/index", $data);

        } else {
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
    
    /**
     * Se quitan marcadores de marea roja
     */
    public function info_marea_roja(){

        header('Content-type: application/json'); 

        echo Zend_Json::encode(
            array(
                "correcto" => true,
                "lista" => array()
            )
        );
    }
    
    /**
     * No se verifica que el usuario este logeado
     */
    protected function _validarSession(){
       // sessionValidation();
    }
}

