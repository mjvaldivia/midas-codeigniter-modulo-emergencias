<?php

Class Visor_guardar_elemento{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_Elemento_Model 
     */
    protected $_emergencia_elemento_model;
    
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
        $this->_ci->load->model("emergencia_elemento_model");
        $this->_emergencia_elemento_model = New Emergencia_Elemento_Model();
    }
    
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    public function guardar($lista_elementos){
        $guardados = array();
        $contenedores_centro = array();
        if(count($lista_elementos)>0){
            
            foreach($lista_elementos as $elemento_json){
                $elemento = json_decode($elemento_json);
                
                if(is_object($elemento)){
                    $contenenido = false;
                    $emergencia_elemento = $this->_emergencia_elemento_model->getById($elemento->id);
                    $icono = "";
                    $color = "";
                    if($elemento->tipo=="PUNTO"){
                        $icono = str_replace(FCPATH, "", $elemento->icono);
                        
                        if(isset($elemento->contenedor) && $elemento->contenedor){
                            $contenenido = true;
                        }
                        
                    } else {
                        $color = $elemento->color;
                    }
                    
                    $data = array("id_emergencia" => $this->_id_emergencia,
                                  "tipo" => $elemento->tipo,
                                  "color" => $color,
                                  "icono" => $icono,
                                  "propiedades" => json_encode($elemento->propiedades),
                                  "coordenadas" => json_encode($elemento->coordenadas));
                    
                    if(!is_null($emergencia_elemento)){
                        $this->_emergencia_elemento_model->update($data, $emergencia_elemento->id);
                        $id = $emergencia_elemento->id;
                        $guardados[] = $id;
                    } else {
                        $id = $this->_emergencia_elemento_model->insert($data);
                        $guardados[] = $id;
                    }
                    
                    if(!$contenenido){
                        $contenedores_centro[$elemento->clave]["contenedor"] = $id;
                    } else {
                        $contenedores_centro[$elemento->clave][] = $id;
                    }
                }
            }    
        }
        
        $this->_emergencia_elemento_model->deleteNotIn($this->_id_emergencia, $guardados);
        
        foreach($contenedores_centro as $clave => $lista){
            if(count($lista)>0){
                $data = array("id_contenedor_marcador_centro" => $lista["contenedor"]);
                unset($lista["contenedor"]);
                foreach($lista as $id_marcador){
                    $this->_emergencia_elemento_model->update($data, $id_marcador);
                }
            }
        }
    }
    
}

