<?php

Class Emergencia_Html_IconoTipoEmergencia{
    
    /**
     *
     * @var CI_Controller
     */
    protected $ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia_tipo;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model("tipo_emergencia_model");
    }
    
    /**
     * 
     * @param int $id_emergencia_tipo
     */
    public function setEmergenciaTipo($id_emergencia_tipo){
        $this->_id_emergencia_tipo = $id_emergencia_tipo;
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        $class = "";
        switch ($this->_id_emergencia_tipo) {
            case Tipo_Emergencia_Model::INCENDIOS_URBANOS:
            case Tipo_Emergencia_Model::INCENDIOS_URBANOS:
                $class = "glyphicon glyphicon-fire icono";
                break;
            case Tipo_Emergencia_Model::INCENDIOS_QUIMICOS:
                $class = "fa fa-4x fa-flask icono";
                break;
            case Tipo_Emergencia_Model::FENOMENOS_METEOROLOGICOS:
                $class = "fa fa-4x fa-cloud icono";
                break;
            case Tipo_Emergencia_Model::SISMOS:
                $class = "fa fa-4x fa-bullseye icono";
                break;
            case Tipo_Emergencia_Model::TSUNAMI:
                $class = "fa fa-4x fa-life-ring icono";
                break;
            case Tipo_Emergencia_Model::ERUPCION_VOLCANICA:
                $class = "fa fa-4x fa-globe icono";
                break;
            case Tipo_Emergencia_Model::SEQUIAS:
                $class = "glyphicon glyphicon-tint icono";
                break;
            case Tipo_Emergencia_Model::ACCIDENTE_MULTIPLES_VICTIMAS:
            case Tipo_Emergencia_Model::ACCIDENTE_MEGA_EVENTOS:
                $class = "fa fa-4x fa-medkit icono";
                break;
            case Tipo_Emergencia_Model::ACTO_TERRORISTA:
                $class = "fa fa-4x fa-bomb icono";
                break;
            case Tipo_Emergencia_Model::EMERGENCIA_EPIDEMIOLOGICA:
            case Tipo_Emergencia_Model::EMERGENCIA_SANEAMIENTO:
                $class = "fa fa-4x fa-user-md icono";
                break;
            case Tipo_Emergencia_Model::OTROS:
                $class = "fa fa-4x fa-bullhorn icono";
                break;
            case Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA:
                $class = "fa fa-4x fa-bolt icono";
                break;
            default:
                break;
        }
        return "<i class=\"".$class."\"></i>";
    }
}
