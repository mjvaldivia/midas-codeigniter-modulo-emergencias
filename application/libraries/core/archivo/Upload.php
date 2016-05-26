<?php

/**
 * Sube archivo a temporal
 */
Class Upload{
    
    /**
     * Nombre de archivo
     * @var string 
     */
    protected $_file_name = "";
    
    /**
     * Extension de archivo
     * @var string 
     */
    protected $_file_ext  = "";
    
    /**
     * Destino del archivo
     * @var string
     */
    protected $_target    = "";
    
    /**
     * Hash identificador de cache
     * @var string
     */
    protected $_hash      = "";
    
    /**
     * Directorio temporal
     * @var string 
     */
    protected $_dir_temp  = "";
    
    /**
     *
     * @var type 
     */
    protected $_mime = "";
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        
        $this->_ci->load->library(
            array(
                "core/string/random", 
                "cache"
            )
        );
        
        $this->_dir_temp = FCPATH . "application/cache/upload_temp";
        
        if(!is_dir($this->_dir_temp)){
            mkdir($this->_dir_temp, 0755);
        }
    }
    
    /**
     * 
     * @param string $nombre
     */
    protected function _setFileConfig($nombre){
        $file = explode(".", $nombre);
        $this->_file_ext = strtolower($file[count($file)-1]);
        $this->_file_name = $nombre;
    }
    
    /**
     * Sube el archivo a temporal
     * @return string
     */
    public function upload($extenciones = array('kml','kmz')){
        $correcto = true;
        
        $upload = New Zend_File_Transfer();
        $upload->addValidator('Extension', false, $extenciones);
        $upload->addValidator('FilesSize', false, array('min' => '0.001kB', 'max' => '100MB'));
        $file = $upload->getFileInfo();
        foreach($file as $field_name => $file_data){

            if (!$upload->isUploaded($field_name)) {
                $correcto = false;
                $retorno = array("correcto" => false,
                                 "mensaje" => "No se subio ning&uacute;n archivo o estaba vac&iacute;o");
            }

            if (!$upload->isValid($field_name)) { 
               /* $texto = "</br>";
                $mensajes = $upload->getMessages();
                foreach($mensajes as $key => $txt){
                    $texto .= $txt . "</br>";
                }*/
                $correcto = false;
                $retorno = array("correcto" => false,
                                 "mensaje" => "<b>El archivo es inv&aacute;lido</b>.");
            }

            $this->_setFileConfig($file_data["name"]);
            $this->_mime = $file_data["type"];
            $this->_hash = $this->_ci->random->rand_string(20) . date("D_m_Y_H_i_s");
            $this->_target = $this->_dir_temp . "/" . $this->_hash . "." . $this->_file_ext;
            $upload->addFilter('Rename', array('target' => $this->_target , 'overwrite' => true));
        }

        $upload->receive();


        if($correcto){
            $retorno = $this->_saveToCache();
        }
        
        return $retorno;
    }
    
    /**
     * Guarda el archivo en cache
     * @return boolean
     */
    protected function _saveToCache(){
        $cache = $this->_ci->cache->iniciar();
        $cache->save(array("archivo" => file_get_contents($this->_target),
                           "archivo_nombre" => $this->_file_name,
                           "mime" => $this->_mime,
                           "tipo" => $this->_file_ext) , 
                    $this->_hash);
        
        $retorno = array("correcto" => true,
                         "mime" => $this->_mime,
                         "archivo_nombre" => $this->_file_name,
                         "tipo" => $this->_file_ext,
                         "hash" => $this->_hash);

        unlink($this->_target);
        
        return $retorno;
    }
}

