<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Archivo_Model extends CI_Model {

    public $TIPO_EMERGENCIA = 5;
    public $DOC_FOLDER = 'media/doc/';

    public function upload_to_site($filename = null, $mimetype = null, $tmp_name = null, $id_entidad = null, $tipo = null, $size = null) {
        
        
        header('Content-type: application/json');
        $filename = $this->sanitize_filename($filename);
        $error = 0;

        if (trim($filename) !== '') {

            if ($url = $this->setURLFile($id_entidad,$tipo)) {
                $full_url = FCPATH . $url;

                if (is_dir($full_url) || mkdir($full_url, 0777, true)) {
                    $last_id = $this->file_to_bd($url, $filename, $mimetype, $tipo, $id_entidad, $size);

                    if ($last_id) {
                        $full_url .= $last_id . '_' . $filename;
                        if (move_uploaded_file($tmp_name, $full_url)) {
                            $error = 0;
                        } else {
                            $error = 'Err 1: No se pudo copiar al destino';
                        }
                    } else {
                        $error = 'Err 2: No se pudo guardar en bd';
                    }
                } else {
                    $error = 'Err 3: No se pudo crear archivo. Permiso denegado?';
                }
            }
        } else {
            $error = 'Err 4: Nombre no válido o excede tamaño permitido';
        }

        $arr_res = array('error' => $error,
            'k' => md5($url . $last_id . '_' . $filename),
            'filename' => $filename
        );
        return json_encode($arr_res);
    }
    
        public function setURLFile($id_entidad = null,$tipo = null) {

        if ($id_entidad == null)
            return false;
        
        $folder_entidad = '';
        switch ($tipo){
            case $this->TIPO_EMERGENCIA:
                $folder_entidad = 'alarmas';
                break;
         
        }
        $anio = date('Y');
        $url = $this->DOC_FOLDER . $folder_entidad .'/'. $id_entidad . '/' . $anio . '/';

        if ($url !== null)
            return $url;
        else
            return false;
    }

    public function sanitize_filename($filename = null) {
        $filename = preg_replace("([^\w\s\d\~,;:\[\]\(\).])", '_', $filename);
        return $filename = preg_replace("([\.]{2,})", '', $filename);
    }
    
    public function file_to_bd($url = null, $filename = null, $mimetype = null, $tipo = null, $id_entidad = null, $size = null) {

        $this->load->helper("session");
        
        
        $sql = "    INSERT INTO archivo (arch_ia_id, arch_c_nombre, arch_c_mime, arch_c_tipo, arch_c_hash, ins_ia_id,usu_ia_id,arch_c_tamano)
                    values('',null,'$mimetype',$tipo,null,null," . $this->session->userdata('session_idUsuario') . ",'$size')";

        if ($this->db->query($sql)) {
            
            $last_id = $this->db->insert_id();
            $filename = $url . $last_id . '_' . $filename;

            if ($last_id) {

                $sql = "    UPDATE archivo set arch_c_nombre = '" . mysql_real_escape_string($filename) . "',arch_c_hash=md5('" . $filename . "') WHERE arch_ia_id = $last_id";
                if ($this->db->query($sql)) {
                    $res = false;
                    switch ($tipo) {
                        case $this->TIPO_EMERGENCIA:
                            $sql = "INSERT INTO archivo_vs_alarma (arch_ia_id, ala_ia_id) values ($last_id,$id_entidad)";
                            $res = $this->db->query($sql);
                            break;
                        default : break;
                    }
                    if ($res)
                        return $last_id;
                    else
                        return false;
                } else
                    return false;
            }
            else {
                return false;
            }
        } else
            return false;
    }
    
}
