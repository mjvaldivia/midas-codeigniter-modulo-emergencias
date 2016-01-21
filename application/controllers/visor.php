<?php

class Visor extends MY_Controller 
{
    
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
}