<?php 

if (!defined("BASEPATH")) exit("No direct script access allowed");


class Soportes extends CI_Controller {


    function __construct(){
        parent::__construct();
        $this->load->helper(array("session","utils"));

        sessionValidation();
        $this->load->library('template');

        $this->load->model("soportes_model", "SoportesModel");

    }
    
    public function bandeja_usuario(){
        $id_usuario = $this->session->userdata['session_idUsuario'];
        $soportes = $this->SoportesModel->obtSoportesUsuario($id_usuario);
        $data = array(
            'soportes' => $soportes
            );
        $this->template->parse("default", "pages/soportes/bandeja_usuario", $data);
    }    
}