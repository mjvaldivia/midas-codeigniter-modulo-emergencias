<?php

Class Kml_create{
    /**
     *
     * @var SimpleXMLElement  
     */
    protected $_kml;
    
    /**
     * Guarda estilos para los iconos
     * @var array 
     */
    protected $_style_icons = array();
    
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
        $this->_ci->load->library(array("string","cache"));
        
        
        $this->_kml = new SimpleXMLElement(
            "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
           ."<kml xmlns=\"http://www.opengis.net/kml/2.2\">"
           ."</kml>"
        );
        
        $this->_kml->addChild("Document");
        
    }
    
    /**
     * 
     * @param string $nombre
     * @param array $coordenadas
     * @param string $color
     * @param array $propiedades
     * @return string kml
     */
    public function addPoligon($nombre, $coordenadas, $color, $propiedades){
        $folder = $this->_kml->Document;
        $id_style = $this->_addStyle($folder, $color);
        $this->_addPoligon($folder, $nombre, $id_style, json_decode($coordenadas));
    }
    
    /**
     * 
     * @param type $posicion
     * @param type $icono
     * @param type $propiedades
     */
    public function addMarker($posicion, $icono, $propiedades){
        
        $cache = Cache::iniciar();
        
        $folder = $this->_kml->Document;
        
        //se crea el PATH absoluto desde la URL
        $icono = str_replace(base_url(), FCPATH, $icono);
        
        $ya_existe = array_search($icono, $this->_style_icons);
        if($ya_existe === false){
            $id_style = $this->_ci->string->rand_string(25);
            $style = $folder->addChild("Style");
            $style->addAttribute("id", $id_style);
            $iconStyle = $style->addChild("IconStyle");
            $icon = $iconStyle->addChild("Icon");
            
            $name = $id_style.".".$this->_imgExt($icono);
            $path = "icons/" . $name;
            $icon->addChild("href", $path);
            
            $cache->save(array("name" => $name,
                               "file" => file_get_contents($icono)), $id_style);
            
            
            $this->_style_icons[$id_style] = $icono;
        } else {
            $id_style = $ya_existe;
        }
        
        $placemark = $folder->addChild("Placemark");
        $placemark->addChild("styleUrl", "#" . $id_style);
        $point = $placemark->addChild("Point");
        $point->addChild("coordinates", $posicion["lng"] . "," . $posicion["lat"] . ",0.");
    }
    
    public function _imgExt($icono){
        $separado = explode(".", $icono);
        return $separado[count($separado)-1];
    }
    
    /*
     * 
     */
    public function getStyleIcons(){
        return array_keys($this->_style_icons);
    }
    
    /**
     * 
     * @return string xml
     */
    public function getKml(){
        return $this->_kml->asXML();
    }
    
    /**
     * 
     * @param string $nombre
     * @param array $coordenadas
     */
    protected function _addPoligon(
        $folder,
        $nombre, 
        $id_style,
        array $coordenadas = array()
    ){
        $placemark = $folder->addChild("Placemark");
        $placemark->addChild("name", $nombre);
        $placemark->addChild("styleUrl", "#" . $id_style);
        
        $polygon = $placemark->addChild("Polygon");

        $polygon->addChild("extrude", 1);

        
        $polygon->addChild("altitudeMode", "relativeToGround");
        
        $linearRing = $polygon->addChild("outerBoundaryIs")->addChild("LinearRing");
                
        $string = "";
        if(count($coordenadas)>0){
            foreach($coordenadas as $coordenada){
                $string .= $coordenada->lng . "," .$coordenada->lat . ",100\n";
            }
        }
        
        $linearRing->addChild("coordinates", $string);

    }
    
    /**
     * Agrega estilo para el elemento
     * @param string $color
     */
    protected function _addStyle($folder, $color){
        
        $id = $this->_ci->string->rand_string(20);
      
        $style = $folder->addChild("Style");
        $style->addAttribute("id", $id);
        
        $lineStyle = $style->addChild("LineStyle");
        $lineStyle->addChild("width", "1.5");
        $lineStyle->addChild("color", "ff000000");

        $polyStyle = $style->addChild("PolyStyle");
        $polyStyle->addChild("color", "7f" . $this->_color($color));
        
        return $id;
    }
    
    protected function _color($color){
        $hex = str_replace("#", "", $color);
        $rojo = substr($hex, 0, 2);
        $verde = substr($hex, 3, 2);
        $azul = substr($hex, 4);
        
        return $azul.$verde.$rojo;
    }
}
