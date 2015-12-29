<?php

/**
 * Genera el menu izquierdo
 * para el admin
 */
Class Layout_Menu_Render{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $ci;
    
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
     * Paginas del menu
     * @var array 
     */
       protected $_paginas = array("Dashboard" => array("icon_class" => "fa-dashboard",
                                                        "controller" => "home",
                                                        "action" => "index",
                                                        "child" => array()),   

                                   "Alarmas" => array("icon_class" => "fa-bell",
                                                      "permiso" => "alarma",
                                                      "controller" => "alarma",
                                                      "action" => "index",
                                                      "child" => array()),   
                                   "Emergencias" => array("icon_class" => "fa-bullhorn",
                                                      "permiso" => "emergencia",
                                                      "controller" => "emergencia",
                                                      "action" => "listado",
                                                      "child" => array()), 
                                   "Administrador de capas" => array("icon_class" => "fa-globe",
                                                      "permiso" => "capas",
                                                      "controller" => "capas",
                                                      "action" => "ingreso",
                                                      "child" => array()),  
                                   "Simulación" => array("icon_class" => "fa-flag-checkered",
                                                         "permiso" => "simulacion",
                                                         "controller" => "session",
                                                         "action" => "inicia_simulacion",
                                                         "child" => array()), 
                                   "Documentación" => array("icon_class" => "fa-book",
                                                            "permiso" => "documentacion",
                                                            "controller" => "mantenedor_documentos",
                                                            "action" => "index",
                                                            "child" => array()), 
                                   "Soportes" => array("icon_class" => "fa-question-circle",
                                                            "controller" => "",
                                                            "action" => "",
                                                            "child" => array("Mesa Regional" => array(
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_soportes"),
                                                                            "Mesa Central" => array(
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_soportes_central")
                                                                             )),
           
                                   "Mesa de ayuda" => array("icon_class" => "fa-question-circle",
                                                            "child" => array("Mensajes" => array(
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_usuario")
                                                                             )
                                                                    ),
                                    "Usuarios" => array("icon_class" => "fa-users",
                                                            "controller" => "",
                                                            "action" => "",
                                                            "child" => array("Mantenedor" => array(
                                                                                            "controller" => "mantenedor_usuario",
                                                                                            "action"     => "index"),
                                                                             "Permisos" => array(
                                                                                            "controller" => "permiso",
                                                                                            "action"     => "index")
                                                                             )),
                                );
    
    
    /**
     * 
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->library("usuario");
        $this->_controller = $this->ci->router->fetch_class();
        $this->_action = $this->ci->router->fetch_method();
        $this->usuario = New Usuario();
    }
       
       
    /**
     * Genera el menu izquierdo
     */
    public function render(){
        $html = "";
        foreach($this->_paginas as $name => $datos){
            $ver = true;
            
            if(isset($datos["permiso"])){
                $this->usuario->setModulo($datos["permiso"]);
                $ver = $this->usuario->getPermisoVer();
            }
            
            if($ver){
                if(count($datos['child'])>0){
                    $target = strtolower(str_replace(" ", "", $name));

                    $child = $this->_listChildren($datos['child']);

                    $class = "";
                    if($child['active']){
                        $class = "in";
                    }

                    $html .= $this->ci->load->view("pages/layout/menu-header-child", 
                                                   array("icon_class" => $datos['icon_class'],
                                                         "name"       => $name,
                                                         "class"      => $class,
                                                         "target"     => $target,
                                                         "child"      => $child['html']), true);

                }else{

                    if(is_array($datos['controller'])){
                        $controller = $datos['controller'][0];
                    } else {
                        $controller = $datos['controller'];
                    }

                    $html .= $this->ci->load->view("pages/layout/menu-header", 
                                                   array("icon_class" => $datos['icon_class'],
                                                         "name"       => $name,
                                                         "url"        => $controller . "/" . $datos["action"]), true);
                }
            }
        }
        
        return $html;
    }
    
    /**
     * Lista los hijos del menu
     * @param array $paginas
     * @return string html
     */
    protected function _listChildren($paginas){
        $html = "";
        $active = false;
        if(count($paginas)>0){
            foreach($paginas as $name => $datos){
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
                
                $html .= $this->ci->load->view("pages/layout/menu-item", 
                                               array("name" => $name,
                                                     "class" => $class,
                                                     "url" => "/" . $controller . "/" . $action), true);

            }
        }
        return array("html" => $html,
                     "active" => $active);
    }
}

