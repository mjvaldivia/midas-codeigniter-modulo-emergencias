<?php

Class Archivo_Url_Link{
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
        $this->_ci->load->model("_archivo_model");
    }
    
    /**
     * Retorna URL de un archivo
     * @param int $id_archivo
     * @return string
     */
    public function url($id_archivo){
        $archivo = $this->_ci->_archivo_model->getById($id_archivo);
        if(!is_null($archivo)){
            return "<a href=\"" .site_url("archivo/download_file/hash/" . $archivo->arch_c_hash) ."\" target=\"_blank\"><strong>".$archivo->arch_c_nombre."</strong></a>";
        } else {
            return "<a href=\"#\"> El archivo no fue encontrado </a>";
        }
    }
}

