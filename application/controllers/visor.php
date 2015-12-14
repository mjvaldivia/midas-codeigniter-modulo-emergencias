<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visor extends MY_Controller {

    /**
     *
     * @var Capa_Model 
     */
    public $capa_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model; 
     */
    public $emergencia_comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("capa_model", "capa_model");
        $this->load->model("emergencia_comuna_model", "emergencia_comuna_model");
    }
    
    public function index() {
        // load basicos
        $this->load->library("template");
        $this->load->helper(array("session", "debug", "utils"));

        sessionValidation();
        $params = $this->uri->uri_to_assoc();

        if (!array_key_exists("id", $params)) {
            redirect("emergencias/listado");
        }

        $this->load->model("emergencia_model", "EmergenciaModel");
        $emergencia = $this->EmergenciaModel->getEmergencia($params["id"]);

        $data = array(
            "emergencia" => $emergencia
        );
        $this->template->parse("visor", "pages/visor/visor", $data);
    }

    public function obtenerJsonEmergenciaVisor() {
        $params = $this->uri->uri_to_assoc();

        $this->load->helper("session");

        sessionValidation();

        $this->load->model("archivo_model", "ArchivoModel");
        $this->load->model("visor_model", "VisorModel");
        $this->load->model("emergencia_model", "EmergenciaModel");

        $retorno = array();

        $retorno["geojson"] = $this->ArchivoModel->loadGeoJson($params);
        $retorno["geojson"] = empty($retorno["geojson"]) ? $retorno["geojson"] : base_url($retorno["geojson"]["arch_c_nombre"]);
        $retorno["coordinates"] = $this->VisorModel->obtenerLimitesVisor($params);
        $retorno["facilities"] = $this->VisorModel->obtenerTipInsGuardados($params);
        $retorno["capas"] = $this->EmergenciaModel->obtenerCapas($params);
        $retorno["referencia"] = $this->EmergenciaModel->get_JsonReferencia($params['id']);


        echo json_encode($retorno);
    }

    public function obtenerJsonInsSegunTipIns() {
        $this->load->helper("session");

        sessionValidation();

        $this->load->model("instalacion_model", "InstalacionModel");
        $this->load->model("visor_model", "VisorModel");
        $params = $this->input->post(null, true);

        $coords = $this->InstalacionModel->obtenerInsSegunTipIns($params);
        $this->VisorModel->guardarEstadoTipoIns($params);

        echo json_encode($coords);
    }

    public function subirKML() {
        // load basicos
        $this->load->helper(array("session", "debug"));

        sessionValidation();

        if (!array_key_exists("input-kml", $_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        // dump($_FILES);

        foreach ($_FILES as $llave => $valor) {
            // no dejamos subir cualquier formato
            if ($valor["type"][0] != "application/vnd.google-earth.kml+xml")
                continue;

            move_uploaded_file($valor["tmp_name"][0], APPPATH . "../KML/test.kml");
        }

        echo json_encode(array("uploaded" => true));
    }

    public function getReporte() {
        $this->load->library("template");
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("archivo_model", "ArchivoModel");
        ini_set('memory_limit', '64M');
        $this->load->model("emergencia_model", "EmergenciaModel");
        $params = $this->uri->uri_to_assoc();
        //var_dump($params);
        $data = $this->EmergenciaModel->getJsonEmergencia($params, false);

        $data['emisor'] = $this->session->userdata('session_nombres');

        $archivo = $this->ArchivoModel->get_file_from_key($params['k']);
        $data['imagename'] = $archivo['arch_c_nombre'];
        //var_dump($data);die;
        $html = $this->load->view('pages/emergencia/reporteEmergencia', $data, true); // render the view into HTML
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output('acta.pdf', 'I');
    }

    public function ReporteAdisco() {
        $this->load->model("emergencia_model", "EmergenciaModel");
        $this->load->model("archivo_model", "ArchivoModel");
        ini_set('memory_limit', '64M');
        $ruta = false;
        $params_get = $this->uri->uri_to_assoc();
        $data = $this->EmergenciaModel->getJsonEmergencia($params_get, false);
        $data['emisor'] = $this->session->userdata('session_nombres');
        $archivo = $this->ArchivoModel->get_file_from_key($params_get['k']);
        $data['imagename'] = $archivo['arch_c_nombre'];
        $html = $this->load->view('pages/emergencia/reporteEmergencia', $data, true); // render the view into HTML
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));

        $pdf->WriteHTML($html); // write the HTML into the PDF
        $filename = 'reporte_' . uniqid() . '.pdf';

        $pdf->Output('media/tmp/' . $filename, 'F');
        if (!is_file('media/tmp/' . $filename)) {
            $ruta = false;
        } else {
            $ruta = 'media/tmp/' . $filename;
        }
        return $ruta;
    }

    //manda mail desde el listado de emergencias , puede adjuntar reporte
    public function enviarMail() {
        $error = 0;
        $this->load->model("archivo_model", "ArchivoModel");
        $this->load->model("Sendmail_Model", "SendmailModel");
        $cc = null;
        $attach = array();
        $this->load->library("template");
        $this->load->helper("session");
        sessionValidation();
        $params_post = $this->input->post();
        if (isset($params_post['adj_reporte'])) {
            if ($ruta = $this->ReporteAdisco()) {
                array_push($attach, $ruta);
            } else {
                $error++;
            }
        }

        foreach ($params_post as $key => $val) { //reviso los que han sido chequeados para enviarse como adjuntos
            if (strpos($key, 'chk_') !== false) {

                $id = explode('_', $key);
                $id = $id[1];

                $arch = $this->ArchivoModel->get_file_from_id($id);
                if ($arch !== null) {
                    array_push($attach, $arch['arch_c_nombre']);
                }
            }
        }


        $to = $params_post['destino'];
        $subject = $params_post['asunto'];
        $message = $params_post['mensaje'];



        if (isset($params_post['con_copia'])) {
            $cc = $this->session->userdata('session_email');
        }
        //var_dump($cc);die;
        if (!$this->SendmailModel->emailSend($to, $cc, null, $subject, $message, false, $attach)) {
            $error++;
        }
        echo $error;
    }

    public function saveGeoJson() {

        $this->load->library("template");
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("archivo_model", "ArchivoModel");
        $id = $this->input->post('id');
        $geoJson = $this->input->post('geoJson');
        $lista_capas = $this->input->post('lista');
        echo $this->ArchivoModel->setTemporaryGeoJson($id, $geoJson, $lista_capas);
    }

    public function guardarCapa() {
        fb("guardar capa");
        $this->load->helper("session");
        sessionValidation();
        $params = $this->input->post();

        $this->load->helper("session");
        $this->load->model("capa_model", "CapaModel");
        echo $this->CapaModel->guardarCapa($params);
    }

    public function obtenerJsonCatCoberturas() {
        $this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $json = array();

        foreach ($CategoriaCobertura as $c) {
            $json[] = array(
                $c["ccb_ia_categoria"],
                $c["ccb_c_categoria"]
            );
        }

        echo json_encode($json);
    }

    public function obtenerCapasDT() {
        $this->load->helper(array("modulo/capa/capa"));
        $params = $this->uri->uri_to_assoc();
        
        $lista_comunas = array();
        $lista_comunas_emergencia = $this->emergencia_comuna_model->listaComunasPorEmergencia($params['eme_ia_id']);
        if(count($lista_comunas_emergencia)>0){
            foreach($lista_comunas_emergencia as $comuna){
                $lista_comunas[] = $comuna["com_ia_id"];
            }
        }
        
        $lista_capas = $this->capa_model->listarCapasPorComunas($lista_comunas);
        
        $retorno = array();
        if(!is_null($lista_capas)){
            $retorno["correcto"] = true;
            $retorno["html"] = $this->load->view("pages/visor/seleccion_capas", array("lista_capas" => $lista_capas), true);
        } else {
            $retorno["correcto"] = false;
        }
        echo json_encode($retorno);
    }

    public function get_json_capa() {
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $params = $this->uri->uri_to_assoc();
        return $this->CapaModel->getjson($params['id']);
    }

    public function loadExportMap() {
        $this->load->library("template");
        $params = $this->uri->uri_to_assoc();
        $data = array('id' => $params['id']);

        $this->template->parse("alone", "pages/visor/exportMap", $data);
    }

    public function reporte() {
        $this->load->helper("session");
        sessionValidation();
        $this->load->library("template");
        $params = $this->uri->uri_to_assoc();

        $this->load->model("sendmail_model", "SendmailModel");
        $this->load->model("emergencia_model", "EmergenciaModel");
        $eme = $this->EmergenciaModel->getEmergencia($params['eme_ia_id']);


        $lista = $this->SendmailModel->get_destinatariosCorreo($eme['tip_ia_id'], $eme['comunas'], $this->session->userdata('session_idUsuario'));
      //  var_dump($eme);var_dump($lista);
        $data = array(  'id' => $params['id'],
                        'ala_ia_id' => $params['ala_ia_id'],
                        'lista' => $lista,
                        'nombre_emergencia' =>$eme['eme_c_nombre_emergencia']
                );
        $this->template->parse("alone", "pages/visor/modal_reporte", $data);
    }

    public function getMapImage() {
        $params = $this->input->post();
        $name = 'img_report_' . $params['eme_ia_id'] . uniqid();
        $tmp_name = 'media/tmp/' . $name . '.png';
        $data = $params['str'];
        $bin = base64_decode($data);
        $img = imagecreatefromstring($bin);

        fopen($tmp_name, 'w');
        imagepng($img, $tmp_name, 0);
        imagedestroy($img);

        $this->load->model("archivo_model", "ArchivoModel");
        $resp = $this->ArchivoModel->upload_to_site($name, 'image/png', $tmp_name, $params['eme_ia_id'], $this->ArchivoModel->TIPO_MAPA_REPORTE, filesize($tmp_name));
        if (json_decode($resp)->error == 0) {
            echo json_encode(array('k' => json_decode($resp)->k));
        } else {
            echo json_encode(array('k' => 0));
        }
    }

    public function getmails() {
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("usuario_model", "UsuarioModel");
        echo $this->UsuarioModel->get_mails($this->session->userdata('session_region_codigo'));
    }

}
