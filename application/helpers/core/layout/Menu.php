<?php

//require_once(FCPATH . "application/models/region_model.php");
//require_once(FCPATH . "application/models/comuna_model.php");

/**
 * Genera el menu izquierdo
 * para el admin
 */
Class Layout_Menu{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $ci;
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    /**
     *
     * @var Usuario 
     */
    protected $usuario;
        
    /**
     * Nombre action actual
     * @var string 
     */
    protected $_action;
    
    /**
     * Nombre controlador actual
     * @var string 
     */
    protected $_controller;
    
    /**
     *Nombre modulo
     * @var string 
     */
    protected $_module;
    
    /**
     * Paginas del menu
     * @var array 
     */
    protected $_paginas = array(
        
        "Inicio" => array(
            "modulo" => "All",
            "icono"      => "fa fa-dashboard",
            "href" => array(
                "module"     => NULL,
                "controller" => "home",
                "action"     => "index",
            ),
            "child"      => array()
        ),   
        "Eventos" => array(
            "modulo" => Modulo_Model::SUB_MODULO_EMERGENCIA,
            "icono"      => "fa fa-bullhorn",
            "href" => array(
                "module"     => NULL,
                "controller" => "evento",
                "action"     => "index",
            ),
            "child"      => array()
        ), 
        
        
        "Visor" => array(
            "modulo" => Modulo_Model::SUB_MODULO_CAPAS,
            "icono" => "fa fa-globe",      
            "child" => array(
                "Capas" => array(
                    "accion" => "ver",
                    "controller" => "capas",
                    "action"     => "ingreso"
                ),
                "Mapa" => array(
                    "accion" => "mapa",
                    "controller" => "visor",
                    "action"     => "index"
                )
            ),
        ),
        
        "Simulación" => array(
            "modulo"       => Modulo_Model::SUB_SIMULACION,
            "icono"      => "fa fa-flag-checkered",
            "href" => array(
                "controller" => "session",
                "action"     => "inicia_simulacion",
            ),
            "child"      => array()
        ),
        
        "Documentación" => array(
            "modulo"       => Modulo_Model::SUB_DOCUMENTACION,
            "icono"      => "fa fa-book",
            "href" => array(
                "controller" => "mantenedor_documentos",
                "action"     => "index",
            ),
            "child"      => array()
        ),
        
        "Isla de pascua" => array(
            "modulo" => Modulo_Model::SUB_CASOS_FEBRILES,
            "acceso" => array(
                "region" => array(Region_Model::REGION_VALPARAISO),
                "comuna" => array(Comuna_Model::ISLA_DE_PASCUA)
            ),
            "icono" => "fa fa-warning",      
            "child" => array(
                "Casos febriles" => array(
                    "controller" => "casos_febriles_isla_de_pascua",
                    "action"     => "index",
                ),
                "Embarazos" => array(
                   "accion" => "embarazadas",
                   "controller" => "embarazo",
                   "action"     => "index",
                )
            ),
        ),
        
        "Marea roja los lagos" => array(
            "modulo" => Modulo_Model::SUB_MAREA_ROJA,
            "acceso" => array(
                "region" => array(Region_Model::LOS_LAGOS)
            ),
            "icono" => "fa fa-warning",      
            "child" => array(
                "Ingreso de muestras" => array(
                    "accion" => "muestra_con_resultado",
                    "controller" => "marea_roja_1",
                    "action"     => "index",
                ),
                "Ingreso resultados" => array(
                   "accion" => "resultados",
                   "controller" => "marea_roja_resultado",
                   "action"     => "index",
                )
            ),
        ),
        
        "Marea roja los ríos" => array(
            "modulo" => Modulo_Model::SUB_MAREA_ROJA,
            "acceso" => array(
                "region" => array(Region_Model::LOS_RIOS)
            ),
            "icono" => "fa fa-warning",      
            "child" => array(
                "Ingreso de muestras" => array(
                    "accion" => "muestra",
                    "controller" => "marea_roja",
                    "action"     => "index",
                ),
                "Derivar muestra" => array(
                    "accion" => "derivar",
                    "controller" => "marea_roja_derivar",
                    "action"     => "index",
                ),
                "Ingreso resultados" => array(
                   "accion" => "resultados",
                   "controller" => "marea_roja_resultado",
                   "action"     => "index",
                )
            ),
        ),
        
       
        "Vectores" => array(
            "modulo" => Modulo_Model::SUB_VECTORES,
            "icono" => "fa fa-warning",      
            "child" => array(
                "Denuncias" => array(
                    "controller" => "vectores",
                    "action"     => "index",
                ),
                "Trampas" => array(
                   "controller" => "vectores_trampas",
                   "action"     => "index",
                ),
                "Inspecciones" => array(
                   "controller" => "vectores_hallazgos",
                   "action"     => "index",
                )
            ),
        ),
        
        
        "Usuarios" => array(
            "modulo" => Modulo_Model::USUARIOS,
            "icono" => "fa fa-users",
            "child" => array(
                "Personas" => array(
                    "controller" => "mantenedor_usuario",
                    "action"     => "index"
                ),
                "Roles" => array(
                    "controller" => "mantenedor_rol",
                    "action"     => "index"
                )
            )
        ),


    );
    
    
    /**
     * 
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->library("session");
        $this->ci->load->model("rol_model", "rol_model");
        $this->ci->load->model("modulo_model","modulo_model");
        $this->ci->load->model("permiso_model","permiso_model");
        $this->ci->load->model("usuario_rol_model","usuario_rol_model");
        $this->ci->load->model("usuario_region_model","_usuario_region_model");
        $this->ci->load->model("comuna_model","_usuario_oficina_model");
        
        $this->ci->load->library("core/string/arreglo");
        
        $this->_controller = $this->ci->router->fetch_class();
        $this->_action = $this->ci->router->fetch_method();

    }
       
    /**
     * Genera el menu izquierdo
     */
    public function render(){
        $html = "";
        foreach($this->_paginas as $name => $menu){
            if($this->_puedeVer($menu)){
                if(isset($menu['child']) && count($menu['child'])>0){
                    $target = strtolower(str_replace(" ", "", $name));
                    $lista_hijos = $this->_listChildren($menu['child'], $menu["modulo"]);
                    $class = "";
                    if($lista_hijos['active']){
                        $class = "in";
                    }
                    $html .= $this->ci->load->view(
                        "templates/menu/menu-header-child", 
                        array(
                            "icon_class" => $menu['icono'],
                            "name"       => $name,
                            "class"      => $class,
                            "target"     => $target,
                            "child"      => $lista_hijos['html']
                        ), 
                        true
                    );
                } else {
                    $html .= $this->ci->load->view(
                        "templates/menu/menu-header", 
                        array(
                            "icon_class" => $menu['icono'],
                            "name"       => $name,
                            "url"        => $this->_armaUrl($menu["href"]['controller'], $menu["href"]["action"])
                        ), 
                        true
                    );
                }
            }
            
        }
        return $html;
    }
    
    /**
     * 
     * @param mixed $id_modulo
     * @return boolean
     */
    protected function _puedeVer($menu){
        
        $retorno = true;
        
        $id_modulo = $menu["modulo"];
        
        if(isset($menu["acceso"])){
            $retorno = false;
            
            if(isset($menu["acceso"]["region"])){
                $regiones_usuario = $this->ci->_usuario_region_model->listarPorUsuario($this->ci->session->userdata('session_idUsuario'));
                foreach($menu["acceso"]["region"] as $id_region){
                    if(in_array($id_region, $this->ci->arreglo->arrayToArray($regiones_usuario, "id_region"))){
                        $retorno = true;
                    }
                }
            }
            
            if($retorno && isset($menu["acceso"]["comuna"])){
                $ver_comuna = false;
                $comunas_usuario = $this->ci->_usuario_oficina_model->listarComunasPorUsuario($this->ci->session->userdata('session_idUsuario'));
                foreach($menu["acceso"]["comuna"] as $id_comuna){
                    if(in_array($id_comuna, $this->ci->arreglo->arrayToArray($comunas_usuario, "com_ia_id"))){
                        $ver_comuna = true;
                    }
                }
                $retorno = $ver_comuna;
            }
        }
        
        if($retorno){
            if($id_modulo != "All"){
                $lista_roles = $this->ci->usuario_rol_model->listarRolesPorUsuario($this->ci->session->userdata('session_idUsuario'));
                return $this->ci->permiso_model->verPermiso(
                    $this->ci->arreglo->arrayToString($lista_roles,",","rol_ia_id"), 
                    $id_modulo, 
                    "ver"
                );
            } else {
                $retorno = true;
            }
        }
        
        return $retorno;
    }
    
    /**
     * 
     * @param string $controlador
     * @param string $accion
     * @return string
     */
    protected function _armaUrl($controlador, $accion){
        return $controlador . "/" . $accion;
    }
    
    /**
     * Lista los hijos del menu
     * @param array $paginas
     * @return string html
     */
    protected function _listChildren($paginas, $modulo){
        
        $html = "";
        $active = false;
        if(count($paginas)>0){
            foreach($paginas as $name => $datos){
                
                $ver = true;
                
                if(!empty($datos["accion"])){
                    $lista_roles = $this->ci->usuario_rol_model->listarRolesPorUsuario($this->ci->session->userdata('session_idUsuario'));
                    $ver = $this->ci->permiso_model->verPermiso(
                        $this->ci->arreglo->arrayToString($lista_roles,",","rol_ia_id"), 
                        $modulo, 
                        $datos["accion"]
                    );
                }
                
                if($ver){
                    $class = "";

                    if(is_array($datos['controller'])){
                        if($this->_action == $datos['action'] AND in_array($this->_controller , $datos['controller'])){
                            $class = "active";
                            $active = true;
                        }
                        $controller = $datos['controller'][0];
                    } else {
                        if($this->_action == $datos['action'] AND $this->_controller == $datos['controller']){
                            $class = "active";
                            $active = true;
                        }
                        $controller = $datos['controller'];
                    }

                    if(isset($datos["wildcard"])){
                        $action = $datos["wildcard"];
                    } else {
                        $action = $datos['action'];
                    }
                    
                    if(isset($datos["modulo"])){
                        $url = "/" . $datos["modulo"] . "/" . $controller . "/" . $action;
                    } else {
                        $url = "/" . $controller . "/" . $action;
                    }
                    
                    $html .= $this->ci->load->view(
                        "templates/menu/menu-item", 
                        array(
                            "name" => $name,
                            "class" => $class,
                            "url" => $url
                        ), 
                        true
                    );
                }
            }
        }
        return array(
            "html" => $html,
            "active" => $active
        );
    }
}

