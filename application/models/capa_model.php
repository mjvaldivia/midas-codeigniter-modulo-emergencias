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
        foreach ($params as $k => $v){

            if(strstr($k,'prop_'))
            {
                if($lista_propiedades!='')
                {$lista_propiedades.=',';}
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
                       '" . $params['iComunas_'.$i] . "',
                       '" . $params['iCategoria'] . "',
                       '" . $lista_propiedades . "'
                    )
                    ");
            
            $cap_ia_id = $this->db->insert_id();
            $capa = $this->cache->get($params['tmp_file_'.$i]);   //capa 
            
            $icon_size = filesize('media/tmp/'.$params['icon']);
            $icon_type = filetype('media/tmp/'.$params['icon']);
            $tmp_name = 'media/tmp/'.$params['icon'];
            

            $capa_obj_arch_json = $this->ArchivoModel->upload_to_site($capa['filename'], $capa['type'],null,$cap_ia_id, $this->ArchivoModel->TIPO_CAPA, $capa['size'], $capa['nombre_cache_id']);
            $icon_obj_arch_json = $this->ArchivoModel->upload_to_site('icono_capa', $icon_type, $tmp_name,$cap_ia_id, $this->ArchivoModel->TIPO_ICONO_DE_CAPA, $icon_size);
            
            $capa_arch_ia_id = json_decode($capa_obj_arch_json)->id;
            $icon_arch_ia_id = json_decode($icon_obj_arch_json)->id;
            
            
            $this->db->query("
                    UPDATE capas SET capa_arch_ia_id = $capa_arch_ia_id, icon_arch_ia_id = $icon_arch_ia_id 
                    where cap_ia_id =". $cap_ia_id
                    );
            
            if ($this->db->trans_status() === FALSE)
            {
                $error = true;
                $this->db->trans_rollback();
            }
            else
            { $this->db->trans_commit();}

        }
        
        echo ($error)?0:1;
    }

}
