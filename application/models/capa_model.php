<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Capa_Model extends CI_Model {

    public function guardarCapa($params) {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->helper('utils');
        $this->load->model("archivo_model", "ArchivoModel");
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

            if(file_exists('media/tmp/' . $params['icon-editar'])){
                $icon_size = filesize('media/tmp/' . $params['icon-editar']);
                $icon_type = filetype('media/tmp/' . $params['icon-editar']);
                $tmp_name = 'media/tmp/' . $params['icon-editar']; 

                $icon_obj_arch_json = $this->ArchivoModel->upload_to_site('icono_capa', $icon_type, $tmp_name, $cap_ia_id, $this->ArchivoModel->TIPO_ICONO_DE_CAPA, $icon_size);

                $icon_arch_ia_id = json_decode($icon_obj_arch_json)->id;

                $this->db->query("
                        UPDATE capas SET icon_arch_ia_id = $icon_arch_ia_id 
                        where cap_ia_id =" . $cap_ia_id
                );


            }
            
            
            if ($this->db->trans_status() === FALSE) {
                $error = true;
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
                
        }else{

            for ($i = 1; $i <= $params['items']; $i++) {


                $this->db->trans_begin();
                $this->db->query("
                        INSERT INTO capas (cap_c_nombre, 
                        cap_c_geozone_number,
                        cap_c_geozone_letter,
                        com_ia_id,
                        ccb_ia_categoria,
                        cap_c_propiedades
                        )
                        VALUES
                        (
                           '" . $params['nombre'] . "',
                           '" . $params['gznumber'] . "',
                           '" . $params['gzletter'] . "',
                           '" . $params['iComunas_' . $i] . "',
                           '" . $params['iCategoria'] . "',
                           '" . $lista_propiedades . "'
                        )
                        ");

                $cap_ia_id = $this->db->insert_id();
                $capa = $this->cache->get($params['tmp_file_' . $i]);   //capa 

                $icon_size = filesize('media/tmp/' . $params['icon']);
                $icon_type = filetype('media/tmp/' . $params['icon']);
                $tmp_name = 'media/tmp/' . $params['icon'];


                $capa_obj_arch_json = $this->ArchivoModel->upload_to_site($capa['filename'], $capa['type'], null, $cap_ia_id, $this->ArchivoModel->TIPO_CAPA, $capa['size'], $capa['nombre_cache_id'], $params['nombre']);
                $icon_obj_arch_json = $this->ArchivoModel->upload_to_site('icono_capa', $icon_type, $tmp_name, $cap_ia_id, $this->ArchivoModel->TIPO_ICONO_DE_CAPA, $icon_size);

                $capa_arch_ia_id = json_decode($capa_obj_arch_json)->id;
                $icon_arch_ia_id = json_decode($icon_obj_arch_json)->id;


                $this->db->query("
                        UPDATE capas SET capa_arch_ia_id = $capa_arch_ia_id, icon_arch_ia_id = $icon_arch_ia_id 
                        where cap_ia_id =" . $cap_ia_id
                );

                if ($this->db->trans_status() === FALSE) {
                    $error = true;
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        }

        

        echo ($error) ? 0 : 1;
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
            $result = $this->db->query(" SELECT c.*, cc.ccb_c_categoria, a.arch_c_nombre from 
                capas c join categorias_capas_coberturas cc 
                on c.ccb_ia_categoria = cc.ccb_ia_categoria
                join archivo a on c.icon_arch_ia_id = a.arch_ia_id $where");

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
                    'arch_c_nombre' => $row['arch_c_nombre']
                ));
            }
        }
        echo json_encode($jsonData);
    }

    public function getjson($id) {
        $this->load->helper("url");
        $result = $this->db->query(" SELECT c.cap_ia_id, c.cap_c_nombre, a.arch_c_nombre capa,a2.arch_c_nombre icono,c.cap_c_propiedades, c.cap_c_geozone_number, c.cap_c_geozone_letter  from capas c join archivo a on c.capa_arch_ia_id = a.arch_ia_id join archivo a2 on c.icon_arch_ia_id = a2.arch_ia_id where cap_ia_id = $id");
        $row = $result->result_array();
        $str = file_get_contents($row[0]['capa']);

        $res = array(
            'id' => $row[0]['cap_ia_id'],
            'nombre' => $row[0]['cap_c_nombre'],
            'capa' => base_url($row[0]['capa']),
            'icono' => base_url($row[0]['icono']),
            'propiedades' => $row[0]['cap_c_propiedades'],
            'geozone' => $row[0]['cap_c_geozone_number'] . $row[0]['cap_c_geozone_letter'],
            'json_str' => $str,
        );

        echo json_encode($res);
    }

    function get_capas() {

        $this->load->helper('utils');


        $sql = "select cc.ccb_c_categoria, a.arch_c_hash,a.arch_c_nombre capa, b.arch_c_nombre icono, c.*, CONCAT(c.cap_c_geozone_number,c.cap_c_geozone_letter) geozone from capas c 
                join archivo a on c.capa_arch_ia_id = a.arch_ia_id
                join archivo b on c.icon_arch_ia_id = b.arch_ia_id
                join categorias_capas_coberturas cc on cc.ccb_ia_categoria = c.ccb_ia_categoria
                ";
        $result = $this->db->query($sql);
        $jsonData = array('data' => array());
        $arr_arch = array();
        foreach ($result->result_array() as $row) {
            $link = "";
            $arr_ruta = explode('/', $row['capa']);
            $nombre = $arr_ruta[sizeof($arr_ruta) - 1];
            if ($row['arch_c_hash'] != '') {
                $link = "<a target='_blank' class='btn btn-xs btn-default' href=" . site_url("archivo/download_file/k/" . $row['arch_c_hash']) . ">Descargar</a>";
            }
            $entry = array(
                $row['cap_c_nombre'],
                $row['ccb_c_categoria'],
                $row['geozone'],
                "<img src='" . base_url($row['icono']) . "' height='24' />",
                $row['cap_c_propiedades'],
                $nombre,
                $link,
                "<a class='btn btn-xs btn-default btn-square' onclick='Layer.editarCapa(".$row['cap_ia_id'].");' ><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarCapa(".$row['cap_ia_id'].")'><i class='fa fa-trash'></i></a>"
            );
            $arr_arch[] = $entry;
            $jsonData['data'][] = $entry;
        }
        echo json_encode($jsonData);
    }

    function getCapa($id_capa) {

        $sql = "select cc.ccb_c_categoria, a.arch_c_hash,a.arch_c_nombre capa, b.arch_c_mime mime, b.arch_c_nombre icono, c.*, CONCAT(c.cap_c_geozone_number,c.cap_c_geozone_letter) geozone from capas c 
                join archivo a on c.capa_arch_ia_id = a.arch_ia_id
                join archivo b on c.icon_arch_ia_id = b.arch_ia_id
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


    public function validarCapaEmergencia($id_capa){
        $query = "select count(*) as total from emergencias 
                where eme_c_capas like $id_capa  
                or eme_c_capas like '$id_capa,%' 
                or eme_c_capas like '%,$id_capa' 
                or eme_c_capas like '%,$id_capa,%'";
        $result = $this->db->query($query);
        $validate = $result->result_object();
        
        return $validate[0]->total;
    }


    public function eliminarCapa($id_capa){
        $query = "delete from capas where cap_ia_id = ?";
        $this->db->trans_begin();
        if($this->db->query($query,array($id_capa))){
            $query = "select eme_ia_id,eme_c_capas from emergencias 
                    where eme_c_capas like $id_capa  
                    or eme_c_capas like '$id_capa,%' 
                    or eme_c_capas like '%,$id_capa' 
                    or eme_c_capas like '%,$id_capa,%'";
            $result = $this->db->query($query);
            $emergencias = $result->result_object();
            foreach($emergencias as $item){
                $capas = '';
                $tmp = explode(',',$item->eme_c_capas);
                foreach($tmp as $capa){
                    if($capa != $id_capa){
                        $capas .= $capa.',';
                    }
                }
                $capas = trim($capas,',');

                $query = "update emergencias set eme_c_capas = ? where eme_ia_id = ?";
                $update = $this->db->query($query,array($capas,$item->eme_ia_id));
            }

            if ($this->db->trans_status() === FALSE) {
                
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }

        }else{
            return false;
        }
    }

}
