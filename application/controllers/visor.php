<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 26-08-15
 * Time: 14:04 PM
 */
class Visor extends CI_Controller
{
    public function index()
    {
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

        $retorno = array();

        $retorno["geojson"] = $this->ArchivoModel->loadGeoJson($params);
        $retorno["geojson"] = empty($retorno["geojson"]) ? $retorno["geojson"] : base_url($retorno["geojson"]["arch_c_nombre"]);
        $retorno["coordinates"] = $this->VisorModel->obtenerLimitesVisor($params);
        $retorno["facilities"] = $this->VisorModel->obtenerTipInsGuardados($params);

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

    public function subirKML()
    {
        // load basicos
        $this->load->helper(array("session", "debug"));

        sessionValidation();

        if (!array_key_exists("input-kml", $_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        // dump($_FILES);

        foreach ($_FILES as $llave => $valor) {
            // no dejamos subir cualquier formato
            if ($valor["type"][0] != "application/vnd.google-earth.kml+xml") continue;

            move_uploaded_file($valor["tmp_name"][0], APPPATH . "../KML/test.kml");
        }

        echo json_encode(array("uploaded" => true));
    }


    public function getReporte()
    {
        $this->load->library("template");
        $this->load->helper("session");
        
        ini_set('memory_limit', '32M');
        $this->load->model("emergencia_model", "EmergenciaModel");
        $params = $this->uri->uri_to_assoc();
        //var_dump($params);
        $data = $this->EmergenciaModel->getJsonEmergencia($params, false);
        //var_dump($data);die;
        $html = $this->load->view('pages/emergencia/reporteEmergencia', $data, true); // render the view into HTML
        //print_r($html);die;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y')); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output('acta.pdf', 'I');

    }
    
    public function saveGeoJson(){
        
        $this->load->library("template");
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("archivo_model", "ArchivoModel");
        $id = $this->input->post('id');
        $geoJson = $this->input->post('geoJson');
        return $this->ArchivoModel->setTemporaryGeoJson($id,$geoJson);
        
        
    }
    
    public function guardarCapa(){
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

        foreach($CategoriaCobertura as $c)
            $json[] = array(
                $c["ccb_ia_categoria"],
                $c["ccb_c_categoria"]
            );

        echo json_encode($json);
    }
    public function obtenerCapasDT() {
        $this->load->model("capa_model", "CapaModel");

        $Coberturas= $this->CapaModel->obtenerTodos();

       

        return json_encode($Coberturas);
    }
    public function get_json_capa() {
        $this->load->helper("session");
        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $params = $this->uri->uri_to_assoc();
        return $this->CapaModel->getjson($params['id']);
    }
    
    
}