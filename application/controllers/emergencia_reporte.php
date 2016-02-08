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
                                   "emergencia/emergencia_pdf",
                                   "emergencia/email/emergencia_email_reporte"));
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    /**
     * 
     */
    public function index(){
        $this->load->helper(array("modulo/emergencia/emergencia_form"));
        $this->load->model('alarma_model','AlarmaModel');

        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        $alarma = $this->AlarmaModel->getById($emergencia->ala_ia_id);

        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                            "lat" => $alarma->ala_c_utm_lat,
                            "lon" => $alarma->ala_c_utm_lng,
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
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){

            $this->load->model('usuario_model','UsuarioModel');
            $destinatarios = array();
            if(isset($params["adjuntar_reporte"]) && $params["adjuntar_reporte"] == 1){
                $this->emergencia_pdf->setHashImagen($params["hash"]);
                $pdf = $this->emergencia_pdf->generar($emergencia->eme_ia_id);
                $reporte = $this->emergencia_email_reporte->setReporte($pdf);
            }

            foreach($params["destinatario"] as $email){
                $this->emergencia_email_reporte->addTo($email);
                $destinatario = $this->UsuarioModel->getByEmail($email);
                $destinatarios[] = $destinatario['usu_c_nombre'].' '.$destinatario['usu_c_apellido_paterno'].' '.$destinatario['usu_c_apellido_materno'];
            }
            
            if(count($params["archivos"])>0){
                foreach($params["archivos"] as $id_archivo){
                    $this->emergencia_email_reporte->setArchivoAdjunto($id_archivo);
                }
            }
            
            $this->emergencia_email_reporte->setSubject($params["asunto"]);
            $this->emergencia_email_reporte->setMessage($params["mensaje"]);
            
            $correcto = $this->emergencia_email_reporte->send($emergencia->eme_ia_id);
            /*$dir_reporte = 'media/doc/emergencia/'.$emergencia->eme_ia_id.'/'.$reporte;*/
            $file = '';


            if(is_file($reporte)){
                $reporte_file = explode("/",$reporte);
                $nombre_reporte = end($reporte_file);
                $this->load->model('archivo_model','ArchivoModel');
                $url = 'media/doc/emergencia/'.$emergencia->eme_ia_id.'/';
                if(!is_dir($url)){
                    mkdir($url,0777,true);
                }

                $id_reporte = $this->ArchivoModel->file_to_bd($url, $nombre_reporte, 'application/pdf', $this->ArchivoModel->TIPO_EMERGENCIA, $emergencia->ala_ia_id, filesize($reporte));

                rename($reporte,'media/doc/emergencia/'.$emergencia->eme_ia_id.'/'.$id_reporte.'_'.$nombre_reporte);
                @unlink($reporte);
                $reporte = $this->ArchivoModel->getById($id_reporte);
                $nombre = explode('/',$reporte->arch_c_nombre);
                $file = '<a href="'.site_url("archivo/download_file/k/" . $reporte->arch_c_hash).'" target="_blank"><strong>'.$nombre[count($nombre)-1].'</strong></a>';

            }

            $usuario = $this->session->userdata('session_idUsuario');
            $this->load->model('alarma_historial_model','AlarmaHistorialModel');
            $historial_comentario = 'Se ha enviado el reporte '.$file.' de la emergencia a los siguientes usuarios: ' . implode(',',$destinatarios);
            $data = array(
                'historial_alerta' => $emergencia->ala_ia_id,
                'historial_usuario' => $usuario,
                'historial_fecha' => date('Y-m-d H:i:s'),
                'historial_comentario' => $historial_comentario
            );
            $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);

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
}
