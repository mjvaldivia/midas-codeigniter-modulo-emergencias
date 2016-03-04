<?php

require_once(__DIR__ . "/Categorias.php");

/**
 * 
 */
Class Visor_Menu_CategoriasRegion extends Visor_Menu_Categorias{
    
    /**
     *
     * @var int 
     */
    protected $_id_region;
    
    /**
     * Constructor
     */
    public function __construct($id_region) {
        $this->_id_region = $id_region;
        $this->_ci =& get_instance();
        $this->_ci->load->model("categoria_cobertura_model", "_categoria_cobertura_model");
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        $lista_categorias = $this->_ci->_categoria_cobertura_model->listar();
        return $this->_ci->load->view("pages/visor/menu/capas-categorias", 
                                        array(
                                            "lista" => $lista_categorias,
                                            "id_region" => $this->_id_region
                                        )
                                     );
    }
}

