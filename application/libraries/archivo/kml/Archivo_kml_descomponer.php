<?php

Class Archivo_kml_descomponer{
    
        
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_file_info;
    
    /**
     *
     * @var string 
     */
    protected $_hash;
    
    /**
     *
     * @var string 
     */
    protected $_dir_temp = "";
    
    /**
     * Contenedores de elementos en el KML
     * @var array
     */
    protected $_placemarks = array();
    
    /**
     * Elementos recuperados desde el KML
     * @var array 
     */
    protected $_elementos = array();
    
    /**
     *
     * @var array 
     */
    protected $_styles = array();
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library(
            array("string", "cache")
        );
        
        $this->_dir_temp = FCPATH . "media/tmp/";
    }
    
    
    
    /**
     * Procesar
     */
    public function process(){
        
        foreach (glob($this->_dir_temp . "/*.kml") as $filename) {
            
            $data = Zend_Json::decode(Zend_Json::fromXml(file_get_contents($filename), false));
           
            $this->_findPlacemarks($data);
            $this->_findStyles($data);
        }
        
   
        
        if(count($this->_placemarks)>0){
            foreach($this->_placemarks as $key => $placemark){
                foreach($placemark as $elemento){
                    $this->_procesaPunto($elemento);
                }
            }
        }
        
        //se agregan los elementos al cache
        $cache = Cache::iniciar();
        $data = $cache->load($this->_hash);
        $data["elementos"] = $this->_elementos;
        $cache->save($data, $this->_hash);
        
        return $this->_elementos;
                
    }
    
    /**
     * 
     * @param array $elemento
     */
    protected function _procesaPunto($elemento){
        if(isset($elemento["Point"])){

            $coordenadas = explode("," , $elemento["Point"]["coordinates"]);
            
            if(isset($elemento["name"])){
                $nombre = $elemento["name"];
            } else {
                $nombre = "SIN NOMBRE";
            }
            
            if(isset($elemento["description"])){
                $descripcion = $elemento["description"];
            } else {
                $descripcion = "SIN DESCRIPCIÓN";
            }
            
            $icono = "";
            if(isset($elemento["styleUrl"])){
                $id = str_replace("#", "", $elemento["styleUrl"]);
                if(isset($this->_styles[$id]["icono"]["path"])){
                    $icono = $this->_styles[$id]["icono"]["path"];
                }
                
            }
            
            $this->_elementos[] = array(
                "nombre" => $nombre,
                "icono" => $icono,
                "descripcion" => $descripcion,
                "tipo" => "PUNTO",
                "coordenadas" => 
                    array(
                        "lat" => trim($coordenadas[0]),
                        "lon" => trim($coordenadas[1])
                    )
            );
        }
    }
    
    /**
     * Prepara el archivo del cache y lo coloca en directorio temporal
     * @param string $hash
     */
    public function setFileHash($hash){
        $this->_hash = $hash;
        $cache = Cache::iniciar();
        if($this->_file_info = $cache->load($hash)){
            
            $this->_dir_temp .= $this->_ci->string->rand_string(21);
            
            mkdir($this->_dir_temp, "0755");
            
            file_put_contents($this->_dir_temp . "/" . $this->_file_info["archivo_nombre"], $this->_file_info["archivo"]);
            
            if($this->_file_info["tipo"] == "kmz"){
                $filter     = new Zend_Filter_Decompress(array(
                    'adapter' => 'Zip',
                    'options' => array(
                        'target' => $this->_dir_temp,
                    )
                ));
                $compressed = $filter->filter($this->_dir_temp . "/" . $this->_file_info["archivo_nombre"]);
                
                if($compressed){
                    unlink($this->_dir_temp . "/" . $this->_file_info["archivo_nombre"]);
                }
            }
            
        }
    }
    
    /**
     * 
     * @param type $array
     */
    protected function _findStyles($array){
        if(is_array($array)){
            foreach($array as $id => $style){
                if($id == "Style"){
                    if(isset($style["@attributes"]["id"])){
                        $this->_addStyle($style);
                    } else {
                        foreach($style as $key => $value){
                            $this->_addStyle($value);
                        }
                    }
                } else {
                    $this->_findStyles($style);
                }
            }
        }
    }
    
    /**
     * Agrega el estilo
     * @param array $value
     */
    protected function _addStyle($value){
        $icono = array();

        if(isset($value["IconStyle"]["Icon"])){

            $icono = array(
                "icono" => array(
                    "path" => str_replace(FCPATH, "", $this->_dir_temp . "/" . $value["IconStyle"]["Icon"]["href"])
                )
            );

        }

        $poligono = array();

        if(isset($value["PolyStyle"]["color"])){
            $poligono = array(
                "poligono" => array(
                    "color"  =>  $this->_color($value["PolyStyle"]["color"])
                )
            );
        }

        $this->_styles[$value["@attributes"]["id"]] = array_merge($icono, $poligono);
    }
    
    /**
     * Busca los placemarks que contienen elementos
     * @param array $array
     */
    protected function _findPlacemarks($array){
        if(is_array($array)){
            foreach($array as $id => $value){
                if($id == "Placemark"){
                    $this->_placemarks[] = $value;
                } else {
                    $this->_findPlacemarks($value);
                }
            }
        }
    }
    
    /**
     * 
     * @param type $color
     * @return type
     */
    protected function _color($color){
        $azul = substr($hex, 2, 2);
        $verde = substr($hex, 4, 2);
        $rojo = substr($hex, 6);
        
        return "#".$rojo.$verde.$azul;
    }
}

