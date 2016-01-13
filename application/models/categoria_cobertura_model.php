<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_Cobertura_Model extends MY_Model {


    public $PUNTO = 1;
    public $LINEA = 2;
    public $POLIGONO = 3;

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


    public function getById($id){
        $query = "select * from categorias_capas_coberturas where ccb_ia_categoria = ? limit 1";
        $resultado = $this->db->query($query,array($id));
        if($resultado->num_rows > 0){
            $resultado = $resultado->result_array();
            return $resultado[0];
        }else{
            return null;
        }


    }
}