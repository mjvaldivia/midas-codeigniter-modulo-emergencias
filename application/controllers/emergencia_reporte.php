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
     *
     * @var Emergencia_email_reporte 
     */
    public $emergencia_email_reporte;
        
    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        
        $this->load->library(array("cache", 
                                   "string",
                                   "evento/evento_archivo",
                                   "evento/evento_historial",
                                   "emergencia/emergencia_pdf",
                                   "emergencia/email/emergencia_email_reporte"));
        
        $this->load->helper(array("modulo/archivo/archivo"));
        
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("archivo_tipo_model", "_archivo_tipo_model");
    }
    
    /**
     * 
     */
    public function index(){
        $this->load->helper(array("modulo/emergencia/emergencia_form"));
        //$this->load->model('alarma_model','AlarmaModel');

        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        //$alarma = $this->AlarmaModel->getById($emergencia->ala_ia_id);

        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                          "lat" => $emergencia->eme_c_utm_lat,
                          "lon" => $emergencia->eme_c_utm_lng,
                          "nombre" => strtoupper($emergencia->eme_c_nombre_emergencia),
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));
            $this->load->view("pages/emergencia_reporte/index.php", $data);
        }
    }
    
    /**
     * Despliega reporte en navegador
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
     * Envia correo con reporte
     */
    public function ajax_enviar_correo(){
        $correcto = false;
        
        $pdf = null;
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){

            $this->load->model('usuario_model','UsuarioModel');
            $destinatarios = array();
            
            //se genera el reporte
            $mapa = false;
            if(isset($params["adjuntar_reporte"]) && $params["adjuntar_reporte"] == 1){
                if(isset($params['adjuntar_mapa']) && $params['adjuntar_mapa'] == 1){
                    $this->emergencia_pdf->setHashImagen($params["hash"]);
                    $mapa = true;
                }

                $pdf = $this->emergencia_pdf->generar($emergencia->eme_ia_id,$mapa);
                $reporte = $this->emergencia_email_reporte->setReporte($pdf);
            }
            
            //se agregan destinatarios
            foreach($params["destinatario"] as $email){
                $this->emergencia_email_reporte->addTo($email);
                
                $destinatario = $this->UsuarioModel->getByEmail($email);
                if(!is_null($destinatario)){
                    $destinatarios[] = $destinatario['usu_c_nombre'].' '.$destinatario['usu_c_apellido_paterno'].' '.$destinatario['usu_c_apellido_materno'];
                } else {
                    $destinatarios[] = $email;
                }
            }

            if(isset($params['copia']) && $params['copia'] == 1){
                $this->emergencia_email_reporte->addTo($this->session->userdata('session_email'));
            }
            
            //se agregan archivos adjuntos
            if(count($params["archivos"])>0){
                foreach($params["archivos"] as $id_archivo){
                    $this->emergencia_email_reporte->setArchivoAdjunto($id_archivo);
                }
            }
            
            $this->emergencia_email_reporte->setSubject($params["asunto"]);
            $pie_mensaje = '--<p>Midas - Emergencias<br/>Ministerio de Salud - Gobierno de Chile</p>';
            $this->emergencia_email_reporte->setMessage($params["mensaje"].$pie_mensaje);
            
            $correcto = $this->emergencia_email_reporte->send($emergencia->eme_ia_id);
            
            if($correcto){
                if(!is_null($pdf)){
                    $hash = $this->_guardarReporteTemporal($pdf);
                    $this->evento_archivo->setEvento($emergencia->eme_ia_id);
                    $id_reporte = $this->evento_archivo->addArchivo($hash, $params["asunto"], Archivo_Tipo_Model::REPORTE, NULL, $this->session->userdata('session_idUsuario'));
                    $this->evento_archivo->agregarArchivosAnteriores();
                    $this->evento_archivo->guardar();
                    
                    Evento_historial::putHistorial(
                        $emergencia->eme_ia_id, 
                        'Se ha enviado el reporte ' . linkArchivo($id_reporte) . ' de la emergencia a los siguientes usuarios: ' . implode(',',$destinatarios)
                    );
                }

            }
        }
        
        $respuesta = array("correcto" => $correcto,
                           "error" => array());
        echo json_encode($respuesta);
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
    
    
    /**
     * Guarda el reporte en cache temporal
     * @param binary $file
     * @return string
     */
    protected function _guardarReporteTemporal($file){
        $hash = $this->string->rand_string(23);
        $cache = Cache::iniciar();
        $cache->save(array("archivo" => $file,
                           "archivo_nombre" => "reporte_" . date("Y-m-d H:i:s") .  ".pdf",
                           "mime" => "application/pdf",
                           "tipo" => "pdf") , 
        $hash);
        
        return $hash;
    }
}
