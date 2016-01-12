<?php

Class Visor_Poligono_Instalaciones{
    
    
    protected $_lista_marcadores = array();
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_capa_model;
    
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
        $this->_capa_model = New Capa_Model();
        
        if(count($lista)>0){
            foreach($lista as $key => $marcador){
                $capa_marcador = $this->_capa_model->getById($marcador["CAPA"]);
                if(!is_null($capa_marcador)){
                    unset($marcador["CAPA"]);
                    $lista_marcadores["CAPA: " . $capa_marcador->cap_c_nombre][$key] = $marcador;
                } else {
                    $lista_marcadores["Otros"][$key] = $marcador;
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
        $html = $this->_htmlTabHeader()
               .$this->_htmlTabContent();
        
        return $html;
    }
    
    /**
     * Contenido de tabs
     */
    protected function _htmlTabContent(){
        $html = "<div class=\"tab-content\">";
        $primero = true;
        foreach($this->_lista_marcadores as $grupo => $instalaciones){
            
            $class = "";
            if($primero){
                $class = "active";
            }
            
            $id = md5($grupo);
            
            $html .= "<div role=\"tabpanel\" class=\"tab-pane top-spaced ".$class."\" id=\"" . $id . "\">";
            
            $html = $this->_htmlTableInstalaciones($instalaciones);
            
            $html .= "</div>";
            
            $primero = false;
        }
        
        $html .= "</div>";
        
        return $html;
    }
    
    /**
     * Tabla con las instalaciones
     * @param type $instalaciones
     * @return string
     */
    protected function _htmlTableInstalaciones($instalaciones){
        if(count($instalaciones)>0){
            $html = "<table class=\"table table-hover datatable paginada\">"
                   ."<thead>"
                   ."<tr>";
            
            $columnas = reset($instalaciones);
            if(isset($columnas["NOMBRE"])){
                $html .= "<th>NOMBRE</th>";
                unset($columnas["NOMBRE"]);
            }
            
            foreach($columnas as $key => $void){
                $html .= "<th>" . $key . "</th>";
            }
            
            $html .= "</tr>"
                   . "</thead>"
                   . "<tbody>";
      
            foreach($instalaciones as $key => $datos){ 
                $html .= "<tr>";
                if(isset($datos["NOMBRE"])){
                    $html .= "<td>" . $datos["NOMBRE"] . "</td>";
                    unset($datos["NOMBRE"]);
                }
                
                foreach($datos as $nombre => $valor){
                    $html .= "<td>" . $valor . "</td>";
                }
                $html .= "</tr>";
            }
            $html .= "</tbody>"
                    ."</table>";
        } else {
            $html = "<div class=\"alert alert-info\">No existen instalaciones</div>";
        }
        
        return $html;
    }
    
    /**
     * Cabecera Tabs
     * @return string
     */
    protected function _htmlTabHeader(){
        $html = "<ul class=\"nav nav-tabs\" role=\"tablist\">";
        
        $primero = true;
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
        
        
        
        $html .= "</ul>";
        
        return $html;
    }
}

