<?php

//require_once(FCPATH . "application/models/region_model.php");
//require_once(FCPATH . "application/models/comuna_model.php");

/**
 * Genera el menu izquierdo
 * para el admin
 */
Class Layout_Menu_Render
{

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
     * Paginas del menu
     * @var array
     */

       protected $_paginas = array("Inicio" => array("icon_class" => "fa-dashboard",
                                                        "controller" => "home",
                                                        "action" => "index",
                                                        "child" => array()),   
                                   "Eventos" => array("icon_class" => "fa-bullhorn",
                                                      "permiso" => "emergencia",
                                                      "controller" => "evento",
                                                      "action" => "index",
                                                      "child" => array()), 
                                   "Visor" => array(
                                        "icon_class" => "fa-globe",      
                                        "permiso" => "capas",
                                        "child" => array(
                                            "Capas" => array(
                                                "controller" => "capas",
                                                "action"     => "ingreso"
                                            ),
                                            "Mapa" => array(
                                               "controller" => "visor",
                                               "action"     => "index")
                                            )
                                    ),
 
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
           
                                    /*"Hospitales" => array(
                                        "icon_class" => "fa-hospital-o",
                                        "controller" => "hospital",
                                        "action" => "index",
                                        "child" => array()
                                    ),*/ 

                                    "Isla de pascua" => array(
                                        "modulo" => Modulo_Model::SUB_CASOS_FEBRILES,
                                        "acceso" => array(
                                            "region" => array(Region_Model::REGION_VALPARAISO),
                                            "comuna" => array(Comuna_Model::ISLA_DE_PASCUA)
                                        ),
                                        "icon_class" => "fa-warning",      
                                        "child" => array(
                                            
                                            "Casos febriles" => array(
                                                "controller" => "formulario",
                                                "action"     => "index"
                                            ),
                                            
                                            "Embarazos" => array(
                                               "permiso" => "embarazada",
                                               "controller" => "embarazo",
                                               "action"     => "index"
                                            ),
                                            /*"Monitoreo de Trampas" => array(
                                                "controller" => "trampas",
                                                "action" => "index"
                                            )*/
                                            /*
                                            "Vacunación Antirrábica" => array(

                                              
                                               "controller" => "rabia_vacunacion",
                                               "action"     => "index"
                                            )*/
                                        ),
                                    ),
                                    "Marea roja" => array("icon_class" => "fa-warning",
                                                            "permiso" => "marea_roja",
                                                            "controller" => "marea_roja",
                                                            "action" => "index",
                                                            "child" => array()), 
                                    "Vectores" => array(

                                        "icon_class" => "fa-warning",      
                                        "permiso" => "vectores",
                                        "child" => array(
                                            "Denuncias" => array(
                                                "controller" => "vectores",
                                                "action"     => "index"
                                            ),
                                            "Trampas" => array(
                                               "controller" => "vectores_trampas",
                                               "action"     => "index"
                                            ),
                                            "Inspecciones" => array(
                                               "controller" => "vectores_hallazgos",
                                               "action"     => "index"
                                            ),

                                        ),
                                    ),
                                    "Usuarios" => array("icon_class" => "fa-users",
                                                        "rol" => "administrador",
                                                        "controller" => "",
                                                        "action" => "",
                                                        "child" => array("Personas" => array(
                                                                                        "controller" => "mantenedor_usuario",
                                                                                        "action"     => "index"),
                                                                         "Roles" => array(
                                                                                        "controller" => "mantenedor_rol",
                                                                                        "action"     => "index")
                                                                         )),
                                   /*"Mesa de ayuda" => array("icon_class" => "fa-question-circle",
                                              
                                                            "child" => array("Mensajes" => array(
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_usuario"),
                                                                             "Mesa Regional" => array(
                                                                                            "rol" => "administrador",
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_soportes"),
                                                                             "Mesa Central" => array(
                                                                                            "rol" => "administrador",
                                                                                            "controller" => "soportes",
                                                                                            "action"     => "bandeja_soportes_central")
                                                                             )
                                                                    ),*/
                                    
                                );
    
    
    /**
     *
     */
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library(
            array(
                "usuario",
                "session",
                "core/string/arreglo"
            )
        );

        $this->ci->load->model("comuna_model", "_usuario_comuna_model");
        $this->ci->load->model("rol_model", "rol_model");
        $this->ci->load->model("usuario_region_model", "_usuario_region_model");
        
        
        
        $this->_controller = $this->ci->router->fetch_class();
        $this->_action = $this->ci->router->fetch_method();
        $this->usuario = New Usuario();
        $this->_session = New CI_Session();
    }
       
    /**
     * Genera el menu izquierdo
     */
    public function render()
    {
        $html = "";
        foreach ($this->_paginas as $name => $datos) {


            if ($this->_ver($datos)) {
                if (count($datos['child']) > 0) {
                    $target = strtolower(str_replace(" ", "", $name));

                    $child = $this->_listChildren($datos['child']);

                    $class = "";
                    if ($child['active']) {
                        $class = "in";
                    }

                    $html .= $this->ci->load->view("pages/layout/menu-header-child",
                        array("icon_class" => $datos['icon_class'],
                            "name" => $name,
                            "class" => $class,
                            "target" => $target,
                            "child" => $child['html']), true);

                } else {

                    if (is_array($datos['controller'])) {
                        $controller = $datos['controller'][0];
                    } else {
                        $controller = $datos['controller'];
                    }

                    $html .= $this->ci->load->view("pages/layout/menu-header",
                        array("icon_class" => $datos['icon_class'],
                            "name" => $name,
                            "url" => $controller . "/" . $datos["action"]), true);
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
    protected function _listChildren($paginas)
    {
        $html = "";
        $active = false;
        if (count($paginas) > 0) {
            foreach ($paginas as $name => $datos) {

                if ($this->_ver($datos)) {

                    $class = "";

                    if (is_array($datos['controller'])) {
                        if ($this->_action == $datos['action'] AND in_array($this->_controller, $datos['controller'])) {
                            $class = "active";
                            $active = true;
                        }
                        $controller = $datos['controller'][0];
                    } else {
                        if ($this->_action == $datos['action'] AND $this->_controller == $datos['controller']) {
                            $class = "active";
                            $active = true;
                        }
                        $controller = $datos['controller'];
                    }


                    if (isset($datos["wildcard"])) {
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
        }
        return array("html" => $html,
            "active" => $active);
    }
    
    /**
     * Si el usuario puede ver el menu o no
     * @param array $datos
     * @return boolean
     */
    protected function _ver($menu)
    {
        $ver = true;
        if (isset($menu["permiso"])) {

            switch ($menu["permiso"]) {
                case "casos_febriles":
                    $this->usuario->setModulo($menu["permiso"]);
                    $ver = $this->usuario->getPermisoReporteEmergencia() || $this->usuario->getPermisoEditar() || $this->usuario->getPermisoEliminar() || $this->usuario->getPermisoActivarAlarma();
                    break;
                case "embarazada":
                    $this->usuario->setModulo("casos_febriles");
                    $ver = $this->usuario->getPermisoEmbarazada();
                    break;
                default:
                    $this->usuario->setModulo($menu["permiso"]);
                    $ver = $this->usuario->getPermisoVer();
                    break;
            }
        } else {
            $retorno = true;
            if(isset($menu["modulo"])) {
                $id_modulo = $menu["modulo"];

                if(isset($menu["acceso"])){
                    $retorno = false;

                    if(isset($menu["acceso"]["region"])){
                        $regiones_usuario = $this->ci->_usuario_region_model->listarPorUsuario($this->ci->session->userdata('session_idUsuario'));
                        fb($regiones_usuario);
                        foreach($menu["acceso"]["region"] as $id_region){
                            if(in_array($id_region, $this->ci->arreglo->arrayToArray($regiones_usuario, "id_region"))){
                                $retorno = true;
                            }
                        }
                    }

                    if($retorno && isset($menu["acceso"]["comuna"])){
                        $ver_comuna = false;
                        $comunas_usuario = $this->ci->_usuario_comuna_model->listarComunasPorUsuario($this->ci->session->userdata('session_idUsuario'));
                        fb($comunas_usuario);
                        
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

                $ver = $retorno;
            }
        }
   
        if (isset($menu["rol"]) and $menu["rol"] == "administrador") {
            $roles = explode(",", $this->_session->userdata("session_roles"));
            $existe = array_search(Rol_Model::ADMINISTRADOR, $roles);
            if ($existe === false) {
                $ver = false;
            }
        }
        return $ver;
    }
}

