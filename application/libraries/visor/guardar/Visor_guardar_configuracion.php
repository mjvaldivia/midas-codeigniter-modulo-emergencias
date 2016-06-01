<?php

Class Visor_guardar_configuracion{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var int 
     */
    protected $_zoom = 17;
    
    /**
     *
     * @var float 
     */
    protected $_latitud;
    
    /**
     *
     * @var float
     */
    protected $_longitud;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_sidco_conaf;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_casos_febriles;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_casos_febriles_zona;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_marea_roja;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_marea_roja_pm;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_vectores;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_vectores_hallazgos;
    
    /**
     * Lista de archivos que estan ocultos
     * @var array 
     */
    protected $_lista_archivos_ocultos;
    
    /**
     *
     * @var string 
     */
    protected $_tipo_mapa;
    
    /**
     *
     * @var Emergencia_Mapa_Configuracion_Model 
     */
    protected $_emergencia_mapa_configuracion_model;
    
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
        $this->_ci->load->library(array("cache"));
        $this->_ci->load->model("emergencia_mapa_configuracion_model");
        $this->_emergencia_mapa_configuracion_model = $this->_ci->emergencia_mapa_configuracion_model;
    }
    
    /**
     * Setea emergencia
     * @param int $id
     * @return \Visor_guardar_elemento
     */
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    /**
     * 
     * @param int $zoom
     */
    public function setZoom($zoom){
        $this->_zoom = $zoom;
        return $this;
    }
    
    /**
     * 
     * @param float $lat
     * @return \Visor_guardar_configuracion
     */
    public function setLatitud($lat){
        if($lat != ""){
            $this->_latitud = $lat;
        }
        return $this;
    }
    
    /**
     * 
     * @param float $lng
     * @return \Visor_guardar_configuracion
     */
    public function setLongitud($lng){
        if($lng != ""){
            $this->_longitud = $lng;
        }
        return $this;
    }
    
    /**
     * 
     * @param string $string
     */
    public function setTipoMapa($string){
        $this->_tipo_mapa = $string;
        return $this;
    }
    
   /**
    * 
    * @param boolean $boolean
    * @return \Visor_guardar_configuracion
    */
    public function setMareaRoja($boolean){
        $this->_bo_marea_roja = $boolean;
        return $this;
    }
    
    /**
    * 
    * @param boolean $boolean
    * @return \Visor_guardar_configuracion
    */
    public function setMareaRojaPm($boolean){
        $this->_bo_marea_roja_pm = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     * @return \Visor_guardar_configuracion
     */
    public function setVectores($boolean){
        $this->_bo_vectores = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     * @return \Visor_guardar_configuracion
     */
    public function setVectoresHallazgos($boolean){
        $this->_bo_vectores_hallazgos = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     */
    public function setSidcoConaf($boolean){
        $this->_bo_sidco_conaf = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     * @return \Visor_guardar_configuracion
     */
    public function setCasosFebriles($boolean){
        $this->_bo_casos_febriles = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     * @return \Visor_guardar_configuracion
     */
    public function setCasosFebrilesZona($boolean){
        $this->_bo_casos_febriles_zona = $boolean;
        return $this;
    }
    
    /**
     * 
     * @param array $lista_archivos
     */
    public function setArchivosOcultos($lista_archivos){
        $this->_lista_archivos_ocultos = $lista_archivos;
        return $this;
    }
    
    /**
     * 
     */
    public function guardar(){
        
        $configuracion = array(
            "bo_kml_sidco"           => $this->_bo_sidco_conaf,
            "bo_casos_febriles"      => $this->_bo_casos_febriles,
            "bo_casos_febriles_zona" => $this->_bo_casos_febriles_zona,
            "bo_marea_roja"          => $this->_bo_marea_roja,
            "bo_marea_roja_pm"       => $this->_bo_marea_roja_pm,
            "bo_vectores"            => $this->_bo_vectores,
            "bo_vectores_hallazgos"  => $this->_bo_vectores_hallazgos,
            "archivos_ocultos"       => $this->_lista_archivos_ocultos
        );
        
        $data = array(
            "id_emergencia" => $this->_id_emergencia,
            "tipo_mapa"     => $this->_tipo_mapa,
            "zoom"          => $this->_zoom,
            "latitud"       => $this->_latitud,
            "longitud"      => $this->_longitud,
            "configuracion" => Zend_Json::encode($configuracion)
        );
        
        $mapa = $this->_emergencia_mapa_configuracion_model->getByEmergencia($this->_id_emergencia);
        if(is_null($mapa)){
            $this->_emergencia_mapa_configuracion_model->insert($data);
        } else {
            $this->_emergencia_mapa_configuracion_model->updatePorEmergencia($this->_id_emergencia, $data);
        }
    }
}

