<?php

Class Evento_form_frontend{
    
    /**
     *
     * @var  
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    /**
     * Agrega clases para el frontend del formulario
     */
    public function AddFrontend(){
        $this->_ci->layout_assets->addJs("modulo/mapa/formulario.js")
                                 ->addJs("modulo/evento/form/nuevo.js")
                                 ->addJs("modulo/evento/form/editar.js")
                                 ->addJs("modulo/evento/form/finalizar.js");
    }
}

