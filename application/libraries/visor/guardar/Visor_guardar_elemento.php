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
        
        $this->_ci->load->library(
            array("core/archivo/archivo_save")
        );
        
        $this->_emergencia_elemento_model = New Emergencia_Elemento_Model();
    }
    
    /**
     * 
     * @param int $id
     * @return \Visor_guardar_elemento
     */
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    /**
     * 
     * @param array $lista_elementos
     */
    public function guardar($lista_elementos){
        $guardados = array();

        if(count($lista_elementos)>0){
            
            foreach($lista_elementos as $elemento_json){
                $elemento = json_decode($elemento_json);
                
                if(is_object($elemento)){
                    
                    $emergencia_elemento = $this->_emergencia_elemento_model->getById($elemento->id);
                    
                    $icono = "";
                    $color = "";
                    
                    if(isset($elemento->icono)){
                        if(isset($elemento->hash)){
                            $this->_ci->archivo_save->saveFromCache($elemento->hash, array("emergencia", $this->_id_emergencia, "mapa"));
                            $icono = $this->_ci->archivo_save->getPath();
                            
                            if(!is_null($emergencia_elemento)){
                                $existe = strpos($emergencia_elemento->icono, "spotlight-poi-black.png");
                                if($existe === false){
                                    @unlink(FCPATH . $emergencia_elemento->icono);
                                }
                            }
                            
                        } else {
                            $icono = $elemento->icono;
                        }
                    }
                    
                    if(isset($elemento->color)){
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
                    

                }
            }    
        }
        
        $this->_emergencia_elemento_model->deleteNotIn($this->_id_emergencia, $guardados);

    }
    
}

