<?php

require_once(__DIR__ . "/../alarma/Alarma_guardar.php");

/**
 * Guarda emergencia
 */
Class Emergencia_guardar extends Alarma_guardar{
    
    /**
     *
     * @var Emergencia_Model
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    protected $_emergencia_comuna_model;
    
    /**
     *
     * @var array
     */
    protected $_emergencia = null;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("emergencia_model");
        $this->_ci->load->model("tipo_emergencia_model");
        $this->_ci->load->model("emergencia_comuna_model");
        $this->_emergencia_tipo_model   = New Tipo_Emergencia_Model();
        $this->_emergencia_model = New Emergencia_Model();
        $this->_emergencia_comuna_model = New Emergencia_Comuna_Model();
    }
    
    /**
     * Retorna identificador de la emergencia
     * @return int
     */
    public function getId(){
        if(!is_null($this->_emergencia)){
            return $this->_emergencia->eme_ia_id;
        }
    }
    
    /**
     * Guarda la emergencia
     * @param array $datos
     */
    public function guardar($datos){
        if(is_null($this->_emergencia)){
            $id = $this->_emergencia_model->query()->insert($datos);
            $this->setEmergencia($id);
        } else {
            $this->_emergencia_model->query()->update($datos, "eme_ia_id", $this->_emergencia->eme_ia_id);
        }
    }
    
    /**
     * 
     * @param array $comunas
     */
    public function setComunas($comunas){
        if(!is_null($this->_emergencia)){
            $this->_emergencia_comuna_model->query()->insertOneToMany("eme_ia_id", 
                                                                      "com_ia_id", 
                                                                      $this->_emergencia->eme_ia_id, 
                                                                      $comunas);
        }
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @throws Exception
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
        
        if(is_null($this->_emergencia)){
            throw new Exception(__METHOD__ . " - No existe la emergencia");
        }
        
        $this->setTipo($this->_emergencia->tip_ia_id);
        
    }
    
    /**
     * 
     * @param array $datos
     */
    protected function _guardaDatosTipoEmergencia($datos){
        $update = array("eme_c_datos_tipo_emergencia" => serialize($datos));
        $this->_emergencia_model->update($update, $this->_emergencia->eme_ia_id);
    }


    /**
     *
     * @param int $id_tipo
     */
    public function setTipo($id_tipo){
        $this->_tipo_emergencia = $this->_emergencia_tipo_model->getById($id_tipo);
        if(is_null($this->_tipo_emergencia)){
            throw new Exception(__METHOD__ . " - No existe el tipo de emergencia");
        }
    }

    /**
     * Guarda los campos del tipo de emergencia
     * @param array $parametros
     */
    public function guardarDatosTipoEmergencia($parametros){

        switch ($this->_tipo_emergencia->aux_ia_id) {
            case Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA:
                $guardar = true;
                break;
            default:
                $guardar = true;
                break;
        }

        if($guardar){
            $datos = array();
            foreach($parametros as $nombre => $valor){
                $existe_campo = strpos($nombre, "form_tipo_");
                if($existe_campo !== false){
                    $campo = str_replace("form_tipo_", "", $nombre);
                    $datos[$campo] = $valor;
                }
            }

            $this->_guardaDatosTipoEmergencia($datos);
        }
    }





}
