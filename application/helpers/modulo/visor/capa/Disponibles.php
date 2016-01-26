<?php

Class Visor_Capa_Disponibles{
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_capa_model;
    
    /**
     *
     * @var Capa_Geometria_Model 
     */
    protected $_capa_geometria_model;
    
    /**
     *
     * @var Capa_Poligono_Informacion_Model
     */
    protected $_capa_poligono_model;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_comunas;
    
    /**
     *
     * @var array 
     */
    protected $_categorias;
    
    /**
     * 
     * @param array $lista
     */
    public function __construct($lista_categorias, $comunas) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_model");
        $this->_ci->load->model("capa_geometria_model");
        $this->_ci->load->model("capa_poligono_informacion_model");
        $this->_capa_model = New Capa_Model();
        $this->_capa_geometria_model = New Capa_Geometria_Model();
        $this->_capa_poligono_model = New Capa_Poligono_Informacion_Model();
        $this->_comunas = $comunas;
        $this->_categorias = $lista_categorias;
    }
    
    public function render(){
        $html = $this->_htmlTabCategoriaHeader()
               .$this->_htmlTabCategoriaContent();
        return $html;
    }
    
    public function _renderCapa($id_categoria){
        $html = $this->_htmlTabCapaHeader($id_categoria);
        $html .= $this->_htmlTabCapaContent($id_categoria);
        return $html;
    }
    
    protected function _htmlTabCapaHeader($id_categoria){
        $html = "<ul class=\"nav nav-tabs\" role=\"tablist\">";
        
        $lista_capas = $this->_capa_model->listarCapasPorComunasYCategoria($id_categoria, $this->_comunas);
        
        $primero = true;
        foreach($lista_capas as $key => $capa){
            
            $class = "";
            if($primero){
                $class = "active";
            }
            
            $html  .= "<li role=\"presentation\" class=\"" . $class . "\">"
                   . "<a style=\"font-size:10px\" href=\"#capa_" . $capa["cap_ia_id"] . "\" aria-controls=\"".$capa["cap_ia_id"]."\" role=\"tab\" data-toggle=\"tab\">".$capa["cap_c_nombre"]."</a>"
                   . "</li>";
            
            $primero = false;
        }
        
        
        
        $html .= "</ul>";
        
        return $html;
    }
    
    /**
     * Contenido de tabs
     */
    protected function _htmlTabCapaContent($id_categoria){
        $html = "<div class=\"tab-content\">";
        $primero = true;
        
        $lista_capas = $this->_capa_model->listarCapasPorComunasYCategoria($id_categoria, $this->_comunas);
        foreach($lista_capas as $key => $capa){
            
            $class = "";
            if($primero){
                $class = "active";
            }
            
            $html .= "<div role=\"tabpanel\" class=\"tab-pane top-spaced ".$class."\" id=\"capa_" . $capa["cap_ia_id"] . "\">";
            
            $subcapas = $this->_capa_geometria_model->listarPorCapaComuna($capa["cap_ia_id"], $this->_comunas);
            
            $html .= "<div class=\"col-lg-12\">".$this->_ci->load->view("pages/mapa/grilla-subcapas", array("subcapas" => $subcapas, "id_capa" => $capa["cap_ia_id"]), true)."</div>";
            
            $html .= "</div>";
            
            $primero = false;
        }
        
        $html .= "</div>";
        
        return $html;
    }
    
    /**
     * Contenido de tabs
     */
    protected function _htmlTabCategoriaContent(){
        $html =   "<div class=\"col-xs-9\">"
                . "<div class=\"tab-content\">";
        $primero = true;
        foreach($this->_categorias as $grupo => $categoria){
            
            $class = "";
            if($primero){
                $class = "active";
            }
            
            
            $html .= "<div role=\"tabpanel\" class=\"tab-pane ".$class."\" id=\"categoria_" . $categoria["id_categoria"] . "\">";
            
            $html .= "<div class=\"col-lg-12\">" . $this->_renderCapa($categoria["id_categoria"]) . "</div>";
            
            $html .= "</div>";
            
            $primero = false;
        }
        
        $html .= "</div>"
               . "</div>";
        
        return $html;
    }
    
    protected function _htmlTabCategoriaHeader(){
        $html = "<div class=\"col-xs-3\">"
              . "<ul class=\"nav nav-pills tabs-left\" role=\"tablist\">";
        fb($this->_categorias);
        $primero = true;
        foreach($this->_categorias as $key => $categoria){
            
            $class = "";
            if($primero){
                $class = "active";
            }
            
            $html  .= "<li role=\"presentation\" class=\"" . $class . "\">"
                   . "<a style=\"font-size:10px\" href=\"#categoria_" . $categoria["id_categoria"] . "\" aria-controls=\"".$categoria["id_categoria"]."\" role=\"tab\" data-toggle=\"tab\">".$categoria["nombre_categoria"]."</a>"
                   . "</li>";
            
            $primero = false;
        }
        
        
        
        $html .= "</ul>"
               . "</div>";
        
        return $html;
    }
}
