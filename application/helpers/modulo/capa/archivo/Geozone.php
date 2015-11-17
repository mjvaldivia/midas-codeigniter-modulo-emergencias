<?php

Class Capa_Archivo_Geozone{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * El archivo existe
     * @var boolean 
     */
    protected $_correcto = false;
    
    /**
     * Nombre del archivo
     * @var string 
     */
    protected $_nombre;
    
    /**
     *
     * @var string 
     */
    protected $_hash;
        
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->helper('file');
    }
    
    /**
     * 
     * @param string $path ubicacion del archivo en disco
     * @param string $hash codigo 
     */
    public function setFile($path, $hash){
        if(is_file($path)){
            $this->_correcto = true;
            $this->_nombre = basename($path);
            $this->_hash   = $hash;
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getNombre(){
        return $this->_nombre;
    }
    
    /**
     * Retorna URL para descargar archivo
     * @return string
     */
    public function getUrl(){
        if($this->_correcto){
            return "<a target='_blank' class='btn btn-xs btn-default' href=" . site_url("archivo/download_file/k/" . $this->_hash) . ">Descargar</a>";
        } else {
            return "";
        }
    }
}

