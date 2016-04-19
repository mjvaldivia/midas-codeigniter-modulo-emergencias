<?php

Class Visor_Menu_Categorias{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     * Constructor
     */
    public function __construct($id_emergencia) {
        $this->_id_emergencia = $id_emergencia;
        $this->_ci =& get_instance();
        $this->_ci->load->model("categoria_cobertura_model", "_categoria_cobertura_model");
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        $lista_categorias = $this->_ci->_categoria_cobertura_model->listar();
        return $this->_ci->load->view("pages/mapa/menu/capas-categorias", 
                                        array(
                                            "lista" => $lista_categorias,
                                            "id_emergencia" => $this->_id_emergencia
                                        )
                                     );
    }
}

