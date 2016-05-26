<?php

require_once(__DIR__ . "/../Abstract.php");

Class Visor_Menu_Categorias_CantidadCapasRegion extends Visor_Menu_Abstract{
    
    /**
     *
     * @var int 
     */
    protected $_id_region = null;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
 
    /**
     * Constructor
     */
    public function __construct($id_region) {
        $this->_id_region = $id_region;
        $this->_ci =& get_instance();
        $this->_ci->load->model("comuna_model", "_comuna_model");
        $this->_ci->load->model("provincia_model", "_provincia_model");
        $this->_ci->load->model("region_model", "_region_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        
        $this->_informacion();
    }
    
    /**
     * Informacion de emergencia
     */
    protected function _informacion(){
        $lista_comunas = $this->_ci->_comuna_model->getComunasPorRegion($this->_id_region);
        foreach($lista_comunas as $comuna){
            $this->_lista_emergencia_comunas[] = $comuna->com_ia_id;
        }
        
        $lista_provincias = $this->_ci->_provincia_model->listaProvinciasPorRegion($this->_id_region);
        foreach($lista_provincias as $provincia){
            $this->_lista_emergencia_provincias[] = $provincia["prov_ia_id"];
        }
        

        $this->_lista_emergencia_regiones[] = $this->_id_region;
        
    }
    
    /**
     * 
     * @param int $id_categoria
     * @return int
     */
    public function cantidad($id_categoria){
        return $this->_ci->_capa_model->cantidadCapasPorCategoria(
                $id_categoria,
                $this->_lista_emergencia_comunas,
                $this->_lista_emergencia_provincias,
                $this->_lista_emergencia_regiones
        );
    }
}

