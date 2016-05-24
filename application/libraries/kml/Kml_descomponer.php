<?php

Class Kml_descomponer{
    
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
     * Constructor
     */
    public function __construct() 
    {
        $this->_ci =& get_instance();
        $this->_ci->load->library(
            array("string", "cache")
        );
        
        $this->_dir_temp = FCPATH . "media/tmp/";
    }
    
    /**
     * Procesar
     */
    public function process()
    {    
  
        foreach (glob($this->_dir_temp . "/*.kml") as $filename) {
            
            //convertir KML a array
            $data = Zend_Json::decode(Zend_Json::fromXml(file_get_contents($filename), false));
            
            $this->_findPlacemarks($data);
            $this->_findStyles($data);
            $this->_findStylesMap($data);
        }
                
        if(count($this->_placemarks)>0){
            foreach($this->_placemarks as $key => $placemark){
                if(isset($placemark[0])){
                    foreach($placemark as $elemento){
                        $this->_procesaPunto($elemento);
                        $this->_procesaPoligono($elemento);
                        $this->_procesaMultiPoligono($elemento);
                        $this->_procesaLinea($elemento);
                    }
                } else {
                    $this->_procesaPunto($placemark);
                    $this->_procesaPoligono($placemark);
                    $this->_procesaMultiPoligono($placemark);
                    $this->_procesaLinea($placemark);
                }
            }
        }
        
        //se agregan los elementos al cache que contiene el archivo
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
    protected function _procesaLinea($elemento)
    {
        
        if(isset($elemento["MultiGeometry"]["LineString"])){
            
            $data = array("tipo" => "LINEA");
            
            if(isset($elemento["name"])){
                $data["nombre"] = $elemento["name"];
            } else {
                $data["nombre"] = "SIN NOMBRE";
            }
            
            if(isset($elemento["description"])){
                $data["descripcion"] = $elemento["description"];
            } else {
                $data["descripcion"] = "SIN DESCRIPCIÓN";
            }
            
            if(isset($elemento["styleUrl"])){
                $id = str_replace("#", "", $elemento["styleUrl"]);
                if(isset($this->_styles[$id]["linea"]["color"])){
                    $data["color"] = $this->_styles[$id]["linea"]["color"];
                }
            }
            
            if(isset($elemento["MultiGeometry"]["LineString"]["coordinates"])){
                $data["coordenadas"]["linea"][] = $this->_procesaCoordenadasLinea($elemento["MultiGeometry"]["LineString"]["coordinates"]);
            } else {
                foreach($elemento["MultiGeometry"]["LineString"] as $linea){
                    $data["coordenadas"]["linea"][] = $this->_procesaCoordenadasLinea($linea["coordinates"]);
                }
            }
                        
            $this->_elementos[] = $data;
        }
    }
    
    /**
     * 
     * @param string $data
     * @return array
     */
    protected function _procesaCoordenadasLinea($data)
    {
        $coord = array();
        $coordenadas = explode(" ", TRIM($data));
        if(count($coordenadas)>0){
            foreach($coordenadas as $string){
                $latLon = explode(",", $string);
                $coord[] = array(
                    1 => $latLon[0],
                    0 => $latLon[1]
                );
            }
        }
        return $coord;
    }
    
    /**
     * 
     * @param type $elemento
     */
    protected function _procesaPoligono($elemento){
        if(isset($elemento["Polygon"])){
            
            $data = array("tipo" => "POLIGONO");
            
            if(isset($elemento["name"])){
                $data["nombre"] = $elemento["name"];
            } else {
                $data["nombre"] = "SIN NOMBRE";
            }
            
            if(isset($elemento["description"])){
                $data["descripcion"] = $elemento["description"];
            } else {
                $data["descripcion"] = "SIN DESCRIPCIÓN";
            }
            
            if(isset($elemento["styleUrl"])){
                $id = str_replace("#", "", $elemento["styleUrl"]);
                if(isset($this->_styles[$id]["poligono"]["color"])){
                    $data["color"] = $this->_styles[$id]["poligono"]["color"];
                }
            }
            
            if(isset($elemento["Polygon"]["outerBoundaryIs"])){
                $data["coordenadas"]["poligono"] = $this->_procesaCoordenadasPoligono($elemento["Polygon"]);
            } else {
                foreach($elemento["Polygon"] as $poligono){
                    $data["coordenadas"]["poligono"] = $this->_procesaCoordenadasPoligono($poligono);
                }
            }
            
            $this->_elementos[] = $data;
        }
    }
    
    /**
     * Procesa los datos de los multipoligonos
     * @param array $elemento
     */
    protected function _procesaMultiPoligono($elemento)
    {
        if(isset($elemento["MultiGeometry"]["Polygon"])){
            
            $data = array("tipo" => "MULTIPOLIGONO");
            
            if(isset($elemento["name"])){
                $data["nombre"] = $elemento["name"];
            } else {
                $data["nombre"] = "SIN NOMBRE";
            }
            
            if(isset($elemento["description"])){
                $data["descripcion"] = $elemento["description"];
            } else {
                $data["descripcion"] = "SIN DESCRIPCIÓN";
            }
            
            if(isset($elemento["styleUrl"])){
                $id = str_replace("#", "", $elemento["styleUrl"]);
                if(isset($this->_styles[$id]["poligono"]["color"])){
                    $data["color"] = $this->_styles[$id]["poligono"]["color"];
                }
            }
            
            if(isset($elemento["MultiGeometry"]["Polygon"]["outerBoundaryIs"])){
                $data["coordenadas"]["poligono"][] = $this->_procesaCoordenadasPoligono($elemento["MultiGeometry"]["Polygon"]);
            } else {
                foreach($elemento["MultiGeometry"]["Polygon"] as $poligono){
                    $data["coordenadas"]["poligono"][] = $this->_procesaCoordenadasPoligono($poligono);
                }
            }
            
            $this->_elementos[] = $data;
        }
    }
    
    /**
     * 
     * @param array $data
     * @return array
     */
    protected function _procesaCoordenadasPoligono($data)
    {
        $coord = array();
        
        $texto = str_replace("\n", " ", TRIM($data["outerBoundaryIs"]["LinearRing"]["coordinates"]));
        $coordenadas = explode(" ", $texto);
        if(count($coordenadas)>0){
            foreach($coordenadas as $string){
                $latLon = explode(",", $string);
                $coord[] = array(
                    0 => $latLon[0],
                    1 => $latLon[1]
                );
            }
        }
        return $coord;
        
    }
    
    /**
     * Procesa los datos de un punto
     * @param array $elemento
     */
    protected function _procesaPunto($elemento)
    {
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
            
            if(isset($elemento["ExtendedData"])){
                if(isset($elemento["ExtendedData"]["SchemaData"])){
                    foreach($elemento["ExtendedData"]["SchemaData"]["SimpleData"] as $simple_data){
                        if(isset($simple_data["@text"])){
                            
                            if($simple_data["@attributes"]["name"] == "PopupInfo"){
                                $descripcion = $simple_data["@text"];
                            }
                            
                            $propiedades[$simple_data["@attributes"]["name"]] = $simple_data["@text"];
                        }
                    }
                }
            } else {
                $propiedades = array("NOMBRE" => $nombre);
            }
            
            //marcador por defecto
            $icono = "";
            if(isset($elemento["styleUrl"])){
                $id = str_replace("#", "", $elemento["styleUrl"]);
                if(isset($this->_styles[$id]["icono"]["path"])){
                    $icono = $this->_styles[$id]["icono"]["path"];
                }
            }
            
            //si no se encuentra un marcador, se copia el marcador por defecto
            if($icono == ""){
                $file = "marker_" . $this->_ci->string->rand_string(10) . ".png";
                copy(FCPATH . "assets/img/markers/spotlight-poi.png", $this->_dir_temp . "/" . $file);
                $icono = str_replace(FCPATH, "", $this->_dir_temp . "/" . $file);
            }
            
            $this->_elementos[] = array(
                "nombre" => $nombre,
                "icono" => $icono,
                "descripcion" => $descripcion,
                "propiedades" => $propiedades,
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
     * Prepara el archivo y lo coloca en directorio temporal
     * @param string $hash
     */
    public function setFileHash($hash)
    {
        $this->_hash = $hash;
        $cache = Cache::iniciar();
        if($this->_file_info = $cache->load($hash)){
            
            $this->_dir_temp .= $this->_ci->string->rand_string(21);
            
            mkdir($this->_dir_temp, 0755);
            
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
     * Busca los estilos mapeados
     * y selecciona el primer estilo que encuentra para cada uno
     * @param array $array
     */
    protected function _findStylesMap($array)
    {
        
        if(is_array($array)){
            foreach($array as $id => $styleMap){
                if($id == "StyleMap"){
                    if(isset($styleMap["Pair"])){
                        if(isset($styleMap["@attributes"]["id"])){
                            $this->_styles[$styleMap["@attributes"]["id"]] = $this->_styles[str_replace("#", "", $styleMap["Pair"][0]["styleUrl"])] ;
                        }
                    } else {
                        foreach($styleMap as $propiedades){
                            if(isset($propiedades["@attributes"]["id"])){
                                $this->_styles[$propiedades["@attributes"]["id"]] = $this->_styles[str_replace("#", "", $propiedades["Pair"][0]["styleUrl"])] ;
                            }
                        }
                    }
                    
                } else {
                    if($id != "Folder" && $id!="Placement"){
                        $this->_findStylesMap($styleMap);
                    }
                }
            }
        }
    }
    
    /**
     * Encuentra estilos para elementos
     * @param type $array
     */
    protected function _findStyles($array)
    {
        if(is_array($array)){
            foreach($array as $id => $style){
                if($id == "Style"){
                    if(isset($style["@attributes"]["id"])){
                        $this->_addStyle($style);
                    } else {
                        foreach($style as $key => $value){
                            if(isset($value["@attributes"]["id"])){
                                $this->_addStyle($value);
                            }
                        }
                    }
                } else {
                    if($id != "Folder"){
                        $this->_findStyles($style);
                    }
                }
            }
        }
    }
    
    /**
     * Agrega el estilo
     * @param array $value
     */
    protected function _addStyle($value)
    {
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
        
        $linea = array();

        if(isset($value["LineStyle"]["color"])){
            $linea = array(
                "linea" => array(
                    "color"  =>  $this->_color($value["LineStyle"]["color"])
                )
            );
        }

        $this->_styles[$value["@attributes"]["id"]] = array_merge($icono, $poligono, $linea);
    }
    
    /**
     * Busca los placemarks que contienen elementos
     * @param array $array
     */
    protected function _findPlacemarks($array)
    {
        if(is_array($array)){
            foreach($array as $id => $value){
                if($id != "Style"){
                    if($id == "Placemark"){
                        $this->_placemarks[] = $value;
                    } else {
                        $this->_findPlacemarks($value);
                    }
                }
            }
        }
    }
    
    /**
     * 
     * @param string $color
     * @return string
     */
    protected function _color($color)
    {
        $azul = substr($color, 2, 2);
        $verde = substr($color, 4, 2);
        $rojo = substr($color, 6);
        
        return "#".$rojo.$verde.$azul;
    }
}