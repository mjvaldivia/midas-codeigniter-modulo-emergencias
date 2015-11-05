<?php

/**
 * Genera el menu izquierdo
 * para el admin
 */
Class Layout_Menu_Render{
    
    protected $ci;
        
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
                                                      "child" => array("Listado" => array("controller" => "alarma",
                                                                                          "action"     => "listado"),
                                                                       "Ingreso" => array("controller" => "alarma",
                                                                                          "action"     => "ingreso"))),                      
                                   "Emergencias" => array("icon_class" => "fa-bullhorn",
                                                          "child" => array("Listado" => array("controller" => "emergencia",
                                                                                              "action"     => "listado"),
                                                                           "Ingreso" => array("controller" => "emergencia",
                                                                                              "action" => "listado"))),       
                                   "Administrador de capas" => array("icon_class" => "fa-globe",
                                                                     "child" => array("Listado" => array("controller" => "capas",
                                                                                                         "action"     => "listado"),
                                                                                      "Ingreso" => array("controller" => "capas",
                                                                                                         "action" => "ingreso"))),  
                                   "Simulación" => array("icon_class" => "fa-flag-checkered",
                                                         "controller" => "",
                                                         "action" => "",
                                                         "child" => array()), 
           
                                   "Documentación" => array("icon_class" => "fa-book",
                                                            "controller" => "",
                                                            "action" => "",
                                                            "child" => array()), 
           
                                   "Mesa de ayuda" => array("icon_class" => "fa-question-circle",
                                                            "child" => array("Mensajes" => array("controller" => "",
                                                                                                "action"     => ""),
                                                                             "Soportes pendientes" => array("controller" => "",
                                                                                                            "action" => ""),
                                                                             "Soportes finalizados" => array("controller" => "",
                                                                                                             "action" => "")
                                                                             )
                                                                    ),   
                                );
    
    
    /**
     * 
     * @param  $ci
     */
    public function __construct($ci) {
        $this->ci = $ci;
        $this->_controller = $ci->router->fetch_class();
        $this->_action = $ci->router->fetch_method();
    }
       
       
    /**
     * Genera el menu izquierdo
     */
    public function render(){
        $html = "";
        foreach($this->_paginas as $name => $datos){
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
                $html .= $this->ci->load->view("pages/layout/menu-item", 
                                               array("name" => $name,
                                                     "class" => $class,
                                                     "url" => "/" . $controller . "/" . $datos['action']), true);

            }
        }
        return array("html" => $html,
                     "active" => $active);
    }
}

