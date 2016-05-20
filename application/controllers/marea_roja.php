<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Marea_roja extends MY_Controller
{

    /**
     *
     * @var Marea_Roja_Model
     */
    public $_marea_roja_model;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        sessionValidation();

        $this->load->model("marea_roja_model", "_marea_roja_model");
        $this->load->model("region_model", "_region_model");
        $this->load->model("modulo_model", "_modulo_model");
        $this->load->model("laboratorio_model", "_laboratorio_model");

        $this->load->helper(
            array(
                "modulo/usuario/usuario_form",
                "modulo/comuna/form",
                "modulo/marea_roja/permiso"
            )
        );
    }

    /**
     *
     */
    public function index()
    {
        $this->template->parse(
            "default",
            "pages/marea_roja/muestra/index",
            array()
        );
    }

    /**
     *
     */
    public function editar()
    {
        $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario",
                "modulo/direccion/region",
                "modulo/direccion/comuna",
                "modulo/usuario/usuario_form",
                "modulo/laboratorio/form"
            )
        );
        $params = $this->input->get(null, true);

        $caso = $this->_marea_roja_model->getById($params["id"]);
        if (!is_null($caso)) {

            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);

            $laboratorio = $this->_laboratorio_model->getById($caso->id_laboratorio);
            if (is_null($laboratorio)) {
                $laboratorio = $this->_laboratorio_model->getByName($propiedades->{"LABORATORIO"});
            }

            $id_laboratorio = "";
            if (!is_null($laboratorio)) {
                $id_laboratorio = $laboratorio->id;
            }


            $data = array(
                "id" => $caso->id,
                "id_laboratorio" => $id_laboratorio
            );

            foreach ($propiedades as $nombre => $valor) {
                $data["propiedades"][str_replace(" ", "_", strtolower($nombre))] = $valor;
            }

            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            

            $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
            $this->layout_assets->addJs("modulo/marea_roja/muestra/form.js");
            $this->template->parse("default", "pages/marea_roja/muestra/form", $data);
        }
    }

    /**
     *
     */
    public function eliminar()
    {
        $params = $this->input->post(null, true);
        $this->_marea_roja_model->delete($params["id"]);
        echo json_encode(
            array(
                "error" => array(),
                "correcto" => true
            )
        );
    }


    /**
     *
     */
    public function guardar()
    {
        $this->load->library(
            array(
                "rut",
                "marea_roja/marea_roja_validar"
            )
        );

        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        if ($this->marea_roja_validar->esValido($params)) {

            /** latitud y longitud **/
            $coordenadas = array(
                "lat" => $params["form_coordenadas_latitud"],
                "lng" => $params["form_coordenadas_longitud"]
            );

            unset($params["latitud"]);
            unset($params["longitud"]);
            /************************/

            $caso = $this->_marea_roja_model->getById($params["id"]);
            unset($params["id"]);
            /*****************/


            /** se preparan datos del formulario **/
            $arreglo = array();

            $laboratorio = $this->_laboratorio_model->getById($params["laboratorio"]);
            if (is_null($laboratorio)) {
                throw new Exception("No se ingreso el laboratorio");
            }

            foreach ($params as $nombre => $valor) {
                $nombre = str_replace("_", " ", $nombre);
                $arreglo[strtoupper($nombre)] = $valor;
            }

            $arreglo["LABORATORIO"] = $laboratorio->nombre;
            /*****************************************/


            if (is_null($caso)) {
                $id = $this->_marea_roja_model->insert(
                    array(
                        "fecha" => date("Y-m-d H:i:s"),
                        "id_region" => $params["region"],
                        "id_comuna" => $params["comuna"],
                        "id_laboratorio" => $laboratorio->id,
                        "numero_muestra" => $params["numero_de_muestra"],
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                        "id_usuario" => $this->session->userdata("session_idUsuario"),
                    )
                );
            } else {
                
                // parche para no borrar resultado si ya fue ingresado
                $propiedades = Zend_Json::decode($caso->propiedades);
                if(isset($propiedades["RESULTADO"])){
                    $arreglo["RESULTADO"] = $propiedades["RESULTADO"];
                }
                
                $this->_marea_roja_model->update(
                    array(
                        "id_region" => $params["region"],
                        "id_comuna" => $params["comuna"],
                        "id_laboratorio" => $laboratorio->id,
                        "numero_muestra" => $params["numero_de_muestra"],
                        "propiedades" => json_encode($arreglo),
                        "coordenadas" => json_encode($coordenadas),
                    ),
                    $caso->id
                );
                $id = $caso->id;
            }

            echo json_encode(
                array(
                    "error" => $this->marea_roja_validar->getErrores(),
                    "correcto" => true
                )
            );

        } else {
            echo json_encode(
                array(
                    "error" => $this->marea_roja_validar->getErrores(),
                    "correcto" => false
                )
            );
        }
    }

    /**
     *
     */
    public function nuevo()
    {
        $this->load->helper(
            array(
                "modulo/emergencia/emergencia",
                "modulo/formulario/formulario",
                "modulo/direccion/region",
                "modulo/direccion/comuna",
                "modulo/usuario/usuario_form",
                "modulo/laboratorio/form"
            )
        );

        $params = $this->uri->uri_to_assoc();

        $this->layout_assets->addJs("library/bootbox-4.4.0/bootbox.min.js");
        $this->layout_assets->addJs("modulo/marea_roja/muestra/form.js");
        $this->template->parse(
            "default",
            "pages/marea_roja/muestra/form",
            array(
                "fecha" => DATE("d/m/Y"),
                "ingresado" => $params["ingreso"],
                "region" => Region_Model::LOS_LAGOS,
                //"id_laboratorio" => Laboratorio_Model::LOS_RIOS,
                "latitud" => "-39.770306907243636",
                "longitud" => "-73.73030273437502"
            )
        );
    }

    /**
     *
     */
    public function ajax_form_excel()
    {
        $this->load->view("pages/marea_roja/muestra/form_excel", array("fecha" => date("d/m/Y")));
    }
    
    /**
     * Retorna el excel
     */
    public function excel(){
        $params = $this->uri->uri_to_assoc();
        
        $this->load->library(
            array(
                "core/excel/excel_json"
            )
        );
        
        $this->excel_json->setColumnas(
            array(
                "MUESTREO" => array(
                    "tipo" => "fila",
                    "valor" => "id"
                ),
                "FECHA DE TOMA DE MUESTRA" => array(
                    "tipo" => "json",
                    "valor" => "FECHA",
                    "metodo" => "FECHA",
                    "formato_entrada" => array(
                        "d/m/Y",
                        "d-m-Y"
                    ),
                    "formato_salida" => "d/m/Y"
                ),
                "FECHA INGRESO" => array(
                    "tipo" => "file",
                    "valor" => "fecha",
                    "metodo" => "FECHA",
                    "formato_entrada" => array(
                        "Y-m-d H:i:s"
                    ),
                    "formato_salida" => "d/m/Y"
                ),
                "ACTA" => array(
                    "tipo" => "fila",
                    "valor" => "numero_muestra"
                ),
                "RESULTADO" => array(
                    "tipo" => "json",
                    "valor" => "RESULTADO"
                ),
                "CALIDAD DE GEOREFERENCIACION" => array(
                    "tipo" => "json",
                    "valor" => "FORM COORDENADAS CALIDAD DE GEOREFERENCIACION"
                ),
                "LABORATORIO" => array(
                    "tipo" => "json",
                    "valor" => "LABORATORIO"
                ),
                "FUENTE DE LA INFORMACION" => array(
                    "tipo" => "json",
                    "valor" => "FUENTE DE LA INFORMACION"
                ),
                "RECURSO" => array(
                    "tipo" => "json",
                    "valor" => "RECURSO"
                ),
                "ORIGEN"  => array(
                    "tipo" => "json",
                    "valor" => "ORIGEN"
                ),
                "REGION"  => array(
                    "tipo" => "json",
                    "valor" => "REGION",
                    "metodo" => "NOMBRE_REGION"
                ),
                "COMUNA"  => array(
                    "tipo" => "json",
                    "valor" => "COMUNA",
                    "metodo" => "NOMBRE_COMUNA"
                ),
                "PROFUNDIDAD"  => array(
                    "tipo" => "json",
                    "valor" => "PROFUNDIDAD"
                ),
                "TEMPERATURA RECURSO"  => array(
                    "tipo" => "json",
                    "valor" => "TEMPERATURA"
                ),
                "TEMPERATURA AGUA"  => array(
                    "tipo" => "json",
                    "valor" => "TEMPERATURA AGUA"
                ),
                "VP"  => array(
                    "tipo" => "json",
                    "valor" => "VP"
                ),
                "OBSERVACIONES"  => array(
                    "tipo" => "json",
                    "valor" => "OBSERVACIONES",
                    "metodo" => "CORRECCION_SALTO_LINEA"
                ),
                "FISCALIZADOR" => array(
                    "tipo" => "file",
                    "valor" => "id_usuario",
                    "metodo" => "NOMBRE_USUARIO"
                ),
                "LATITUD" => array(
                    "tipo" => "json",
                    "valor" => "lat"
                ),
                "LONGITUD" => array(
                    "tipo" => "json",
                    "valor" => "lng"
                )
            )
        );
     
        $lista = $this->_filtrosExcel($params);
        
        $this->excel_json->setData($lista, array("coordenadas","propiedades"));
        $this->excel_json->render();
    }

    
    

    /**
     *
     */
    public function ajax_lista()
    {
        $params = $this->input->post(null, true);

        $this->load->model("usuario_region_model", "_usuario_region_model");

        $this->load->helper(array(
                "modulo/emergencia/emergencia",
                "modulo/usuario/usuario",
                "modulo/comuna/default"
            )
        );

        $this->load->library(
            array(
                "core/fecha/fecha_conversion",
                "core/string/arreglo"
            )
        );


        $lista = $this->_filtros($params);

        $casos = array();

        $roles = explode(',',$this->session->userdata('session_roles'));

        $subir_acta = false;
        $editar_muestra = true;
        if(in_array(27,$roles) or in_array(65,$roles)){
            $subir_acta = true;
        }
        if(in_array(65,$roles)){
            $editar_muestra = false;
        }

        if (!is_null($lista)) {
            $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

            foreach ($lista as $caso) {

                $fecha_formato = "";
                $fecha_ingreso = "";

                $propiedades = Zend_Json::decode($caso["propiedades"]);


                $fecha = $this->fecha_conversion->fechaToDateTime(
                    $propiedades["FECHA"],
                    array(
                        "d-m-Y",
                        "d/m/Y"
                    )
                );

                if ($fecha instanceof DateTime) {
                    $fecha_formato = $fecha->format("d/m/Y");
                }

                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if ($fecha instanceof DateTime) {
                    $fecha_ingreso = $fecha->format("d/m/Y");
                }

                $laboratorio = $this->_laboratorio_model->getById($caso["id_laboratorio"]);
                if (is_null($laboratorio)) {
                    $laboratorio_nombre = $propiedades["LABORATORIO"];
                } else {
                    $laboratorio_nombre = $laboratorio->nombre;
                }


                $casos[] = array(
                    "id" => $caso["id"],
                    "id_usuario" => $caso["id_usuario"],
                    "numero_muestra" => $caso["numero_muestra"],
                    "fecha_ingreso" => $fecha_ingreso,
                    "fecha_muestra" => $fecha_formato,
                    "recurso" => strtoupper($propiedades["RECURSO"]),
                    "origen" => strtoupper($propiedades["ORIGEN"]),
                    "bo_ingreso_resultado" => $caso["bo_ingreso_resultado"],
                    "comuna" => $caso["id_comuna"],
                    "laboratorio" => $laboratorio_nombre,
                    "resultado" => $propiedades["RESULTADO"],
                    "actas" => $this->MareaRojaActasModel->listar(array('id_marea' => $caso['id'])),
                    "subir_acta" => $subir_acta,
                    "editar_muestra" => $editar_muestra
                );

            }
        }

        $this->load->view("pages/marea_roja/muestra/grilla", array("lista" => $casos));
    }

    /**
     * Filtros para la lista
     * @param array $params
     * @return array
     */
    protected function _filtros($params)
    {
        print_r($params);die();
        return $this->_marea_roja_model->listar(
            array(
                "region" => $this->_filtrosRegion($params),
                "comuna" => $params["comuna"],
                "numero_muestra" => $params["numero_acta"]
            )
        );
    }
    
    /**
     * Filtros para la descarga de excel
     * @param array $params
     * @return array
     */
    protected function _filtrosExcel($params){
        $this->load->model("usuario_model");
        $this->load->model("usuario_region_model", "_usuario_region_model");
        
        $fecha_desde = null;
        if ($params["fecha_desde"] != "") {
            $fecha_desde = DateTime::createFromFormat("d_m_Y", $params["fecha_desde"]);
        }

        $fecha_hasta = null;
        if ($params["fecha_hasta"] != "") {
            $fecha_hasta = DateTime::createFromFormat("d_m_Y", $params["fecha_hasta"]);
        }
        
        return $this->_marea_roja_model->listar(
            array(
                "region" => $this->_filtrosRegion($params),
                "fecha_desde" => $fecha_desde, 
                "fecha_hasta" => $fecha_hasta
            )
        );
    }
    
    /**
     * Filtros de region
     * @param array $params
     * @return array
     */
    protected function _filtrosRegion($params)
    {
        if ($params["region"] != "") {
            $lista_regiones[0] = $params["region"];
        } else {
            $lista_regiones = $this->arreglo->arrayToArray(
                $this->_usuario_region_model->listarPorUsuario($this->session->userdata('session_idUsuario')),
                "id_region"
            );
        }
        return $lista_regiones;
    }


    public function adjuntarActa()
    {
        $params = $this->uri->uri_to_assoc();

        $data = array(
            'id' => $params['id']
        );
        $this->load->view('pages/marea_roja/muestra/acta', $data);
    }


    public function subir_acta()
    {

        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];

        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->library("cache");
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $tmp_name = $_FILES['acta']['tmp_name'];
        $total = count($tmp_name);
        $nombres = $_FILES['acta']['name'];
        $size = $_FILES['acta']['size'];
        $type = $_FILES['acta']['type'];

        $binary_path = ('media/doc/marea_roja/muestra/' . $id);
        if (!is_dir($binary_path)) {
            @mkdir($binary_path, 0777, true);
        }

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $json = array();
        $valido = 0;
        for ($i = 0; $i < $total; $i++) {
            $fp = file_get_contents($tmp_name[$i], 'r');

            $nombre = str_replace(' ', '_', $nombres[$i]);
            $sha = sha1($nombre);
            $mime = $type[$i];
            $ruta_archivo = $binary_path . '/' . $nombre;
            $ftmp = fopen($ruta_archivo, 'w');
            fwrite($ftmp, $fp);
            fclose($ftmp);
            if (is_file($ruta_archivo) and is_readable($ruta_archivo)) {
                $data = array(
                    'id_marea' => $id,
                    'id_usuario' => $this->session->userdata('session_idUsuario'),
                    'fc_fecha_acta' => date('Y-m-d H:i:s'),
                    'gl_nombre_acta' => $nombre,
                    'gl_ruta_acta' => $ruta_archivo,
                    'gl_mime_acta' => $mime,
                    'gl_sha_acta' => $sha
                );

                if($this->MareaRojaActasModel->insert($data)){
                    $valido++;
                }
            }

        }

        if($total == $valido){
            $json['estado'] = true;
            $json['mensaje'] = 'Archivo(s) subido(s) correctamente';
        }elseif($valido > 0 and $total>$valido){
            $json['estado'] = true;
            $json['mensaje'] = 'Hubieron algunos archivos que no se subieron';
        }elseif($valido == 0){
            $json['estado'] = false;
            $json['mensaje'] = 'Errores al subir archivos';
        }

        echo json_encode($json);

    }


    public function verActas(){
        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $arr_actas = array();
        $listado = $this->MareaRojaActasModel->listar(array('id_marea' => $id));
        if($listado){
            $arr_actas = $listado;
        }

        $this->load->view('pages/marea_roja/muestra/grilla_actas',array('listado'=>$arr_actas));
    }


    public function ver_acta(){
        $params = $this->uri->uri_to_assoc();
        $id = $params['id'];
        $sha = $params['token'];

        $this->load->model('marea_roja_actas_model','MareaRojaActasModel');

        $acta = $this->MareaRojaActasModel->getById($id);

        header('Content-type:'.$acta->gl_mime_acta);
        header('Content-disposition: inline; filename="'.$acta->gl_nombre_acta.'"');
        echo file_get_contents(FCPATH .$acta->gl_ruta_acta);
    }

}

