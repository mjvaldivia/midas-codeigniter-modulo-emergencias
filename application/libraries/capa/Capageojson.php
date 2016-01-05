<?php

Class Capageojson{
    
    /**
     * Datos desde archivo geojson
     * @var array
     */
    protected $_json;
    
    /**
     * Setea el json
     * @param array $json
     */
    public function setGeojson(array $json){
        $this->_json = $json;
    }
    
    /**
     * Lista los tipos de geometria contenidos en el json
     * @return array
     */
    public function listGeometry(){
        fb($this->_json);
        $tipo = array();
        foreach ($this->_json['features'] as $key => $feature) {

            if(isset($tipo[$feature["geometry"]["type"]])){
                $tipo[$feature["geometry"]["type"]]++; 
            } else {
                $tipo[$feature["geometry"]["type"]] = 0;
            }
            
        }
        return array_keys($tipo);
    }
}

