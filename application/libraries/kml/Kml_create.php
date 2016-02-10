<?php

Class Kml_create{
    /**
     *
     * @var SimpleXMLElement  
     */
    protected $_kml;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_kml = new SimpleXMLElement(
            "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
           ."<kml xmlns=\"http://www.opengis.net/kml/2.2\">"
           ."</kml>"
        );
    }
    
    /**
     * 
     * @param string $nombre
     * @param array $coordenadas
     * @param string $color
     * @param array $propiedades
     * @return string kml
     */
    public function poligon($nombre, $coordenadas, $color, $propiedades){
        $this->_kml->addChild("Document");
        $this->_addStyle($color);
        $this->_addPoligon($nombre,  json_decode($coordenadas));
        return $this->_kml->asXML();
    }
    
    /**
     * 
     * @param string $nombre
     * @param array $coordenadas
     */
    protected function _addPoligon(
        $nombre, 
        array $coordenadas = array()
    ){
        $this->_kml->Document->addChild("Placemark");
        $this->_kml->Document->Placemark->addChild("name");
        $this->_kml->Document->Placemark->name = $nombre; 
        
        $this->_kml->Document->Placemark->addChild("styleUrl");
        $this->_kml->Document->Placemark->styleUrl = "#transBluePoly";
        
        $this->_kml->Document->Placemark->addChild("Polygon");
        $this->_kml->Document->Placemark->Polygon->addChild("extrude");
        $this->_kml->Document->Placemark->Polygon->extrude = 1;
        
        $this->_kml->Document->Placemark->Polygon->addChild("altitudeMode");
        $this->_kml->Document->Placemark->Polygon->altitudeMode = "relativeToGround";
        
        $this->_kml->Document->Placemark->Polygon->addChild("outerBoundaryIs");
        $this->_kml->Document->Placemark->Polygon->outerBoundaryIs->addChild("LinearRing");
        $this->_kml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->addChild("coordinates");
        
        $string = "";
        if(count($coordenadas)>0){
            foreach($coordenadas as $coordenada){
                $string .= $coordenada->lat . "," .$coordenada->lng . ",100\n";
            }
        }
        
        $this->_kml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->coordinates = $string;
    }
    
    /**
     * Agrega estilo para el elemento
     * @param string $color
     */
    protected function _addStyle($color){
        
        $this->_kml->Document->addChild("Style");
        $this->_kml->Document->Style->addAttribute("id", "transBluePoly");
        
        $this->_kml->Document->Style->addChild("LineStyle");
        $this->_kml->Document->Style->LineStyle->addChild("width");
        $this->_kml->Document->Style->LineStyle->width = "1.5";
        
        $this->_kml->Document->Style->addChild("PolyStyle");
        $this->_kml->Document->Style->PolyStyle->addChild("color");
        $this->_kml->Document->Style->PolyStyle->color = $color;
    }
}
