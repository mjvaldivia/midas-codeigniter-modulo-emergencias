<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");
/**
 * User: claudio
 * Date: 15-09-15
 * Time: 10:55 AM
 */


class Capas extends CI_Controller
{
    public function index() {
        if (!file_exists(APPPATH . "/views/pages/capa/index.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        $data = array();

        $this->template->parse("default", "pages/capa/index", $data);
    }

    public function ingreso() {
        if (!file_exists(APPPATH . "/views/pages/capa/ingreso.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        $data = array(
            "editar" => false
        );

        $this->template->parse("default", "pages/capa/ingreso", $data);
    }
    
    
}