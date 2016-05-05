<?php

Class Visor_externo_vectores{
    
    protected $_url = array(
        "development" => "http://development.vigilancia.midas.cl/rest/getDataVectores/rest/getDataVectores",
        "testing" => "http://200.55.194.54:8001/vigilancia/rest/getDataVectores",
        "production" => "http://127.0.0.1/monitoreo/rest/getDataVectores"
    );
    
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
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $zfClient = new Zend_Http_Client($this->_url[ENVIRONMENT]);        
        $zfClient->setConfig(array(
          'timeout' => 45
        ));
        $zfClient->setMethod(Zend_Http_Client::GET);
        $resultado = Zend_Json::decode($zfClient->request()->getBody());
        if($resultado["correcto"]){
            return $resultado["data"];
        }
    }
}

