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
    
    public function marea_roja_exportar(){
        header('Content-type: application/json'); 
        
        $params = $this->input->post(null, true);
        
        $this->load->model("marea_roja_model", "_marea_roja_model");
        $this->load->library(
            array(
                "core/excel/excel_json",
                "core/string/arreglo",
                "core/archivo/archivo_cache"
            )
        );
        
        $this->excel_json->setColumnas(
            array(
                "REGION"  => array(
                    "tipo" => "json",
                    "valor" => "REGION",
                    "metodo" => "NOMBRE_REGION"
                ),
                "ORIGEN"  => array(
                    "tipo" => "json",
                    "valor" => "ORIGEN"
                ),
                "RECURSO" => array(
                    "tipo" => "json",
                    "valor" => "RECURSO"
                ),
                "RESULTADO" => array(
                    "tipo" => "json",
                    "valor" => "RESULTADO"
                )
            )
        );
        
        $casos = array();
        $lista_regiones = $this->_emergencia_model->listarRegionesPorEmergencia($params["id"]);
        
        $lista = $this->_marea_roja_model->listar(
            array(
                "region" => $this->arreglo->arrayToArray(
                    $lista_regiones, 
                    "reg_ia_id"
                ),
                "ingreso_resultado" => 1
            )
        );
        
        $this->excel_json->setData($lista, array("coordenadas","propiedades"));
        $excel = $this->excel_json->getExcel();
        
        echo Zend_Json::encode(array("hash" => $this->archivo_cache->cache($excel["path"], $excel["nombre"])));
        unlink($excel["path"]);
    }
    
    /**
     * No se verifica que el usuario este logeado
     */
    protected function _validarSession(){
       // sessionValidation();
    }
}

