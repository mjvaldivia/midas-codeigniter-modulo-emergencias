<?php

Class Visor_Menu_Categorias_CantidadCapas{
     /**
     *
     * @var CI_Controller
     */
    protected $_ci;
 
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_model", "_capa_model");
    }
    
    /**
     * 
     * @param int $id_categoria
     * @return int
     */
    public function cantidad($id_categoria){
        return $this->_ci->_capa_model->cantidadCapasPorCategoria($id_categoria);
    }
}

