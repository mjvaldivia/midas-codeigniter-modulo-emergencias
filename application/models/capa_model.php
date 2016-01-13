<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "capas";
    
    /**
     * Retorna registro por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("cap_ia_id", $id);
    }
    
    public function guardarCapa($params) {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->helper('utils');
        $this->load->model("archivo_model", "ArchivoModel");
        $this->load->model("comuna_model", "ComunaModel");
        $error = false;
        $lista_propiedades = '';



        foreach ($params as $k => $v) {

            if (strstr($k, 'prop_')) {
                if ($lista_propiedades != '') {
                    $lista_propiedades.=',';
                }
                $lista_propiedades.=substr($k, 5);
            }
        }

        if(isset($params['capa_edicion']) and $params['capa_edicion'] > 0){

            if($params['items'] == 0){
                $comuna = $params['comuna_editar'];
            }else{
                $comuna = $params['iComunas_1'];
            }
            
            $query = "UPDATE capas set cap_c_nombre = ?, cap_c_geozone_number = ?, cap_c_geozone_letter = ?, com_ia_id = ?, ccb_ia_categoria = ?, cap_c_propiedades = ? where cap_ia_id = ?";
            $parametros = array($params['nombre_editar'],$params['gznumber_editar'],$params['gzletter'],$comuna,$params['iCategoria_editar'],$lista_propiedades,$params['capa_edicion']);

            $this->db->trans_begin();
            $this->db->query($query,$parametros);

            $cap_ia_id = $params['capa_edicion'];

            /* si existe nueva capa */
            if(isset($params['tmp_file_1'])){
                $capa = $this->cache->get($params['tmp_file_1']);   //capa 
                    
                $capa_obj_arch_json = $this->ArchivoModel->upload_to_site($capa['filename'], $capa['type'], null, $cap_ia_id, $this->ArchivoModel->TIPO_CAPA, $capa['size'], $capa['nombre_cache_id'], $params['nombre_editar']);

                $capa_arch_ia_id = json_decode($capa_obj_arch_json)->id;

                $this->db->query("
                        UPDATE capas SET capa_arch_ia_id = $capa_arch_ia_id 
                        where cap_ia_id =" . $cap_ia_id
                );
            }
            
            $update = array();
            if(isset($params["color_editar"])){
                $update["color"] = $params["color_editar"];
            } 

            if(isset($params["icono_editar"])){
                $update["icon_path"] = $params["icono_editar"];
            }

            $this->_query->update($update, "cap_ia_id", $cap_ia_id);
            
            if ($this->db->trans_status() === FALSE) {
                $error = true;
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
                
        }else{

            $this->load->model('categoria_cobertura_model','CategoriaCapa');
            $categoria_capa = $this->CategoriaCapa->getById($params['iCategoria']);
            $geometria_capa = $categoria_capa['ccb_n_tipo'];

            $this->db->trans_begin();
            $this->db->query("
                        INSERT INTO capas(cap_c_nombre,
                        cap_c_geozone_number,
                        cap_c_geozone_letter,
                        ccb_ia_categoria,
                        cap_c_propiedades
                        )
                        VALUES
                        (
                           '" . $params['nombre'] . "',
                           '" . $params['gznumber'] . "',
                           '" . $params['gzletter'] . "',
                           '" . $params['iCategoria'] . "',
                           '" . $lista_propiedades . "'
                        )
                        ");

            $cap_ia_id = $this->db->insert_id();

            $capa = $this->cache->get($params['tmp_file']);
            $capa_content = json_decode($capa['content']);

            $capa_obj_arch_json = $this->ArchivoModel->upload_to_site($capa['filename'], $capa['type'], null, $cap_ia_id, $this->ArchivoModel->TIPO_CAPA, $capa['size'], $capa['nombre_cache_id'], $params['nombre']);

            $capa_arch_ia_id = json_decode($capa_obj_arch_json)->id;

            $update = array();


            //$update["capa_arch_ia_id"] = $capa_arch_ia_id;

            if(isset($params["color_poligono"])){
                $update["color"] = $params["color_poligono"];
            }

            if(isset($params["icono_color"])){
                $icono_color = explode(base_url(),$params["icono_color"]);
                $update["icon_path"] = trim($icono_color[1],"/");
            }

            $this->_query->update($update, "cap_ia_id", $cap_ia_id);

            $items_capa = $capa_content->features;
            foreach($items_capa as $item){

                $geometria = serialize((array)$item->geometry);

                $tipo = '';
                if(!isset($item->properties->TIPO)){
                    $item->properties->TIPO = $tipo = mb_strtoupper($params['nombre']);
                    $properties = (array)$item->properties;
                    $properties = addslashes(serialize($properties));
                }else{
                    if(is_null($item->properties->TIPO) or empty($item->properties->TIPO)){
                        $tipo = mb_strtoupper($params['nombre']);
                    }else{
                        $tipo = $item->properties->TIPO;
                    }
                }

                $properties = (array)$item->properties;
                $properties = addslashes(serialize($properties));

                /* obtener comuna */
                $comuna = $this->ComunaModel->getByNombre($item->properties->COMUNA);
                if(is_null($comuna)){
                    continue;
                }
                $comuna = $comuna[0];

                $tipo = mb_strtoupper($tipo);

                $query = "select geometria_id,count(geometria_nombre) as existe_tipo from capas_geometria where geometria_nombre like '$tipo' and geometria_tipo = $geometria_capa and geometria_capa = $cap_ia_id";
                $result = $this->db->query($query);
                $result = $result->result_array();

                if($result[0]['existe_tipo'] == 0){
                    $query = "insert into capas_geometria(geometria_capa,geometria_tipo,geometria_nombre) value($cap_ia_id,$geometria_capa,'$tipo')";

                    $insert = $this->db->query($query);
                    $query = "select geometria_id from capas_geometria where geometria_nombre like '$tipo' and geometria_tipo = $geometria_capa and geometria_capa = $cap_ia_id order by geometria_id DESC limit 1";
                    $result = $this->db->query($query);
                    $result = $result->result_array();

                    $id_tipo = $result[0]['geometria_id'];

                }else{
                    $id_tipo = $result[0]['geometria_id'];
                }

                $query = "insert into capas_poligonos_informacion(poligono_capitem,poligono_comuna,poligono_propiedades,poligono_geometria) value($id_tipo,$comuna->com_ia_id,'$properties','$geometria')";
                $insertar = $this->db->query($query);


            }

            /*$this->db->query("
                    UPDATE capas SET capa_arch_ia_id = $capa_arch_ia_id, icon_arch_ia_id = $icon_arch_ia_id
                    where cap_ia_id =" . $cap_ia_id
            );*/

            if ($this->db->trans_status() === FALSE) {
                $error = true;
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }


        }

        

        echo ($error) ? 0 : 1;
    }
    
    /**
     * Retorna capas por comuna
     * @param array $lista_comunas
     * @return array
     */
    public function listarCapasPorComunasYCategoria($id_categoria, array $lista_comunas){
        $result = $this->_query->select("DISTINCT c.*")
                               ->from("capas c")
                               ->join("capas_geometria g", "g.geometria_capa = c.cap_ia_id", "INNER")
                               ->join("capas_poligonos_informacion p", "p.poligono_capitem = g.geometria_id")
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->whereAND("c.ccb_ia_categoria", $id_categoria, "=")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Retorna capas por comuna
     * @param array $lista_comunas
     * @return array
     */
    public function listarCapasPorComunas(array $lista_comunas){
        $result = $this->_query->select("DISTINCT c.*")
                               ->from("capas c")
                               ->join("capas_geometria g", "g.geometria_capa = c.cap_ia_id", "INNER")
                               ->join("capas_poligonos_informacion p", "p.poligono_capitem = g.geometria_id")
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }

    public function obtenerTodos($eme_ia_id, $ids = null) {
        $error = 0;
        $jsonData = array();
        $sql = "
            select
                GROUP_CONCAT(evc.com_ia_id) comunas
            from
              emergencias e 
              join emergencias_vs_comunas evc on e.eme_ia_id = evc.eme_ia_id
            where e.eme_ia_id = $eme_ia_id";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        $where = '';
        if ($row[0]['comunas']) {
            $where = "where c.com_ia_id IN (" . $row[0]["comunas"] . ")";
        } else {
            $error = 1;
        }

        if ($error == 0) {
            $result = $this->db->query(" SELECT c.*, cc.ccb_c_categoria from 
                capas c join categorias_capas_coberturas cc 
                on c.ccb_ia_categoria = cc.ccb_ia_categoria
                $where");

            $arr_ids = array();
            if ($ids == !null) {
                $arr_ids = explode(',', $ids);
            }
            foreach ($result->result_array() as $row) {
                if (in_array($row['cap_ia_id'], $arr_ids)) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }

                array_push($jsonData, array(
                    'chkbox' => "<input type=checkbox $checked id='chk_" . $row['cap_ia_id'] . "' name='chk_" . $row['cap_ia_id'] . "' onclick='VisorMapa.selectCapa(" . $row['cap_ia_id'] . ");' />",
                    'cap_c_nombre' => $row['cap_c_nombre'],
                    'ccb_c_categoria' => $row['ccb_c_categoria'],
                    'cap_ia_id' => $row['cap_ia_id'],
                    'arch_c_nombre' => $row['icon_path']
                ));
            }
        }
        echo json_encode($jsonData);
    }

    public function getjson($id) {
        $this->load->helper("url");
        $result = $this->db->query(" SELECT c.cap_ia_id, "
                                         . "c.cap_c_nombre, "
                                         . "a.arch_c_nombre as capa,"
                                         . "c.icon_path, "
                                         . "c.color, "
                                         . "c.cap_c_propiedades, "
                                         . "c.cap_c_geozone_number, "
                                         . "c.cap_c_geozone_letter  "
                                 . "from capas c join archivo a on c.capa_arch_ia_id = a.arch_ia_id "
                                 . "where cap_ia_id = $id");
        $row = $result->result_array();
        $str = file_get_contents(BASEPATH . "../" . utf8_decode($row[0]['capa']));

        $res = array(
            'id' => $row[0]['cap_ia_id'],
            'nombre' => $row[0]['cap_c_nombre'],
            'capa' => base_url($row[0]['capa']),
            'icono' => $row[0]['icon_path'],
            'color' => $row[0]['color'],
            'propiedades' => $row[0]['cap_c_propiedades'],
            'geozone' => $row[0]['cap_c_geozone_number'] . $row[0]['cap_c_geozone_letter'],
            'json_str' => $str,
        );

        echo json_encode($res);
    }
    
    /**
     * Lista todas las capas
     * @return array
     */
    public function listarCapasUnicas(){
        $sql = "select cc.ccb_c_categoria,  c.*, CONCAT(c.cap_c_geozone_number,c.cap_c_geozone_letter) geozone

        from capas c
            join categorias_capas_coberturas cc on cc.ccb_ia_categoria = c.ccb_ia_categoria GROUP BY cap_c_nombre";
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return $result->result_array();
        } else{
            return null;
        }
    }

    public function listarCapas($id_capa=null){
        $where = '';
        if(!is_null($id_capa)){
            $where .= ' where c.geometria_capa = '.$id_capa;
        }
        $sql = "select cc.ccb_c_categoria, c.*,cap.*, CONCAT(cap.cap_c_geozone_number,cap.cap_c_geozone_letter) geozone,
  (select count(*) as total from capas_poligonos_informacion where poligono_capitem = c.geometria_id) as total_items from capas_geometria c
                left join capas cap on cap.cap_ia_id = c.geometria_capa
                join categorias_capas_coberturas cc on cc.ccb_ia_categoria = cap.ccb_ia_categoria
                " . $where;

        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return $result->result_array();
        } else{
            return null;
        }
    }

    function getCapa($id_capa) {

        $sql = "select cc.ccb_c_categoria, a.arch_c_hash,a.arch_c_nombre capa, c.*, CONCAT(c.cap_c_geozone_number,c.cap_c_geozone_letter) geozone from capas c 
                join archivo a on c.capa_arch_ia_id = a.arch_ia_id
                join categorias_capas_coberturas cc on cc.ccb_ia_categoria = c.ccb_ia_categoria
                where c.cap_ia_id = ?";
        $result = $this->db->query($sql,array($id_capa));
        if($result->num_rows() > 0){
            $result = $result->result_object();
            return $result[0];
        }else{
            return null;
        }
        
    }

    function getSubCapa($id_subcapa) {
        $sql = "select * from capas_geometria
          left join capas on cap_ia_id = geometria_capa
          where geometria_id = ?";
        $result = $this->db->query($sql,array($id_subcapa));

        if($result->num_rows() > 0){
            $result = $result->result_array();
            return $result[0];
        }else{
            return null;
        }

    }


    public function validarCapaEmergencia($id_capa){
        /*$query = "select count(*) as total from emergencias
                where eme_c_capas like '$id_capa'
                or eme_c_capas like '$id_capa,%' 
                or eme_c_capas like '%,$id_capa' 
                or eme_c_capas like '%,$id_capa,%'";*/

        $query = "select count(ecg.id_geometria) as total from emergencias_capas_geometria ecg
          inner join capas_geometria cg on cg.geometria_id = ecg.id_geometria
          inner join capas c on c.cap_ia_id = cg.geometria_capa
          where c.cap_ia_id = ".$id_capa;

        $result = $this->db->query($query);
        $validate = $result->result_object();
        
        return $validate[0]->total;
    }


    public function validarSubCapaEmergencia($id_subcapa){

        $query = "select count(*) as total from emergencias_capas_geometria where id_geometria = ".$id_subcapa;

        $result = $this->db->query($query);
        $validate = $result->result_object();

        return $validate[0]->total;
    }


    public function eliminarCapa($id_capa){

        $this->db->trans_begin();

        $query = "select id_geometria from emergencias_capas_geometria
                    inner join capas_geometria on geometria_id = emergencias_capas_geometria.id_geometria
                    where geometria_capa = " . $id_capa;

        $result = $this->db->query($query);
        $subcapas = $result->result_array();

        foreach($subcapas as $subcapa){
            /* eliminar todos los items asociadas a la subcapa en cuestion */
            $query = "delete from capas_poligonos_informacion where poligono_capitem = " . $subcapa['id_geometria'];
            $delete = $this->db->query($query);

            /* eliminar registro de subcapa asociado con emergencia */
            $query = "delete from emergencias_capas_geometria where id_geometria = " . $subcapa['id_geometria'];
            $delete = $this->db->query($query);

            /* eliminar registro de subcapa de la tabla de capas_geometria */
            $query = "delete from capas_geometria where geometria_id = " . $subcapa['id_geometria'];
            $delete = $this->db->query($query);

        }

        /* eliminar capa */
        $query = "delete from capas where cap_ia_id = " . $id_capa;
        $delete = $this->db->query($query);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }


    }


    public function eliminarSubCapa($id_subcapa){

        $this->db->trans_begin();

        $query = "delete from capas_poligonos_informacion where poligono_capitem = " . $id_subcapa;
        if($this->db->query($query)){
            $query = "delete from emergencias_capas_geometria where id_geometria = " . $id_subcapa;
            $delete = $this->db->query($query);

            /* eliminar registro de subcapa de la tabla de capas_geometria */
            $query = "delete from capas_geometria where geometria_id = " . $id_subcapa;
            if($this->db->query($query)){
                $this->db->trans_commit();
                return true;
            }else{
                $this->db->trans_rollback();
                return false;
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }


    }


    public function eliminarItemSubCapa($id_item){
        $query = "delete from capas_poligonos_informacion where poligono_id = " .$id_item;
        if($this->db->query($query)){
            return true;
        }else{
            return null;
        }
    }


    public function guardarSubCapa($params){
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->model("archivo_model", "ArchivoModel");
        $this->load->model("comuna_model", "ComunaModel");

        $params = $this->input->post();





        $query = "update capas_geometria set geometria_nombre = ? where geometria_id = ?";
        if($this->db->query($query,array($params['nombre_subcapa'],$params['id_subcapa']))){
            if(isset($params['tmp_file_icono'])){
                $icono = $this->cache->get($params['tmp_file_icono']);

                $icono_ruta = explode(base_url(),$params["ruta_icono"]);
                $icono_ruta = $icono_ruta[1];
                $subir_icono = $this->ArchivoModel->upload_to_site($icono['filename'], $icono['type'], $icono_ruta, $params['id_capa'], $this->ArchivoModel->TIPO_ICONO_DE_CAPA, $icono['size'], $icono['nombre_cache_id']);
                if($subir_icono){
                    $subir_icono = json_decode($subir_icono);
                    $nombre_icono = 'media/doc/capa/'.$params['id_capa'].'/'.date(Y).'/'.$subir_icono->id . "_" . $subir_icono->filename;
                    $query = "update capas_geometria set geometria_icono = ? where geometria_id = ?";
                    $update = $this->db->query($query,array($nombre_icono,$params['id_subcapa']));
                }
            }elseif(isset($params['color_poligono'])){
                $query = "update capas_geometria set geometria_icono = ? where geometria_id = ?";
                $update = $this->db->query($query,array($params['color_poligono'],$params['id_subcapa']));
            }


            return true;
        }else{
            return null;
        }
    }


    public function listarItemsSubCapas($id_subcapa=null){
        $where = '';
        if(!is_null($id_subcapa) and is_numeric($id_subcapa)){
            $where .= ' where cp.poligono_capitem = '.$id_subcapa;
        }

        $query = "select cp.*,c.com_ia_id, c.com_c_nombre, p.prov_c_nombre,p.prov_ia_id, r.reg_ia_id,reg_c_nombre, cap.cap_c_propiedades as propiedades
          from capas_poligonos_informacion cp
          left join capas_geometria cg on cg.geometria_id = cp.poligono_capitem
          left join capas cap on cap.cap_ia_id = cg.geometria_capa
          left join comunas c on c.com_ia_id = cp.poligono_comuna
          left join provincias p on p.prov_ia_id = c.prov_ia_id
          left join regiones r on r.reg_ia_id = p.reg_ia_id " . $where;

        $result = $this->db->query($query);

        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return null;
        }
    }


}
