<?php

Class Emergencia_reporte extends MY_Controller {
    
    /**
    *
    * @var Emergencia_Model 
    */
    public $_emergencia_model;
    
    /**
     *
     * @var Cache 
     */
    public $cache;
    
    /**
     *
     * @var Emergencia_pdf 
     */
    public $emergencia_pdf;
        
    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        $this->load->library(array("cache", "emergencia/emergencia_pdf"));
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    /**
     * 
     */
    public function index(){
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                          "nombre" => strtoupper($emergencia->eme_c_nombre_emergencia),
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));
            $this->load->view("pages/emergencia_reporte/index.php", $data);
        }
    }
    
    /**
     * 
     */
    public function pdf(){
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline;filename=reporte.pdf"); 
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public'); 
        
        $params = $this->uri->uri_to_assoc();
        $this->emergencia_pdf->setHashImagen($params["hash"]);
        echo $this->emergencia_pdf->generar($params["id"]);
    }
    
    /**
     * Guarda la imagen del mapa de forma temporal
     */
    public function ajax_mapa_imagen(){
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $img = base64_decode($params["imagen"]);
        
        $cache = Cache::iniciar();
        $hash =  uniqid() . time();
       
        $cache->save($img, $hash);
        
        $respuesta = array("correcto" => true,
                           "hash" => $hash);
        
        echo json_encode($respuesta);
    }
}
