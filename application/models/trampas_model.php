<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Trampas_Model extends MY_Model
{

    protected $_tabla = 'trampas';


    public function getById($id){
        return $this->_query->getById("id_trampa", $id);
    }



    public function listar(){
        $query = $this->_query->select("a.*")
            ->from($this->_tabla . " a")
            ->orderBy("id_trampa", "DESC");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }


    /**
     *
     * @param array $data
     * @return int identificador del registro ingresado
     */
    public function insert($data){
        return $this->_query->insert($data);
    }

    /**
     * Actualiza
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "id_trampa", $id);
    }

    /**
     *
     */
    public function delete($id){
        $this->_query->delete("id_trampa", $id);
    }


    public function guardarInspeccion($data){
        $query = "insert into trampas_inspecciones values(NULL,?,?,?,?,?,?)";
        $parametros = array($data['trampa'],$data['usuario'],$data['fecha'],$data['hallazgo'],$data['cantidad'],$data['observaciones']);

        if($this->db->query($query,$parametros)){
            return true;
        }else{
            return null;
        }
    }


    public function getInspeccionesTrampa($id_trampa){
        $query = "select t.*, u.usu_c_nombre, u.usu_c_apellido_paterno, u.usu_c_apellido_materno from trampas_inspecciones t 
                    left join usuarios u on u.usu_ia_id = t.cd_usuario_inspeccion 
                    where cd_trampa_inspeccion = ? order by fc_fecha_inspeccion DESC";

        $consulta = $this->db->query($query,array($id_trampa));
        if($consulta->num_rows() > 0){
            return $consulta->result_array();
        }else{
            return null;
        }
    }



}