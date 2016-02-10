<?php

/**
 * Description of Zip
 *
 * @author carlos
 */
class Zip {
    
    /**
     *
     * @var ZipArchive 
     */
    protected $_zip;
    
    /**
     *
     * @var string 
     */
    protected $_tempfile;
    
    /**
     * Crea un archivo ZIP
     */
    public function __construct() {
        # create new zip opbject
        $this->_zip = new ZipArchive();
        # create a temp file & open it
        $this->_tempfile = tempnam('.','');
        $this->_zip->open($this->_tempfile, ZipArchive::CREATE);
    }
    
    /**
     * Agrega un archivo al zip
     * @param nombre del archivo $nombre
     * @param ruta del archivo a comprimir $file
     */
    public function add($nombre, $file){
        if(is_file($file)){
            # download file
            $download_file = file_get_contents($file);
            #add it to the zip
            $this->_zip->addFromString(basename($nombre), $download_file);
        }
    }
    
    /**
     * Retorna la ubicacion del ZIP
     * @return string
     */
    public function create(){
        $this->_zip->close();
        return $this->_tempfile;
    }
    
    /**
     * Limpia los archivos temporales
     */
    public function clear(){
        unlink($this->_tempfile);
    }
}
