<?php

function mareaRojaLaboratorioMuestra($id_laboratorio){
    $_ci =& get_instance();
    $_ci->load->helper("modulo/laboratorio/form");
    $_ci->load->model("region_model");
    $_ci->load->model("usuario_region_model","_usuario_region_model");
    $lista_regiones = $_ci->_usuario_region_model->listarRegionPorUsuario(
        $_ci->session->userdata('session_idUsuario')
    );
    
    $ok = false;
    foreach($lista_regiones as $region){
        if(in_array($region["id_region"], array(Region_Model::LOS_LAGOS))){
            $ok = true;
            //break;
        }
    }
    
    if($ok){
        return "<div class=\"form-group clearfix\">"
                    ."<label for=\"laboratorio\" class=\"control-label\">Laboratorio (*):</label>"
                    .formSelectLaboratorio("laboratorio", array("class" => "form-control"), $id_laboratorio)
                    ."<span class=\"help-block hidden\"></span>"
                ."</div>";
    }
}

