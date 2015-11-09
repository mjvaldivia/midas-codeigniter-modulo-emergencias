<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Soportes_Model extends CI_Model {

    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "soportes";
    
    protected $primary = 'soporte_id';
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('Query');
        $this->_query = New Query($this->db);
        $this->_query->setTable($this->_tabla);
    }


    public function obtSoportesUsuario($id_usuario) {
        $query = "select 
                    soporte_id,
                    soporte_usuario_fk,
                    soporte_region,
                    soporte_codigo,
                    soporte_fecha_ingreso,
                    soporte_asunto,
                    soporte_estado,
                    soporte_email,
                    soporte_fecha_cierre,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario,
                    (select count(*) as no_leidos from soportes_mensajes where soportemensaje_soporte_fk = soporte_id and soportemensaje_visto_usuario = 0 ) as no_leidos,
                    case soporte_estado
                        when 1 then 'INGRESADO'
                        when 2 then 'EN DESARROLLO'
                        else 'CERRADO'
                    end as estado
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soporte_usuario_fk
                    where soporte_usuario_fk = ?
                    order by soporte_fecha_ingreso DESC";
        $query = $this->db->query($query,array($id_usuario));

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }



    public function obtSoportes($id_region) {
        $query = "select 
                    soporte_id,
                    soporte_usuario_fk,
                    soporte_region,
                    soporte_codigo,
                    soporte_fecha_ingreso,
                    soporte_asunto,
                    soporte_estado,
                    soporte_email,
                    soporte_fecha_cierre,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario,
                    (select count(*) as no_leidos from soportes_mensajes where soportemensaje_soporte_fk = soporte_id and soportemensaje_visto_soporte = 0 ) as no_leidos,
                    case soporte_estado
                        when 1 then 'INGRESADO'
                        when 2 then 'EN DESARROLLO'
                        else 'CERRADO'
                    end as estado
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soporte_usuario_fk
                    where soporte_region = ? and soporte_derivado = 0 
                    order by soporte_fecha_ingreso DESC";
        $query = $this->db->query($query,array($id_region));

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    public function obtUltimoCorrelativoRegion($region){
        $query = "select soporte_codigo from ".$this->_tabla." where soporte_region = ? order by soporte_id DESC limit 1 ";
        $query = $this->db->query($query,array($region));
        if($query->num_rows() > 0){
            $resultado = $query->result_object();
            $codigo = $resultado[0]->soporte_codigo + 1;
            return $codigo;
        }else{
            if($region < 10){
                $region = '0'.$region;
            }
            return date('y').$region.'1';
        }
    }

    public function insNuevoSoporte($datos){
        $id_soporte = $this->_query->insert($datos);
        if($id_soporte){
            return $id_soporte;
        }else{
            return null;
        }

    }

    public function delSoporte($soporte){
        return $this->_query->delete($soporte);
    }


    public function obtSoporteId($id_soporte) {

        $query = "select 
                    soporte_id,
                    soporte_usuario_fk,
                    soporte_region,
                    soporte_codigo,
                    soporte_fecha_ingreso,
                    soporte_asunto,
                    soporte_estado,
                    soporte_email,
                    soporte_fecha_cierre,
                    soporte_derivado,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario,
                    usu_c_email as email_usuario,
                    case soporte_estado
                        when 1 then 'INGRESADO'
                        when 2 then 'EN DESARROLLO'
                        else 'CERRADO'
                    end as estado
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soporte_usuario_fk
                    where soporte_id = ?";
        $query = $this->db->query($query,array($id_soporte));
        
        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    public function updSoporte($data,$id){
        return $this->_query->update($data,$this->primary,$id);
    }



    public function obtSoportesCentral() {
        $query = "select 
                    soporte_id,
                    soporte_usuario_fk,
                    soporte_region,
                    soporte_codigo,
                    soporte_fecha_ingreso,
                    soporte_asunto,
                    soporte_estado,
                    soporte_email,
                    soporte_fecha_cierre,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario,
                    (select count(*) as no_leidos from soportes_mensajes where soportemensaje_soporte_fk = soporte_id and soportemensaje_visto_soporte = 0 ) as no_leidos,
                    case soporte_estado
                        when 1 then 'INGRESADO'
                        when 2 then 'EN DESARROLLO'
                        else 'CERRADO'
                    end as estado,
                    r.reg_c_nombre as nombre_region
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soporte_usuario_fk 
                    left join regiones r on r.reg_ia_id = soporte_region 
                    where soporte_derivado = 1
                    order by soporte_fecha_ingreso DESC";
        $query = $this->db->query($query);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }
}    