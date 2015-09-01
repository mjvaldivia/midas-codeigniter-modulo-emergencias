<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 26-08-15
 * Time: 14:04 PM
 */
class Visor extends CI_Controller
{
    public function index() {
        $this->load->library("template");

        $data = array();
        $this->template->parse("visor", "pages/visor/visor", $data);
    }

    public function subirKML() {
        if (!array_key_exists("input-kml", $_FILES)){
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $this->load->helper(array("debug"));

        foreach ($_FILES as $llave => $valor) {
            move_uploaded_file($valor['tmp_name'][0], APPPATH . "../KML/test.kml");
        }

        echo json_encode(array("uploaded" => true));

        // <?php
        // header("Content-type: application/vnd.google-earth.kml+xml");
        // header("Content-Disposition: attachment; filename=\"test.kml\"\n");

        // readfile("test.kml");

    }
}