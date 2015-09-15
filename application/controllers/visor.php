<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 26-08-15
 * Time: 14:04 PM
 */
class Visor extends CI_Controller
{
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

    public function subirKML() {
        // load basicos
        $this->load->helper(array("session", "debug"));

        sessionValidation();

        if (!array_key_exists("input-kml", $_FILES)){
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
    
    public function getReporte($id_emergencia = null){
            ini_set('memory_limit','32M');
   // $html = $this->load->view('pdf_report', $data, true); // render the view into HTML
     
    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date()); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
    $pdf->WriteHTML('blablabal'); // write the HTML into the PDF
    $pdf->Output('acta.pdf', 'I');
    }
}