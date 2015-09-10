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
        $this->load->helper(array("session", "debug"));

        sessionValidation();

        $data = array();
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

        // <?php
        // header("Content-type: application/vnd.google-earth.kml+xml");
        // header("Content-Disposition: attachment; filename=\"test.kml\"\n");

        // readfile("test.kml");

    }
}