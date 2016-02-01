<?php

require_once(__DIR__ . "/../Abstract.php");

Class Visor_Menu_Categorias_CantidadCapas extends Visor_Menu_Abstract{

 
    /**
     * Constructor
     */
    public function __construct($id_emergencia) {
        parent::__construct($id_emergencia);
        $this->_ci->load->model("capa_model", "_capa_model");
    }
    
    /**
     * 
     * @param int $id_categoria
     * @return int
     */
    public function cantidad($id_categoria){
        return $this->_ci->_capa_model->cantidadCapasPorCategoria(
                $id_categoria,
                $this->_lista_emergencia_comunas,
                $this->_lista_emergencia_provincias,
                $this->_lista_emergencia_regiones
        );
    }
}

