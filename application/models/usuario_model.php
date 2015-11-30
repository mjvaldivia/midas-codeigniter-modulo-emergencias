<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Vladimir
 * @since 14-09-15
 */
class Usuario_Model extends MY_Model {

    public function generaKeyId($idUser = null) {
        $key_id = ($idUser == null) ? md5(uniqid($idUser)) : md5(uniqid());
        $query = $this->db->query('INSERT INTO nologin (usu_ia_id,key_id) VALUES (' . $idUser . ',"' . $key_id . '")');
        if ($query)
            return $key_id;
        else
            return false;
    }

    public function bajaKeyId($key_id = null) {

        $query = $this->db->query('UPDATE nologin SET activo = 0 WHERE key_id = "' . $key_id . '"');
        return $query;
    }

    public function validaKey($key_id = null) {

        $query = $this->db->query('SELECT u.usu_c_rut, n.activo FROM nologin n join usuarios u on u.usu_ia_id = n.usu_ia_id WHERE key_id = "' . $key_id . '"');
        $row = $query->result_array();
        return $row[0];
    }

    function nologin($rut = null) {

        $this->load->model("session_model", "SessionModel");
        $resultado = $this->SessionModel->autentificar($rut);

        if (!$resultado) {
            show_error("Ha ocurrido un error interno", 500);
        }
        return;
    }

    public function get_mails($id_region = null) {
        $result = $this->db->query("select CONCAT(TRIM(u.usu_c_nombre),' ',TRIM(u.usu_c_apellido_paterno)) nombre, u.usu_c_email from usuarios u
                   where u.reg_ia_id = $id_region
                    AND u.est_ia_id = 1                


");
        $res = array();

        foreach ($result->result_array() as $row) {
            $res[] = '('.$row['nombre'].') '.$row['usu_c_email'];
           
        }


         echo json_encode($res);
    }

}
