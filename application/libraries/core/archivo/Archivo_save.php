<?php

Class Archivo_save{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var string 
     */
    protected $_nombre = "";
    
    /**
     *
     * @var string 
     */
    protected $_ruta = "";
    
    /**
     *
     * @var boolean 
     */
    protected $_valido = false;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        
        $this->_ci->load->library(
            array(
                "core/string/random", 
                "cache"
            )
        );
    }
    
    /**
     * 
     * @return boolean
     */
    public function esValido(){
        return $this->_valido;
    }
    
    /**
     * 
     * @return string
     */
    public function getNombre(){
        return $this->_nombre;
    }
    
    /**
     * 
     * @return string
     */
    public function getPath(){
        return $this->_ruta;
    }
    
    /**
     * 
     * @param string $hash
     */
    public function saveFromCache($hash, $directorios){
        $cache = $this->_ci->cache->iniciar();
        if($documento = $cache->load($hash)){
            
            $dir = "";
            foreach($directorios as $path){
                $dir .= "/" . $path;
                if(!is_dir(FCPATH . "media/doc/" . $dir)){
                    mkdir(FCPATH . "media/doc/".$dir, 0755);
                }
            }
            
            $this->_ruta = "media/doc" . $dir . "/" . $hash . "." . $documento["tipo"];
            file_put_contents(FCPATH . $this->_ruta, $documento["archivo"]);
            
            $this->_nombre = $documento["archivo_nombre"];
            
            $this->_valido = true;
        }
    }
}

