<?php

class Mapa_sidco extends MY_Controller {
    
    protected $_kml_path = "http://sidco.conaf.cl/mapa/earth-data.php?key=2gTkrf%2FkZkN4pvHtRclb7c%2FUobAO57i0o8AdyhFdAwA%3D";
        
    public function info(){
        header('Content-type: application/json');    
        
        $correcto = false;
         
        $params = $this->input->post(null, true);
        
        $kml = $this->_loadKml();
        $identificador = $this->_searchIdentificador($kml, $params["nombre"]);
        
        if($identificador != null){
            $correcto = true;
            $url = "http://sidco.conaf.cl/mapa/popup.php?id=" . $identificador . "&key=2gTkrf%2FkZkN4pvHtRclb7c%2FUobAO57i0o8AdyhFdAwA%3D";
        } else {
            $url = "";
        }
        
        echo json_encode(
                array("correcto" => $correcto,
                      "url" => $url)
                );
         
    }
    
    /**
     * Busca el nombre en el kml
     * @param type $kml
     * @param type $nombre
     */
    protected function _searchIdentificador($kml, $nombre){
        $identificador = null;
        $lista_tipos_incendios = $kml->kml->Document->Folder;
        foreach($lista_tipos_incendios as $tipos_incendios){
            
                if(isset($tipos_incendios->Folder)){
                    foreach($tipos_incendios->Folder as $incendio){
                        
                        if(is_array($incendio->Placemark)){
                            foreach($incendio->Placemark as $placemark){
                                if(isset($placemark->name) && $placemark->name == $nombre){
                                    $identificador = $placemark->ExtendedData->SchemaData->SimpleData;
                                }
                            }
                        } else {
                            if(isset($incendio->Placemark->name) && $incendio->Placemark->name == $nombre){
                                $identificador = $incendio->Placemark->ExtendedData->SchemaData->SimpleData;
                            }
                        }
                        
                        if($identificador != null){
                            break;
                        }
                    }
                }
            
            
            if($identificador != null){
                break;
            }
        }
        
        return $identificador;
    }
    
    /**
     * Carga el KML desde sidco
     * @return type
     */
    protected function _loadKml(){
        $zfClient = new Zend_Http_Client($this->_kml_path);        
        $zfClient->setConfig(array(
          'timeout' => 45
        ));
        $zfClient->setMethod(Zend_Http_Client::GET);

        $kml = json_decode(
            Zend_Json::fromXml(
                $zfClient->request()->getBody()
            )
        );
        fb($kml);
        return $kml;
    }
}

