<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visor extends CI_Controller {

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
        $this->load->model("archivo_model", "ArchivoModel");
        ini_set('memory_limit', '32M');
        $this->load->model("emergencia_model", "EmergenciaModel");
        $params = $this->uri->uri_to_assoc();
        //var_dump($params);
        $data = $this->EmergenciaModel->getJsonEmergencia($params, false);

        $archivo = $this->ArchivoModel->get_file_from_key($params['k']);
        $data['imagename'] = $archivo['arch_c_nombre'];
        //var_dump($data);die;
        $html = $this->load->view('pages/emergencia/reporteEmergencia', $data, true); // render the view into HTML
echo  ($html);die;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y')); 
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output('acta.pdf', 'I');
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

        foreach ($CategoriaCobertura as $c)
            $json[] = array(
                $c["ccb_ia_categoria"],
                $c["ccb_c_categoria"]
            );

        echo json_encode($json);
    }

    public function obtenerCapasDT() {
        $this->load->model("capa_model", "CapaModel");
        $params = $this->uri->uri_to_assoc();
        //var_dump($params);die;
        $Coberturas = $this->CapaModel->obtenerTodos($params['id']);
        return json_encode($Coberturas);
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

    public function getMapImage() {
        $params = $this->input->post();
        $name = 'img_report_' . $params['eme_ia_id'] . uniqid();
        $tmp_name = 'media/tmp/' . $name . '.png';
        $data = $params['str'];
        $bin = base64_decode($data);
        
       // var_dump($data === base64_encode(base64_decode($data)));
        
        fopen($tmp_name, 'w');
        //var_dump($bin);
        
       

$img = imagecreatefromstring($bin);

if($img) {
    imagepng($img, $tmp_name, 0);
    imagedestroy($img);
}

        
        
        
        
        
        
      //  file_put_contents($tmp_name, $bin);


        $this->load->model("archivo_model", "ArchivoModel");
        $resp = $this->ArchivoModel->upload_to_site($name, 'image/png', $tmp_name, $params['eme_ia_id'], $this->ArchivoModel->TIPO_MAPA_REPORTE, filesize($tmp_name));
        if (json_decode($resp)->error == 0) {
            echo json_encode(array('k' => json_decode($resp)->k));
        } else {
            echo json_encode(array('k' => 0));
        }
    }

}
