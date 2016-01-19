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
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        $this->load->library("cache");
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
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
    
    
    public function pdf(){
        ini_set('memory_limit', '64M');
        
        $this->load->helper(array("modulo/usuario/usuario", 
                                  "modulo/emergencia/emergencia",
                                  "modulo/emergencia/emergencia_reporte"));
        
        $this->load->model("emergencia_model", "EmergenciaModel");
        $this->load->model("usuario_model", "usuario_model");
        
        $params = $this->uri->uri_to_assoc();
  
        $emergencia = $this->EmergenciaModel->getById($params["id"]);
        if(!is_null($emergencia)){
                        
            $data = array("eme_ia_id" => $emergencia->eme_ia_id,
                          "eme_c_nombre_emergencia" => $emergencia->eme_c_nombre_emergencia,
                          "eme_d_fecha_emergencia"  => ISODateTospanish($emergencia->eme_d_fecha_emergencia),
                          "hora_emergencia" => ISOTimeTospanish($emergencia->eme_d_fecha_emergencia),
                          "hora_recepcion"  => ISOTimeTospanish($emergencia->eme_d_fecha_recepcion),
                          "eme_c_lugar_emergencia" => $emergencia->eme_c_lugar_emergencia,
                          "emisor" => $this->session->userdata('session_nombres'),
                          "id_usuario_encargado" => $emergencia->usu_ia_id,
                          "eme_c_observacion"    => $emergencia->eme_c_observacion);
        }

        $html = $this->load->view('pages/emergencia_reporte/pdf', $data, true); 
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        
        $cache = Cache::iniciar();

        $pdf->imagen_mapa = $cache->load($params["hash"]);
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
        $pdf->WriteHTML($html);
        $pdf->Output('acta.pdf', 'I');
    }
    
    /**
     * 
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
