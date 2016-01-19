<?php

class Cache{
    
    protected $_duracion = 7200; //2 horas
    
    /**
     * 
     * @return \Zend_Cache
     */
    public static function iniciar(){
        $cache = New Cache();
        return $cache->_iniciar();
    }
    
    /**
     * 
     * @return \Zend_Cache
     */
    public function _iniciar(){
        $frontendOptions = array(
           'lifetime' => $this->_duracion, 
           'automatic_serialization' => true ,
           'automatic_cleaning_factor' => 0
        );
        
        $directorio = 'media/tmp/';
        if(!is_dir($directorio)){
            mkdir($directorio, 0755);
        }

        $backendOptions = array('cache_dir' => $directorio);
        $cache          = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        return $cache;
    }
    
}