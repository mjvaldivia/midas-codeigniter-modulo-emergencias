<?php
if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Alarma_Historial_Model extends MY_Model {

    protected $_tabla = "alertas_historial";

    function __construct()
    {
        parent::__construct();
    }


    public function getByAlarma($alarma){
        $query = "select h.*, concat(u.usu_c_nombre,' ',u.usu_c_apellido_paterno,' ',u.usu_c_apellido_materno) as nombre_usuario
                    from alertas_historial h
                    left join usuarios u on u.usu_ia_id = h.historial_usuario
                    where h.historial_alerta = ?
                    order by h.historial_fecha ASC";
        $resultado = $this->db->query($query, array($alarma));
        if($resultado->num_rows() > 0){

            return $resultado->result_array();
        }else{
            return null;
        }

    }

}