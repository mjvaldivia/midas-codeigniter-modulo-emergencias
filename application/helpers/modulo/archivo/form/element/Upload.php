<?php

Class Archivo_Form_Element_Upload{
    
    /**
     * Lista de archivos cargados
     * @var array array("id");
     */
    protected $_archivos;
    
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
        $this->_ci->load->helper("modulo/archivo/archivo");
        $this->_ci->load->model("archivo_model", "_archivo_model");
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setArchivos($lista){

        if(count($lista)>0){
            foreach($lista as $key => $id){
                $archivo = $this->_ci->_archivo_model->getById($id);
                $this->_archivos[] = array(
                    "id" => $archivo->arch_ia_id,
                    "nombre" => $archivo->arch_c_nombre,
                    "tipo" => $archivo->arch_c_tipo,
                    "descripcion" => $archivo->arch_c_descripcion,
                    "hash" => $archivo->arch_c_hash
                );
            }
        }
    }
    
    /**
     * 
     * @return type
     */
    public function render(){
        return $this->_ci->load->view(
            "pages/evento/form/element-archivos", 
            array("lista_archivos" => $this->_archivos), 
            true);
    }

}

