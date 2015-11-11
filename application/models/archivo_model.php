<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Archivo_Model extends CI_Model {

    public $TIPO_EMERGENCIA = 5;
    public $TIPO_GEOJSON = 6;
    public $TIPO_CAPA = 7;
    public $TIPO_ICONO_DE_CAPA = 8;
    public $TIPO_MAPA_REPORTE = 9;
    public $DOC_FOLDER = 'media/doc/';
    public $EMERGENCIA_FOLDER = 'media/doc/emergencia/';
    public $ALARMA_FOLDER = 'media/doc/alarmas/';
    public $CAPA_FOLDER = 'media/doc/capa/';

    public function upload_to_site($filename = null, $mimetype = null, $tmp_name = null, $id_entidad = null, $tipo = null, $size = null, $cache_id = null, $nombre_capa = null) {

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
                        if ($tipo == $this->TIPO_GEOJSON) {
                            if (rename($tmp_name, $full_url)) {
                                $error = 0;
                            } else {
                                $error = 'Err 1: No se pudo copiar temporal al destino';
                            }
                        } else
                        if ($tipo == $this->TIPO_CAPA) {
                            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
                            $cache_file = $this->cache->get($cache_id);
                            $arr_properties = json_decode($cache_file['content'], true);
                            foreach ($arr_properties['features'] as $key => $value) {
                                $arr_properties['features'][$key]['properties']['TYPE'] = $id_entidad; // le agrego el tipo como feature
                            }
                            $string_geojson = json_encode($arr_properties);
                            if (file_put_contents($full_url, $string_geojson)) {
                                $error = 0;
                            } else {
                                $error = 'Err 1: No se pudo copiar temporal al destino';
                            }
                        } else
                        if ($tipo == $this->TIPO_ICONO_DE_CAPA || $tipo == $this->TIPO_MAPA_REPORTE) {

                            if (copy($tmp_name, $full_url)) {
                                $error = 0;
                            } else {
                                $error = 'Err 1: No se pudo copiar temporal al destino';
                            }
                        } else {
                            if (move_uploaded_file($tmp_name, $full_url)) {
                                $error = 0;
                            } else {
                                $error = 'Err 1: No se pudo copiar temporal al destino';
                            }
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
            'filename' => $filename,
            'id' => $last_id
        );
        return json_encode($arr_res);
    }

    public function setURLFile($id_entidad = null, $tipo = null) {

        if ($id_entidad == null)
            return false;

        $folder_entidad = '';
        switch ($tipo) {
            case $this->TIPO_EMERGENCIA:
                $folder_entidad = 'alarmas';
                break;
            case $this->TIPO_GEOJSON:
            case $this->TIPO_MAPA_REPORTE:
                $folder_entidad = 'emergencia';
                break;
            case $this->TIPO_CAPA:
            case $this->TIPO_ICONO_DE_CAPA:
                $folder_entidad = 'capa';
                break;
        }
        $anio = date('Y');
        $url = $this->DOC_FOLDER . $folder_entidad . '/' . $id_entidad . '/' . $anio . '/';

        if ($url !== null)
            return $url;
        else
            return false;
    }

    public function sanitize_filename($filename = null) {


        $filename = str_replace('á', "a", $filename);
        $filename = str_replace('é', "e", $filename);
        $filename = str_replace('í', "i", $filename);
        $filename = str_replace('ó', "o", $filename);
        $filename = str_replace('ú', "u", $filename);
        $filename = str_replace('ü', "u", $filename);
        $filename = str_replace('ñ', "n", $filename);
        $filename = str_replace('Á', "A", $filename);
        $filename = str_replace('É', "E", $filename);
        $filename = str_replace('Í', "I", $filename);
        $filename = str_replace('Ó', "O", $filename);
        $filename = str_replace('Ú', "U", $filename);
        $filename = str_replace('Ü', "U", $filename);
        $filename = str_replace('Ñ', "N", $filename);

        return preg_replace("[^\w\.]", '_', $filename);
    }

    public function file_to_bd($url = null, $filename = null, $mimetype = null, $tipo = null, $id_entidad = null, $size = null) {

        $this->load->helper("session");


        $sql = "    INSERT INTO archivo (arch_ia_id, arch_c_nombre, arch_c_mime, arch_c_tipo, arch_c_hash, ins_ia_id,usu_ia_id,arch_c_tamano)
                    values('',null,'$mimetype',$tipo,null,null," . $this->session->userdata('session_idUsuario') . ",'$size')";

        if ($this->db->query($sql)) {

            $last_id = $this->db->insert_id();
            $filename = $url . $last_id . '_' . $filename;

            if ($last_id) {

                $sql = "    UPDATE archivo set arch_c_nombre = '" . $filename . "',arch_c_hash=md5('" . $filename . "') WHERE arch_ia_id = $last_id";
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
                            $res = true;
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

    public function get_docs($id_entidad, $jsoneado = true, $tipo = null) {

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

                //$link = "<a target='_blank' class='btn btn-xs btn-default' href=" . site_url("archivo/download_file/k/" . $row['arch_c_hash']) . ">VER</a>";
                $link = $this->frame_from_mime($row['arch_c_mime'], $row['arch_c_nombre'], $row['arch_c_hash']);
            }
            $entry = array(
                $nombre,
                $row['nombre_usuario'],
                ISODateTospanish($row['arch_f_fecha']),
                $link,
                "<input type='checkbox' id=chk_".$row['arch_ia_id']." name=chk_".$row['arch_ia_id']." checked=true>",
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

    public function get_file_from_key($k) {
        $sql = "select * from archivo where arch_c_hash='$k'";
        $result = $this->db->query($sql);
        $row = $result->result_array();
        return $row[0];
    }
    public function get_file_from_id($id) {
        $sql = "select * from archivo where arch_ia_id='$id'";
        $result = $this->db->query($sql);
        $row = $result->result_array();
        return $row[0];
    }

    function descargar($k = null) {
        if ($k != null) {
            $archivo = $this->get_file_from_key($k);

            $arr_ruta = explode('/', $archivo['arch_c_nombre']);
            $nombre = $arr_ruta[sizeof($arr_ruta) - 1];

            if (is_file($archivo['arch_c_nombre'])) {
                header("Content-Type: " . $archivo['arch_c_mime'] . "; charset: UTF-8");
                header("filename=" . $nombre);

                header("Content-Disposition:  ; filename=\"" . $nombre . "\"");
                ob_end_clean();
                readfile(FCPATH . $archivo['arch_c_nombre']);
            } else {
                show_404();
            }
        } else
            return false;
    }

    public function setTemporaryGeoJson($id, $geoJson = null, $lista_capas = null) {
        $params = array();
        $params['id'] = $id;
        $filename = 'geoJson.geojson';
        $mimetype = 'application/octect-stream';
        $error = 0;
        if ($geoJson !== null) {
            $existente = $this->loadGeoJson($params);
            if ($existente == 0) {
                $tmp_name = tempnam(sys_get_temp_dir(), uniqid());
                $fp = fopen($tmp_name, 'w');
                fwrite($fp, $geoJson);
                fclose($fp);
                $size = filesize($tmp_name);
                $this->upload_to_site($filename, $mimetype, $tmp_name, $id, $this->TIPO_GEOJSON, $size);
            } else {
                $fp = fopen($existente['arch_c_nombre'], 'w');
                if (!fwrite($fp, $geoJson))
                    $error++;
                fclose($fp);
            }
        }
        if ($lista_capas !== null) {
            $sql = "update emergencias set eme_c_capas = '$lista_capas' where eme_ia_id = $id";
            if (!$this->db->query($sql)) {
                $error++;
            }
        }
        echo $error;
    }

    public function loadGeoJson($params) {
        if (!array_key_exists("id", $params))
            return 0;
        $id = $params["id"];

        $sql = "select a.* from archivo a join archivo_vs_emevisor ave on ave.arch_ia_id = a.arch_ia_id where ave.eme_ia_id = $id order by a.arch_ia_id desc limit 1";
        $result = $this->db->query($sql);
        if ($row = $result->result_array()) {
            return $row[0];
        } else
            return 0;
    }

    public function delete($path) {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    public function frame_from_mime($mime_type = null, $ruta = null, $hash = null) {
        if ($mime_type == null || $ruta == null || $hash == null)
            return '';

        $frame = '';
        $arr = explode('/', $mime_type);
        $ext = explode('.', $ruta);
        if (sizeof($ext > 1)) {
            $ext = $ext[sizeof($ext) - 1];
        }



        switch (strtolower($arr[0])) {

            case 'application':
                switch (strtolower($arr[1])) {
                    case 'pdf':
                        $frame = "<embed src='" . base_url($ruta) . "' width='170px' height='170px;' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html'>";
                        break;
                    case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                    case 'msword':
                        $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/word.png') . "' /></a>";
                        break;
                    case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    case 'vnd.ms-excel':
                        $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/excel.png') . "' /></a>";
                        break;
                    case 'octet-stream':
                        switch ($ext) {
                            case 'zip' :
                            case 'gz' :
                            case 'rar' :
                                $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/zip.png') . "' /></a>";
                                break;
                            case 'text':
                            case 'sql':
                            case 'json':
                                $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/text.png') . "' /></a>";
                                break;
                            default:
                                $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/none.png') . "' /></a>";
                                break;
                        }

                        break;
                    default:
                        $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/none.png') . "' /></a>";
                        break;
                }
                break;
            case 'image':
                $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url($ruta) . "' /></a>";
                break;
            default:
                $frame = "<a target='_blank' href=" . site_url("archivo/download_file/k/" . $hash) . "><img height=64 src='" . base_url('assets/img/none.png') . "' /></a>";
                break;
        }
        $frame.= "<div class='col-lg-12'><a target='_blank' class='btn btn-xs btn-default'  href=" . site_url("archivo/download_file/k/" . $hash) . ">Ver / Descargar</a></div>";
        return $frame;
    }

}
