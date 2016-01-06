<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_Cobertura_Model extends MY_Model {

    public function obtenerTodos() {
        $sql = "
        select
            cc.*
           
        from
            categorias_capas_coberturas cc 
        ";
        
        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
}