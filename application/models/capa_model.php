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

        echo ($error) ? 0 : 1;
    }

    public function obtenerTodos($ids = null) {
        $result = $this->db->query(" SELECT c.*, cc.ccb_c_categoria, a.arch_c_nombre from 
                capas c join categorias_capas_coberturas cc 
                on c.ccb_ia_categoria = cc.ccb_ia_categoria
                join archivo a on c.icon_arch_ia_id = a.arch_ia_id");
        $jsonData = array(); 
        $arr_ids = array();
        if($ids==!null){
                $arr_ids = explode(',', $ids);
            }
        foreach ($result->result_array() as $row) {
            if(in_array($row['cap_ia_id'], $arr_ids)){
                $checked='checked';
            }
            else{
                $checked = '';
            }
            
            array_push($jsonData,array(
                'chkbox' =>"<input type=checkbox $checked id='chk_".$row['cap_ia_id']."' name='chk_".$row['cap_ia_id']."' onclick='VisorMapa.selectCapa(".$row['cap_ia_id'].");' />",
                'cap_c_nombre' =>$row['cap_c_nombre'],
                'ccb_c_categoria' =>$row['ccb_c_categoria'],
                'cap_ia_id' =>$row['cap_ia_id'],
                'arch_c_nombre' =>$row['arch_c_nombre']
                
            ));
            
        }
        echo json_encode($jsonData);
    }
    public function getjson($id) {
        $this->load->helper("url");
        $result = $this->db->query(" SELECT c.cap_ia_id, c.cap_c_nombre, a.arch_c_nombre capa,a2.arch_c_nombre icono,c.cap_c_propiedades, c.cap_c_geozone_number, c.cap_c_geozone_letter  from capas c join archivo a on c.capa_arch_ia_id = a.arch_ia_id join archivo a2 on c.icon_arch_ia_id = a2.arch_ia_id where cap_ia_id = $id");
        $row= $result->result_array();
        $str = file_get_contents($row[0]['capa']);
   
          $res =   array(
                'id' => $row[0]['cap_ia_id'],
                'nombre' => $row[0]['cap_c_nombre'],
                'capa'=> base_url($row[0]['capa']),
                'icono'=> base_url($row[0]['icono']),
                'propiedades' => $row[0]['cap_c_propiedades'],
                'geozone' => $row[0]['cap_c_geozone_number'].$row[0]['cap_c_geozone_letter'],
                'json_str' => $str,
                
                
            );
          
        echo json_encode($res);
    }

}
