<?php

Class String_json{
    
    /**
     * Recupera un valor de un Json
     * @param string $string
     * @param  $json json
     * @param $id identificador
     * @return string
     */
    public function jsonToString($string, $json, $id = ""){
        $hash = sha1($id . $json);
        if(Zend_Registry::isRegistered($hash)){
            $propiedades = Zend_Registry::get($hash);
        } else {
            $propiedades = Zend_Json::decode($json);
        }
        
        if(isset($propiedades[$string])){
            return $propiedades[$string];
        }
    }

}

