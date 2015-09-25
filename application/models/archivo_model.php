<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Archivo_Model extends CI_Model
{

    public $TIPO_EMERGENCIA = 5;
    public $TIPO_GEOJSON = 6;
    public $DOC_FOLDER = 'media/doc/';

    public function upload_to_site($filename = null, $mimetype = null, $tmp_name = null, $id_entidad = null, $tipo = null, $size = null)
    {

        // var_dump($tmp_name);die;
        header('Content-type: application/json');
        $filename = $this->sanitize_filename($filename);
        $error = 0;

        if (trim($filename) !== '') {

            if ($url = $this->setURLFile($id_entidad, $tipo)) {
                $full_url = FCPATH . $url;

                if (is_dir($full_url) || mkdir($full_url, 0777, true)) {
                    $last_id = $this->file_to_bd($url, $filename, $mimetype, $tipo, $id_entidad, $size);

                    if ($last_id) {
                        $full_url .= $last_id . '_' . $filename;
                        if (rename($tmp_name, $full_url)) {
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

    public function setURLFile($id_entidad = null, $tipo = null)
    {

        if ($id_entidad == null)
            return false;

        $folder_entidad = '';
        switch ($tipo) {
            case $this->TIPO_EMERGENCIA:
                $folder_entidad = 'alarmas';
                break;
            case $this->TIPO_GEOJSON:
                $folder_entidad = 'emergencia';
                break;
        }
        $anio = date('Y');
        $url = $this->DOC_FOLDER . $folder_entidad . '/' . $id_entidad . '/' . $anio . '/';

        if ($url !== null)
            return $url;
        else
            return false;
    }

    public function sanitize_filename($filename = null)
    {
        $filename = preg_replace("([^\w\s\d\~,;:\[\]\(\).])", '_', $filename);
        return $filename = preg_replace("([\.]{2,})", '', $filename);
    }

    public function file_to_bd($url = null, $filename = null, $mimetype = null, $tipo = null, $id_entidad = null, $size = null)
    {

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
                        case $this->TIPO_GEOJSON:
                            $sql = "INSERT INTO archivo_vs_emevisor (arch_ia_id, eme_ia_id) values ($last_id,$id_entidad)";
                            $res = $this->db->query($sql);
                            break;
                        default :
                            break;
                    }
                    if ($res)
                        return $last_id;
                    else
                        return false;
                } else
                    return false;
            } else {
                return false;
            }
        } else
            return false;
    }

    function get_docs($id_entidad, $jsoneado = true, $tipo = null)
    {

        if ($tipo == null) {
            return array();
        }
        $this->load->helper('utils');
        switch ($tipo) {
            case 5 :
                $tabla = 'archivo_vs_alarma';
                $id = 'ala_ia_id';
                break;
        }

        $sql = "select a.*,UPPER(CONCAT(u.usu_c_nombre,' ',u.usu_c_apellido_paterno,' ',u.usu_c_apellido_materno)) as nombre_usuario  from archivo a
                left join usuarios u on a.usu_ia_id = u.usu_ia_id
                join $tabla avp on avp.arch_ia_id = a.arch_ia_id
                where avp.$id =$id_entidad";
        $result = $this->db->query($sql);
        //header("Content-type: application/json; charset=utf-8");
        $jsonData = array('data' => array());
        $arr_arch = array();
        foreach ($result->result_array() as $row) {
            $arr_ruta = explode('/', $row['arch_c_nombre']);
            $nombre = $arr_ruta[sizeof($arr_ruta) - 1];
            $link = "";
            if ($row['arch_c_hash'] != '') {
                $link = "<a target='_blank' class='btn btn-xs btn-default' href=" . site_url("archivo/download_file/k/" . $row['arch_c_hash']) . ">VER</a>";
            }
            $entry = array(
                $nombre,
                $row['nombre_usuario'],
                ISODateTospanish($row['arch_f_fecha']),
                $link,
                $row['arch_ia_id'],
                round(($row['arch_c_tamano']) / 1024, 1)
            );
            $arr_arch[] = $entry;
            $jsonData['data'][] = $entry;
        }
        if ($jsoneado)
            echo json_encode($jsonData);
        else
            return $arr_arch;
    }

    function get_file_from_key($k)
    {
        $sql = "select * from archivo where arch_c_hash='$k'";
        $result = $this->db->query($sql);
        $row = $result->result_array();
        return $row[0];
    }

    function descargar($k = null)
    {
        if ($k != null) {
            $archivo = $this->get_file_from_key($k);

            $arr_ruta = explode('/', $archivo['arch_c_nombre']);
            $nombre = $arr_ruta[sizeof($arr_ruta) - 1];
            header("Content-Type: " . $archivo['arch_c_mime'] . "; charset: UTF-8");
            header("filename=" . $nombre);

            header("Content-Disposition:  ; filename=\"" . $nombre . "\"");
            ob_end_clean();
            readfile(FCPATH . $archivo['arch_c_nombre']);
            exit;
        } else
            return false;
    }

    function setTemporaryGeoJson($id, $geoJson)
    {

        $filename = 'geoJson.json';
        $mimetype = 'application/octect-stream';
        $existente = $this->loadGeoJson($id);
        if ($existente == 0) {
            $tmp_name = tempnam(sys_get_temp_dir(), uniqid());
            $fp = fopen($tmp_name, 'w');
            fwrite($fp, $geoJson);
            fclose($fp);
            $size = filesize($tmp_name);
            echo $this->upload_to_site($filename, $mimetype, $tmp_name, $id, $this->TIPO_GEOJSON, $size);
        } else {
            $fp = fopen($existente['arch_c_nombre'], 'w');
            fwrite($fp, $geoJson);
            fclose($fp);
            $arr_res = array('error' => 0,
                'k' => $existente['arch_c_hash'],
                'filename' => $existente['arch_c_nombre']
            );
            echo json_encode($arr_res);
        }


    }

    function loadGeoJson($params)
    {
        if (!array_key_exists("id", $params)) return 0;
        $id = $params["id"];

        $sql = "select a.* from archivo a join archivo_vs_emevisor ave on ave.arch_ia_id = a.arch_ia_id where ave.eme_ia_id = $id order by a.arch_ia_id desc limit 1";
        $result = $this->db->query($sql);
        if ($row = $result->result_array()) {
            return $row[0];
        } else
            return [];
    }

}
