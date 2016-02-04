<?php

Class Visor_Elemento_Instalaciones{
    
    
    protected $_lista_marcadores = array();
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_capa_model;
    
    /**
     *
     * @var Capa_Detalle_Model 
     */
    protected $_capa_detalle_model;
    
    /**
     *
     * @var Capa_Detalle_Elemento_Model 
     */
    protected $_capa_detalle_elemento_model;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * 
     * @param array $lista
     */
    public function __construct($lista) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_model");
        $this->_ci->load->helper("modulo/capa/capa");
        $this->_ci->load->model("capa_detalle_model");
        $this->_ci->load->model("capa_detalle_elemento_model");
        
        $this->_capa_model           = $this->_ci->capa_model;
        $this->_capa_detalle_model   = $this->_ci->capa_detalle_model;
        $this->_capa_detalle_elemento_model = $this->_ci->capa_detalle_elemento_model;
        
        if(count($lista)>0){
            foreach($lista as $key => $marcador){
                $subcapa = $this->_capa_detalle_model->getById($marcador->CAPA);
                if(!is_null($subcapa)){
                    unset($marcador->CAPA);
                    $lista_marcadores[getSubCapaPreview($subcapa->geometria_id) . " " . $subcapa->geometria_nombre][$key] = $marcador;
                } else {
                    $lista_marcadores["<i class=\"fa fa-2x fa-question-circle\"></i> Otros"][$key] = $marcador;
                }
            }
            
            $this->_lista_marcadores = $lista_marcadores;
        }
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        if(count($this->_lista_marcadores)>0){
        $html = $this->_htmlTabHeader()
               .$this->_htmlTabContent();
        } else {
                 $html .= "<div class=\"col-lg-12 top-spaced\"><div class=\"alert alert-info\">No existen instalaciones ubicadas en el poligono</div></div>";
       
        }
        
        return $html;
    }
    
    /**
     * Contenido de tabs
     */
    protected function _htmlTabContent(){
        $html = "<div class=\"col-xs-9\">"
                . "<div class=\"tab-content\">";
        
        if(count($this->_lista_marcadores)>0){
            $primero = true;
            foreach($this->_lista_marcadores as $grupo => $instalaciones){

                $class = "";
                if($primero){
                    $class = "active";
                }

                $id = md5($grupo);

                $html .= "<div role=\"tabpanel\" class=\"tab-pane ".$class."\" id=\"" . $id . "\">";

                $html .= $this->_htmlTableInstalaciones($instalaciones);

                $html .= "</div>";

                $primero = false;
            }
        } else {
            $html .= "<div class=\"col-lg-12 top-spaced\"><div class=\"alert alert-info\">No existen instalaciones ubicadas en el poligono</div></div>";
        }
        
        $html .= "</div>"
                . "</div>";
        
        return $html;
    }
    
    /**
     * Tabla con las instalaciones
     * @param type $instalaciones
     * @return string
     */
    protected function _htmlTableInstalaciones($instalaciones){
        if(count($instalaciones)>0){
            $html = "<div class=\"table-responsive\" data-row=\"5\">"
                  . "<table class=\"table table-hover table-letra-pequena datatable paginada\" style=\"width:95%\">"
                   ."<thead>"
                   ."<tr>";
            
            $aux = $instalaciones;
            $columnas = reset($aux);

            
            foreach($columnas as $key => $void){
                $html .= "<th>" . $key . "</th>";
            }
            
            $html .= "</tr>"
                   . "</thead>"
                   . "<tbody>";
      
            foreach($instalaciones as $key => $datos){ 
                $html .= "<tr>";
                
                foreach($datos as $nombre => $valor){
                    $html .= "<td>" . $valor . "</td>";
                }
                $html .= "</tr>";
            }
            $html .= "</tbody>"
                    ."</table>"
                    . "</div>";
        } else {
            $html = "<div class=\"col-lg-12 top-spaced\"><div class=\"alert alert-info\">No existen instalaciones ubicadas en el poligono</div></div>";
        }
        
        return $html;
    }
    
    /**
     * Cabecera Tabs
     * @return string
     */
    protected function _htmlTabHeader(){
        $html = "<div class=\"col-xs-3\">"
                . "<ul class=\"nav nav-pills tabs-left\" role=\"tablist\">";
        
        $primero = true;
        if(count($this->_lista_marcadores)>0){
            foreach($this->_lista_marcadores as $grupo => $instalaciones){
                $class = "";
                if($primero){
                    $class = "active";
                }

                $id = md5($grupo);
                $html .= "<li role=\"presentation\" class=\"" . $class . "\">"
                       . "<a href=\"#" . $id . "\" aria-controls=\"".$id."\" role=\"tab\" data-toggle=\"tab\">".$grupo."</a>"
                       . "</li>";

                 $primero = false;
            }
        }
        
        
        $html .= "</ul>"
                . "</div>";
        
        return $html;
    }
}

