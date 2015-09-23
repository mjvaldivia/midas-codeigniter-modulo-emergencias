<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 09-09-15
 * Time: 03:05 PM
 */
class Instalacion extends CI_Controller {

    public function obtenerJsonDtTipos() {
        $this->load->helper("session");

        sessionValidation();

        $this->load->model("tipo_instalacion_model", "TipoInstalacion");

        $tipos = $this->TipoInstalacion->obtenerTodos();
        $retorno = array();

        foreach($tipos as $t) {
            $retorno[] = array(
                "DT_RowId" => "DTRow_TipIns_" . $t["aux_ia_id"],
                "aux_ia_id" => $t["aux_ia_id"],
                "aux_c_nombre" => $t["aux_c_nombre"],
                "amb_c_nombre" => $t["amb_c_nombre"]
            );
        }

        echo json_encode(array("data" => $retorno));
    }

    public function obtenerJsonInsSegunTipIns() {
        $this->load->helper("session");

        sessionValidation();

        $this->load->model("instalacion_model", "InstalacionModel");
        $params = $this->input->post(null, true);

        $coords = $this->InstalacionModel->obtenerInsSegunTipIns($params);

        echo json_encode($coords);
    }
}