<?php

Class Archivo_cache{
    
    /**
     * hash del cache
     * @var string 
     */
    protected $_hash = null;
    
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
        
        $this->_ci->load->library(
            array(
                "core/string/random", 
                "core/zend/cache"
            )
        );
    }
    
    /**
     * Pasa el archivo cache
     * @param string $ubicacion
     * @param string $nombre
     * @return string hash del cache
     */
    public function cache($ubicacion, $nombre = null){
        
        $this->_hash = null;
        
        $cache = $this->_ci->cache->iniciar();
        
        while(is_null($this->_hash)){
            $this->_hash = $this->_ci->random->rand_string(20) . time();
            if($existe = $cache->load($this->_hash)){
                $this->_hash = null;
            }
        }
        
        if(is_null($nombre)){
            $nombre = basename($ubicacion);
        }
        
        $cache->save(
            array(
                "archivo" => file_get_contents($ubicacion),
                "archivo_nombre" => $nombre,
                "mime" => mime_content_type($ubicacion),
                "tipo" => pathinfo($ubicacion, PATHINFO_EXTENSION)
            ) , 
            $this->_hash
        );
        
        return $this->_hash;
    }
}

