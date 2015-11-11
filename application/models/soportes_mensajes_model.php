<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Soportes_Mensajes_Model extends MY_Model {
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "soportes_mensajes";

    /**
     *
     * @var string 
     */
    protected $primary = 'soportemensaje_id';

    public function insNuevoMensajeSoporte($datos){
        $id_mensaje = $this->_query->insert($datos);
        if($id_mensaje){
            return $id_mensaje;
        }else{
            return null;
        }

    }

    public function delMensajeSoporte($mensaje){
        return $this->_query->delete($mensaje);
    }


    public function obtMensajePrincipalSoporte($id_soporte) {

        $query = "select 
                    soportemensaje_id,
                    soportemensaje_soporte_fk,
                    soportemensaje_fecha,
                    soportemensaje_texto,
                    soportemensaje_usuario_fk,
                    soportemensaje_tipo,
                    soportemensaje_visto_usuario,
                    soportemensaje_visto_soporte
                    from ".$this->_tabla." 
                    where soportemensaje_soporte_fk = ? and soportemensaje_tipo = 1";
        $query = $this->db->query($query,array($id_soporte));
        
        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    public function obtMensajesSoporte($id_soporte) {
        $query = "select 
                    soportemensaje_id,
                    soportemensaje_soporte_fk,
                    soportemensaje_fecha,
                    soportemensaje_texto,
                    soportemensaje_usuario_fk,
                    soportemensaje_tipo,
                    soportemensaje_visto_usuario,
                    soportemensaje_visto_soporte,
                    concat(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno) as nombre_usuario
                    from ".$this->_tabla." 
                    left join usuarios on usu_ia_id = soportemensaje_usuario_fk 
                    where soportemensaje_soporte_fk = ? and soportemensaje_tipo = 2";
        $query = $this->db->query($query,array($id_soporte));
        
        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_object();

        return $resultados;
    }


    public function updSoporteMensaje($data,$id,$campo=null){
        if($campo){
            return $this->_query->update($data,$campo,$id);    
        }else{
            return $this->_query->update($data,$this->primary,$id);
        }
    }

}    