<?php

Class Emergencia_pdf{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Emergencia_Model 
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var string imagen en binario 
     */
    protected $_imagen = "";
    
    /**
     *
     * @var Cache 
     */
    protected $_cache;
    
    /**
     *
     * @var pdf 
     */
    protected $_pdf;
    
    /**
    * Constructor
    */
    public function __construct() {
        ini_set('memory_limit', '64M');
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_model");
        $this->_ci->load->library(array("cache", "pdf"));
        
        $this->_ci->load->helper(array("session",
                                       "modulo/usuario/usuario", 
                                       "modulo/emergencia/emergencia",
                                       "modulo/emergencia/emergencia_reporte"));
        $this->_cache = Cache::iniciar();

        $this->_pdf   = $this->_ci->pdf->load();
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function generar($id_emergencia,$mapa=true){
        $emergencia = $this->_ci->emergencia_model->getById($id_emergencia);
        if(!is_null($emergencia)){    
            $data = array("eme_ia_id" => $emergencia->eme_ia_id,
                          "eme_c_nombre_emergencia" => $emergencia->eme_c_nombre_emergencia,
                            "eme_c_nombre_informante" => $emergencia->eme_c_nombre_informante,
                          "eme_d_fecha_emergencia"  => ISODateTospanish($emergencia->eme_d_fecha_emergencia,false),
                          "hora_emergencia" => ISOTimeTospanish($emergencia->eme_d_fecha_emergencia),
                          "hora_recepcion"  => ISOTimeTospanish($emergencia->eme_d_fecha_recepcion),
                          "eme_c_lugar_emergencia" => $emergencia->eme_c_lugar_emergencia,
                          "emisor"               => $this->_ci->session->userdata('session_nombres'),
                          "id_usuario_encargado" => $emergencia->usu_ia_id,
                          "eme_c_descripcion"    => $emergencia->eme_c_descripcion,
                            "est_ia_id" => $emergencia->est_ia_id,
                            "tip_ia_id" => $emergencia->tip_ia_id);

            $datos = unserialize($emergencia->eme_c_datos_tipo_emergencia);
            foreach($datos as $key => $value){
                $data['form_tipo_'.$key] = $value;
            }

        }

        $data['region'] = '';
        $regiones = explode(',',$this->_ci->session->userdata('session_regiones'));
        if(count($regiones) == 1){
            if($regiones[0] == 13)
                $data['region'] = 'RM';
            else
                $data['region'] = $regiones[0].'º';
        }

        $data['cargo'] = $this->_ci->session->userdata('session_cargo');
        $data['mapa'] = $mapa;
        $html = $this->_ci->load->view('pages/emergencia_reporte/pdf', $data, true); 

        $this->_pdf->imagen_mapa = $this->_imagen;
        $this->_pdf->imagen_logo = file_get_contents(FCPATH . "/assets/img/top_logo.png");
        $this->_pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y H:i'));
        $this->_pdf->WriteHTML($html);
        return $this->_pdf->Output('acta.pdf', 'S');

    }
    
    /**
     * 
     * @param string $hash
     */
    public function setHashImagen($hash){
        $this->_imagen = $this->_cache->load($hash);
    }
    
}
