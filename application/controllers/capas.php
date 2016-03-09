<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");

class Capas extends MY_Controller 
{
    /**
     *
     * @var Usuario 
     */
    public $usuario;
    
    /**
     *
     * @var Capa_Model
     */
    public $capa_model;
    
    /**
     *
     * @var Capa_Detalle_Elemento_Model 
     */
    public $capa_detalle_elemento_model;
    
    /**
     *
     * @var Comuna_Model 
     */
    public $comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        sessionValidation();
        $this->load->library("usuario");
        $this->load->model("capa_model", "capa_model");
        $this->load->model("capa_detalle_elemento_model", "capa_detalle_elemento_model");
        $this->load->model("comuna_model","comuna_model");
        $this->usuario->setModulo("capas");
    }
    
    public function index() {
        if (!file_exists(APPPATH . "/views/pages/capa/index.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        $data = array();

        $this->template->parse("default", "pages/capa/index", $data);
    }

    public function ingreso() {
        if (!file_exists(APPPATH . "/views/pages/capa/ingreso.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        
        
        if($this->usuario->getPermisoEditar()){
            if(isset($params["tab"])){
                $tab = $params["tab"];
            } else {
                $tab = "nuevo";
            }
        } else {
            $tab = "listado";
        }
        
        $data = array(
            "editar" => false,
            "tab_activo" => $tab
        );

        $this->template->parse("default", "pages/capa/ingreso", $data);
    }
    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/capa/listado.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();
        $data = array(
            
        );

        $this->load->view("pages/capa/listado", $data, false);
    }
    
    
    function ajax_grilla_capas_unicas() {
        $this->load->helper(array("modulo/capa/capa","file"));
        $lista = $this->capa_model->listarCapasUnicas();
        $this->load->view("pages/capa/grilla_capas", array("lista" => $lista));
    }

    function ajax_grilla_capas() {
        $id_capa = $this->input->post('id_capa');
        $this->load->helper(array("modulo/capa/capa","file"));
        $lista = $this->capa_model->listarCapas($id_capa);
        $this->load->view("pages/capa/grilla_capas_detalle", array("lista" => $lista));
    }


    function ajax_grilla_items_subcapas() {

        $id_subcapa = $this->input->post('subcapa');
        $this->load->helper(array("modulo/capa/capa"));

        $arr_items = array();
        $arr_cabeceras = array();
        $subcapa = $this->capa_model->getSubCapa($id_subcapa);

        $arr_cabeceras = explode(",",$subcapa['cap_c_propiedades']);
        /*$lista = $this->capa_model->listarItemsSubCapas($id_subcapa);
        if($lista){
            foreach($lista as $item){
                $arr_propiedades = array();
                $propiedades = unserialize($item['poligono_propiedades']);
                foreach($arr_cabeceras as $cabecera){
                    $arr_propiedades[] = $propiedades[$cabecera];
                }
                $arr_items[] = array(
                    'comuna' => $item['com_c_nombre'],
                    'provincia' => $item['prov_c_nombre'],
                    'region' => $item['reg_c_nombre'],
                    'id' => $item['poligono_id'],
                    'propiedades' => $arr_propiedades
                );
            }
        }*/

        $data = array(
            /*"lista" => $arr_items, */
            "cabeceras" => $arr_cabeceras,
            "subcapa" => $id_subcapa);
        $this->load->view("pages/capa/grilla_capas_items_subcapa", $data);
    }


    public function ajax_grilla_items_subcapas_server(){
        

        $this->load->database();
        $params = $this->uri->uri_to_assoc();
        $subcapa = $params['subcapa'];

        $this->load->model('capa_model','capa_model');
        $sub_capa = $this->capa_model->getSubCapa($subcapa);

        $arr_cabeceras = explode(",",$sub_capa['cap_c_propiedades']);

        $aColumns = array('com_c_nombre', 'prov_c_nombre', 'reg_c_nombre','poligono_propiedades','poligono_id');
                
                // DB table to use
        $sTable = 'capas_poligonos_informacion';
        //
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $where = ' WHERE poligono_capitem = '.$subcapa;
        $limit = '';
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $limit .= ' LIMIT '.$iDisplayStart.','.$iDisplayLength;
            //$this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        $order = '';
        if(isset($iSortCol_0))
        {

            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    if(empty($order)){
                        $order .= ' ORDER BY ';
                    }
                    $order .= $aColumns[intval($this->db->escape_str($iSortCol))].' '.$sSortDir;
                    //$this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if(isset($sSearch) && !empty($sSearch))
        {
            $like = '';
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering

                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    if(!empty($like)){
                        $like .= ' OR ';
                    }
                    $like .= $aColumns[$i].' LIKE "%'.$sSearch.'%"';
                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }

            $where .= ' AND ('.$like.') ';
        }


        $query = 'select SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)). ' from '.$sTable.' ';
        $query .= 'LEFT JOIN comunas c ON c.com_ia_id = capas_poligonos_informacion.poligono_comuna
                    LEFT JOIN provincias p ON p.prov_ia_id = c.prov_ia_id
                    LEFT JOIN regiones r ON r.reg_ia_id = p.reg_ia_id ';
        $query = $query . $where . $order . $limit;
        /*$this->db->where('poligono_capitem',$subcapa);
        $this->db->join('comunas c','c.com_ia_id = capas_poligonos_informacion.poligono_comuna','inner');
        $this->db->join('provincias p','p.prov_ia_id = c.prov_ia_id','inner');
        $this->db->join('regiones r','r.reg_ia_id = p.reg_ia_id','inner');*/
        
        // Select Data
        //$this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);

        //$rResult = $this->db->get($sTable);
        $rResult = $this->db->query($query);


        // Data set length after filtering
        $foundRows = $this->db->query('select FOUND_ROWS() AS found_rows');
        $foundRows = $foundRows->result_array();
        $iFilteredTotal = $foundRows[0]['found_rows'];
    
        // Total data set length
        //$iTotal = $this->db->count_all($sTable);ex
    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iFilteredTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        
        foreach($rResult->result_array() as $aRow)
        {
            $row = array();
            
            foreach($aColumns as $col)
            {
                if($col == 'poligono_propiedades'){
                    
                    $arr_propiedades = array();
                    $propiedades = unserialize($aRow['poligono_propiedades']);
                    
                    foreach($arr_cabeceras as $cabecera){
                        $row[] = $propiedades[$cabecera];
                    }
                    
                }elseif($col == 'poligono_id'){
                    $buttons = '<a class="btn btn-xs btn-default btn-square" onclick="Layer.editarItemSubcapa('.$aRow[$col].');" >
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-xs btn-danger btn-square" onclick="Layer.eliminarItemSubcapa('.$aRow[$col].','.$subcapa.')">
                                    <i class="fa fa-trash"></i>
                                </a>';
                    $row[] = $buttons;
                }else{
                    $row[] = $aRow[$col];    
                }
                
            }
    
            $output['aaData'][] = $row;
        }
    
        echo json_encode($output);
    }


    public function validarCapaEmergencia(){
        $this->load->helper(array("session", "debug"));
        $id_capa = $this->input->post('capa');

        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->validarCapaEmergencia($id_capa) > 0){
            $json['estado'] = true;
        }else{
            $json['estado'] = false;
        }

        echo json_encode($json);
    }


    public function validarSubCapaEmergencia(){
        $this->load->helper(array("session", "debug"));
        $id_capa = $this->input->post('capa');

        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->validarSubCapaEmergencia($id_capa) > 0){
            $json['estado'] = true;
        }else{
            $json['estado'] = false;
        }

        echo json_encode($json);
    }


    public function eliminarCapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_capa = $this->input->post('capa');

        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->eliminarCapa($id_capa)){
            $json['estado'] = true;
            $json['mensaje'] = 'La capa ha sido eliminada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al eliminar la capa. Intente nuevamente';
        }

        echo json_encode($json);
    }


    public function eliminarSubCapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_subcapa = $this->input->post('subcapa');

        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->eliminarSubCapa($id_subcapa)){
            $json['estado'] = true;
            $json['mensaje'] = 'La subcapa ha sido eliminada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al eliminar la subcapa. Intente nuevamente';
        }

        echo json_encode($json);
    }
    
    public function guardarCapa() {
        fb("guardar capa");
        $this->load->helper("session");
        sessionValidation();
        $params = $this->input->post();

        $this->load->helper("session");
        $this->load->model("capa_model", "CapaModel");
        echo $this->CapaModel->guardarCapa($params);
    }

    public function obtenerJsonCatCoberturas() {
        $this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $json = array();

        foreach ($CategoriaCobertura as $c) {
            $json[] = array(
                $c["ccb_ia_categoria"],
                $c["ccb_c_categoria"]
            );
        }

        echo json_encode($json);
    }

    public function eliminarItemSubcapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_item = $this->input->post('item');

        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->eliminarItemSubCapa($id_item)){
            $json['estado'] = true;
            $json['mensaje'] = 'Item eliminado correctametne';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al eliminar el item. Intente nuevamente';
        }

        echo json_encode($json);
    }


    public function editarCapa(){


        /*$id_capa = $this->input->post('capa');*/
        $params = $this->uri->uri_to_assoc();
        $id_capa = $params['capa'];
        $this->load->model("capa_model", "CapaModel");

        $this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $categorias = array();

        foreach ($CategoriaCobertura as $c) {
            $categorias[] = array(
                'categoria_id' => $c["ccb_ia_categoria"],
                'categoria_nombre' => $c["ccb_c_categoria"]
            );
        }

        $this->load->model('comuna_model','ComunaModel');
        $comunas = $this->ComunaModel->getComunasPorRegion($this->session->userdata['session_region_codigo']);

        $capa = $this->CapaModel->getCapa($id_capa);

        /** leer geojson asociado **/
        $properties = explode(",",$capa->cap_c_propiedades);
        $tmp_prop_array = array();

        
        $data = array(
            'id_capa' => $id_capa,
            'capa' => $capa,
            'categorias' => $categorias,
            'geojson' => $properties
            );
        $this->load->view("pages/capa/edicion",$data);
    }


    public function editarSubCapa(){
        $params = $this->uri->uri_to_assoc();
        $id_capa = $params['subcapa'];
        $this->load->model("capa_model", "CapaModel");

        /*$this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $categorias = array();

        foreach ($CategoriaCobertura as $c) {
            $categorias[] = array(
                'categoria_id' => $c["ccb_ia_categoria"],
                'categoria_nombre' => $c["ccb_c_categoria"]
            );
        }

        $this->load->model('comuna_model','ComunaModel');
        $comunas = $this->ComunaModel->getComunasPorRegion($this->session->userdata['session_region_codigo']);*/

        $capa = $this->CapaModel->getSubCapa($id_capa);

        /** leer geojson asociado **/
        /*$properties = array();
        $tmp_prop_array = array();


        $fp = file_get_contents(base_url($capa->capa,'r'));

        $arr_properties = json_decode($fp,true);

        foreach ($arr_properties['features'][0]['properties'] as $k => $v) {

            if (in_array($k, $tmp_prop_array)) { // reviso que no se me repitan las propiedades
                continue;
            }
            $properties[] = $k;
            $tmp_prop_array[] = $k;
        }*/
        $this->load->helper(array("modulo/capa/capa"));
        $data = array(
            'id_capa' => $id_subcapa,
            'capa' => $capa
        );
        $this->load->view("pages/capa/edicion_subcapa",$data);
    }

    /**
     * Muestra formulario para editar
     * elemento de una capa
     */
    public function editarItemSubcapa(){
        $this->load->helper(array("session", "debug"));
        $params = $this->uri->uri_to_assoc();
        $id_item = $params['item'];

        $this->load->model('capa_model','CapaModel');

        $item = $this->CapaModel->getItemSubCapa($id_item);
        $data = array();

        $data['id_item']    = $item['poligono_id'];
        $data['id_subcapa'] = $item['poligono_capitem'];
        $data['subcapa']    = $item['geometria_nombre'];
        $data['comuna']     = $item['com_c_nombre'];
        $data['provincia']  = $item['prov_c_nombre'];
        $data['region']     = $item['reg_c_nombre'];
        $data['capa']       = $item['cap_c_nombre'];
        $data['id_region']  = $item['reg_ia_id'];
        $data['geozone']    = $item['reg_geozone'];
        $data['propiedades'] = unserialize($item['poligono_propiedades']);
        $data['geometria'] = unserialize($item['poligono_geometria']);
        
        switch ($data['geometria']['type']) {
            case "Point":
                $data['latitud'] = $data['geometria']['coordinates'][1]; 
                $data['longitud'] = $data['geometria']['coordinates'][0];
                break;
            case "Polygon":
                $data['latitud'] = $data['geometria']['coordinates'][0][0][1]; 
                $data['longitud'] = $data['geometria']['coordinates'][0][0][0];
                break;
            default:
                break;
        }

        $data['js'] = $this->load->view('pages/mapa/js-plugins',array());
        $this->load->view("pages/capa/edicion_item_subcapa",$data);
    }


    public function nuevoItemSubCapa(){
        $params = $this->uri->uri_to_assoc();
        $this->load->model('capa_model','CapaModel');

        $subcapa = $this->CapaModel->getSubCapa($params['subcapa']);
        $data['id_subcapa'] = $params['subcapa'];
        $data['subcapa']    = $subcapa['geometria_nombre'];
        $data['capa']       = $subcapa['cap_c_nombre'];
        $propiedades = explode(',',$subcapa['cap_c_propiedades']);
        foreach($propiedades as $prop){
            $arr_propiedades[$prop] = '';
        }
        $data['propiedades'] = $arr_propiedades;
        $data['boton_cerrar'] = true;
        $data['id_item']    = 0;
        $data['tipo'] = 'Point';

        $data['js'] = $this->load->view('pages/mapa/js-plugins',array());
        $this->load->view("pages/capa/edicion_item_subcapa",$data);
    }
    
    /**
     * Guarda un elemento de una capa
     */
    public function guardarItemSubcapa(){
        
        
        
        $item = $this->uri->uri_to_assoc();
        $id_item = $item['item'];
        $params = $this->input->post();
        $id_subcapa = $params['id_subcapa'];
        $data = array();

        foreach($params["propiedad_nombre"] as $key => $nombre){
            $propiedades[$nombre] = $params["propiedad_valor"][$key];
        }

        $this->load->library("capa/elemento/capa_elemento_locacion", $propiedades);
        $this->capa_elemento_locacion->process();
        $data["poligono_comuna"] = $this->capa_elemento_locacion->getComuna();
        $data["poligono_provincia"] = $this->capa_elemento_locacion->getProvincia();
        $data["poligono_region"] = $this->capa_elemento_locacion->getRegion();
        
        $data["poligono_propiedades"] = serialize($propiedades);
        
        if($id_item > 0){
            $elemento = $this->capa_detalle_elemento_model->getById($id_item);
            $geometria = unserialize($elemento->poligono_geometria);

            switch ($geometria["type"]) {
                case "Point":
                    $geometria["coordinates"][1] = $params["latitud"];
                    $geometria["coordinates"][0] = $params["longitud"];
                    $data["poligono_geometria"] = serialize($geometria);
                    break;

                default:
                    break;
            }
        }else{
            $item_subcapa = $this->capa_model->listarItemsSubCapas($id_subcapa,1);
            $item_subcapa = $item_subcapa[0];
            $geometria = unserialize($item_subcapa['poligono_geometria']);
            $data['poligono_capitem'] = $id_subcapa;
            switch ($geometria["type"]) {
                case "Point":
                    $geometria["coordinates"][1] = $params["latitud"];
                    $geometria["coordinates"][0] = $params["longitud"];
                    $data["poligono_geometria"] = serialize($geometria);
                    break;

                default:
                    break;
            }
            
        }
        

        $json = array();
        if($id_item > 0){
            $guardar = $this->capa_detalle_elemento_model->update($data, $id_item);    
        }else{
            $guardar = $this->capa_detalle_elemento_model->insert($data);
        }
        
        if($guardar){
            $json['estado'] = true;
            $json['mensaje'] = "Datos guardados correctamente";
        }else{
            $json['estado'] = false;
            $json['mensaje'] = "Hubo un problema al guardar los datos. Intente nuevamente";
        }

        echo json_encode($json);
    }


    public function subir_CapaIconTemp(){
        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->library("cache");
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $tmp_name = $_FILES['input_icono_subcapa']['tmp_name'];
        $nombres = $_FILES['input_icono_subcapa']['name'];
        $size = $_FILES['input_icono_subcapa']['size'];
        $type = $_FILES['input_icono_subcapa']['type'];

        $fp = file_get_contents($tmp_name, 'r');


        $nombre_cache_id = 'icon_subcapa_temp_'.  uniqid();
        $binary_path = ('media/tmp/'.$nombre_cache_id);
        $ftmp = fopen($binary_path, 'w');
        fwrite($ftmp, $fp);

        $arr_cache= array(
            'filename' => $nombres,
            'nombre_cache_id' => $nombre_cache_id,
            'content' => $fp,
            'size'=> $size,
            'type'=> $type

        );
        $cache = Cache::iniciar();
        $cache->save($arr_cache, $nombre_cache_id);
       

        echo json_encode(array("uploaded" => 1, 'nombre_cache_id' => $nombre_cache_id, 'ruta'=>base_url($binary_path)));
    }



    public function guardarSubCapa(){
        $params = $this->input->post();
        $this->load->model('capa_model','CapaModel');

        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();

        $guardar = $this->CapaModel->guardarSubCapa($params);
        $json = array();
        if($guardar){
            $json['estado'] = true;
            $json['mensaje'] = 'Subcapa guardada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al guardar la subcapa. Intente nuevamente';
        }

        echo json_encode($json);


    }


    public function mostrarErroresCargaCapas(){
        $params = $this->uri->uri_to_assoc();

        if(is_file('media/tmp/comunas_'.$params['capa'])){
            $capa = unserialize(file_get_contents('media/tmp/comunas_'.$params['capa']));
            $data = array('comunas' => $capa, 'capa' => $params['capa']);
            $this->load->view("pages/capa/errores_comunas", $data);
        }else{
            echo "No existe el registro relacionado con la capa";
        }
        
    }


    public function eliminarErroresCargaCapas(){
        $capa = $this->input->post('capa');

        $response = array();
        if(unlink('media/tmp/comunas_'.$capa)){
            $response['estado'] = true;
            $response['mensaje'] = 'Información eliminada';
        }else{
            $response['estado'] = false;
            $response['mensaje'] = 'Problemas al eliminar la información. Intente nuevamente';
        }

        echo json_encode($response);
    }


    public function verComunas(){
        $this->load->model('comuna_model','ComunaModel');
        $comunas = $this->ComunaModel->listar();
        $this->load->view('pages/capa/listado_comunas',array('comunas' => $comunas));
    }


    public function nuevaCapa(){

        $this->load->view('pages/capa/nueva_capa');

    }


    public function verDetalleCapa(){
        $params = $this->uri->uri_to_assoc();
        $data = array();
        $data['capa'] = $params['capa'];
        $this->load->view('pages/capa/detalle_capa',$data);
    }


    public function listadoItemsSubcapa(){
        $params = $this->uri->uri_to_assoc();
        $data = array('subcapa' => $params['subcapa']);

        $this->load->model('capa_model','CapaModel');
        $subcapa = $this->CapaModel->getSubCapa($params['subcapa']);
        $agregarItem = false;
        if(!empty($subcapa['icon_path']) and empty($subcapa['color']))
            $agregarItem = true;

        $data['agregar_item'] = $agregarItem;
        $this->load->view('pages/capa/listado_items_subcapa',$data);
    }
    
    public function subir_CapaTemp() {
        $this->load->library("capa/capageojson");
        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $properties = array();
        $arr_filename = array();
        $tmp_prop_array = array();
        $tipo_geometria = array();

        $error = false;
        $error_mensaje = '';



        /* validar archivos */
        if(isset($_FILES['input-capa-geojson'])){
            $nombre = explode(".",$_FILES['input-capa-geojson']['name']);
            $ext = end($nombre);
            if($ext != 'geojson'){
                $error = true;
                $error_mensaje = 'Extensión no válida para archivo GeoJSON';
            }
        }elseif(isset($_FILES['input-capa-shape'])){
            $nombres = $_FILES['input-capa-shape']['name'];
            for($i=0; $i<sizeof($nombres); $i++){
                $nombre = explode(".",$nombres[$i]);
                $ext = end($nombre);

                if($ext != 'shp' and $ext != 'dbf'){
                    $error = true;
                    $error_mensaje = 'Extensión no válida para archivo Shape';
                }
            }
        }



        if($error === false){

            $prefijo = uniqid();

            if(isset($_FILES['input-capa-geojson'])){
                $tipo = 'geojson';
                $tmp_name = $_FILES['input-capa-geojson']['tmp_name'];
                $nombres = $_FILES['input-capa-geojson']['name'];
                $size = $_FILES['input-capa-geojson']['size'];
                $type = $_FILES['input-capa-geojson']['type'];

                $nombre_geojson = 'media/tmp/capa_'.$prefijo.'_'.$nombres;
                $tmp_geojson = 'media/tmp/tmp_'.$prefijo.'_'.$nombres;
                $geojson = fopen($nombre_geojson, 'w');
                fwrite($geojson,file_get_contents($tmp_name));
                fclose($geojson);

                $mapsharper = shell_exec('node --expose-gc /usr/bin/mapshaper -i '.$nombre_geojson.' -simplify 35% -o format=geojson '.$tmp_geojson);

                unlink($nombre_geojson);

            }else{
                $tipo = 'shape';
                $tmp_name = $_FILES['input-capa-shape']['tmp_name'];
                $nombres = $_FILES['input-capa-shape']['name'];
                $size = $_FILES['input-capa-shape']['size'];
                $type = $_FILES['input-capa-shape']['type'];

                for($i = 0; $i < sizeof($tmp_name); $i++){
                    $extension = explode('.', $nombres[$i]);
                    $ext = end($extension);
                    if($ext == 'shp'){
                        $nombre_capa = 'media/tmp/capa_'.$prefijo.'_'.$nombres[$i];
                        $ext_geojson = str_replace('.shp','.geojson',$nombres[$i]);
                        $tmp_geojson = 'media/tmp/tmp_'.$prefijo.'_'.$ext_geojson;
                        $geojson = fopen($nombre_capa, 'w');
                        fwrite($geojson,file_get_contents($tmp_name[$i]));
                        fclose($geojson);
                    }else{
                        $nombre_dbf = 'media/tmp/capa_'.$prefijo.'_'.$nombres[$i];
                        $geojson = fopen($nombre_dbf, 'w');
                        fwrite($geojson,file_get_contents($tmp_name[$i]));
                        fclose($geojson);
                    }


                }

                $log = array();
                $mapsharper = exec('node --expose-gc /usr/bin/mapshaper -i '.$nombre_capa.' -simplify 35% -o format=geojson '.$tmp_geojson, $log, $retorno);
                
                fb($log);
                fb($retorno);
                fb($tmp_geojson);
                
                unlink($nombre_capa);
                unlink($nombre_dbf);


            }



            $arr_error_filenames = array();

            $poligono = null;
            $icono = null;


            if(is_file($tmp_geojson)){
                $fp = file_get_contents($tmp_geojson, 'r');
                $nombre_archivo = end(explode("/",$tmp_geojson));
                $size = filesize($tmp_geojson);
                $type = mime_content_type($tmp_geojson);
            }else{
                $fp = file_get_contents($tmp_name, 'r');
                $nombre_archivo = $nombres;
            }

            $error = false;
            /*$fp = file_get_contents($tmp_geojson, 'r');*/

            $arr_properties = json_decode(utf8_encode($fp),true);

            // var_dump($arr_properties['features'][0]['properties']);die;

            if (!isset($arr_properties['features'][0]['properties'])) {
                $error = true;
                $arr_error_filenames[] = $nombres[$i];
            } else {
                $nombre_cache_id = 'file_temp_'.  uniqid();
                $arr_cache= array(
                    'filename' => $nombre_archivo,
                    'nombre_cache_id' => $nombre_cache_id,
                    'content' => $fp,
                    'size'=> $size,
                    'type'=> $type

                );
                /*$this->cache->save($nombre_cache_id, $arr_cache, 28800);*/
                $file = fopen('media/tmp/'.$nombre_cache_id,'w+b');
                fwrite($file,serialize($arr_cache));
                fclose($file);

                /* ejecutar script para reducir geojson */


                foreach ($arr_properties['features'][0]['properties'] as $k => $v) {

                    if (in_array($k, $tmp_prop_array)) { // reviso que no se me repitan las propiedades
                        continue;
                    }
                    $properties['data'][] = array($k,
                        "<input class='propiedades' id='prop_$k' name='prop_$k' type='checkbox' checked=checked  />");
                    $tmp_prop_array[] = $k;
                }

                $arr_filename['data'][] = array(
                    $nombres[$i],
                    "<select name=iComunas_".($i+1)." id=iComunas_".($i+1)." class='form-control iComunas required' placeholder='Comuna de la capa' ></select> <input name=tmp_file_".($i+1)." id=tmp_file_".($i+1)." value='$nombre_cache_id' type=hidden />",
                );

                $this->capageojson->setGeojson($arr_properties);
                $geometrias = $this->capageojson->listGeometry();

                if(in_array("Polygon", $geometrias) OR in_array("MultiPolygon", $geometrias) or in_array("MultiLineString", $geometrias)){
                    $poligono = array("Poligonos",
                        "<input name=\"color_poligono\" id=\"color_poligono\" placeholder=\"Color del poligono o linea\" type='text' class=\"colorpicker required\" value=\"\"/>");
                }

                if(in_array("Point", $geometrias)){
                    $icono = array("Icono",
                        "<select name=\"icono_color\" id=\"icono_color\" style=\"width: 300px\" placeholder=\"Icono de los marcadores\" class=\" select2-images required\">"
                        . "<option value=\"\"></option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi.png")."\">Rojo</option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi-yellow.png")."\">Amarillo</option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi-blue.png")."\">Azul</option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi-green.png")."\">Verde</option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi-pink.png")."\">Rosado</option>"
                        . "<option value=\"". base_url("assets/img/markers/spotlight-poi-black.png")."\">Negro</option>"
                        . "</select>");
                }

            }



            if(!is_null($poligono))
                $tipo_geometria['data'][] = $poligono;

            if(!is_null($icono))
                $tipo_geometria['data'][] = $icono;

        }
        



        echo ($error) ? json_encode(array("uploaded" => 0, 
                                          "error_filenames" => $arr_error_filenames,
                                          "error_mensaje" => $error_mensaje,
                                          'properties' => $properties, 
                                          'filenames' => $arr_filename,
                                          'geometry' => $tipo_geometria)) 
                      : json_encode(array("uploaded" => 1,
                                            'nombre_cache_id' => $nombre_cache_id,
                                            'error_mensaje' => $error_mensaje,
                                            'properties' => $properties,
                                            'filenames' => $arr_filename,
                                            'geometry' => $tipo_geometria));
    }


}