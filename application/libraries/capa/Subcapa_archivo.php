<?php

Class Subcapa_archivo{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_subcapa;
    
    /**
     *
     * @var array 
     */
    protected $_agregados;
    
    /**
     * Directorio de archivos
     * @var string
     */
    protected $_dir = "media/doc/capa/";
    
    /**
     * Ubicacion del archivo
     * @var string 
     */
    protected $_path = "";
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("cache");
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");        
    }
    
    
    /**
     * Agrega icono a la subcapa
     * @param string $hash
     */
    public function addIcono($hash){
        $cache = Cache::iniciar();
        if($file = $cache->load($hash)){
            $path = $this->_path . $file["filename"];
            file_put_contents(FCPATH . $path, $file["content"]);
            $data = array("geometria_icono" => $path);
            $this->_ci->_capa_detalle_model->update($data, $this->_subcapa->geometria_id);
        }
        $cache->remove($hash);
    }
    
    /**
     * 
     * @param int $id_subcapa
     * @throws Exception
     */
    public function setSubcapa($id_subcapa){
        $this->_subcapa = $this->_ci->_capa_detalle_model->getById($id_subcapa);
        if(is_null($this->_subcapa)){
            throw new Exception("La subcapa no existe");
        }
         
        $this->_path = $this->_dir . $this->_subcapa->geometria_id . "/";
        
        if(!is_dir(FCPATH . $this->_path)){
            mkdir(FCPATH . $this->_path, "0755");
        }
    }
}

