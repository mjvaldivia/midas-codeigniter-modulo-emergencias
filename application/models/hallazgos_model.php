<?php


class Hallazgos_model extends MY_Model {


    /**
     * Nombre de tabla
     * @var string
     */
    protected $_tabla = "hallazgos";


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id_hallazgo", $id);
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
        return $this->_query->update($data, "id_hallazgo", $id);
    }

    /**
     *
     */
    public function delete($id){
        $this->_query->delete("id_hallazgo", $id);
    }

    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){
        $query = $this->_query->select("a.*")
            ->from($this->_tabla . " a")
            ->orderBy("fc_fecha_registro_hallazgo", "DESC");


        if(!empty($parametros["cd_estado_hallazgo"])){
            $query->whereAND("cd_estado_hallazgo", $parametros["cd_estado_hallazgo"]);
        }


        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }


    public function getImagenesInspeccion($id_hallazgo){
        $query = "select * from imagenes_inspecciones where cd_hallazgo_fk_imginspeccion = ? order by fc_fecha_imginspeccion DESC";
        $consulta = $this->db->query($query,array($id_hallazgo));

        if($consulta->num_rows() > 0){
            return $consulta->result_object();
        }else{
            return null;
        }
    }


    public function insImagenInspeccion($data){
        $query = "insert into imagenes_inspecciones values(NULL,?,?,?,?,?,?,?)";
        $parametros = array($data['inspeccion'],$data['usuario'],$data['fecha'],$data['ruta'],$data['mime'],$data['sha'],$data['nombre']);
        return $this->db->query($query,$parametros);
    }


    public function getImagenInspeccion($id,$sha=null){
        if(is_null($sha)){
            $query = "select * from imagenes_inspecciones where id_imginspeccion = ? limit 1";
            $consulta = $this->db->query($query,array($id));
        }else{
            $query = "select * from imagenes_inspecciones where id_imginspeccion = ? and gl_sha_imginspeccion = ? limit 1";
            $consulta = $this->db->query($query,array($id,$sha));
        }


        if($consulta->num_rows() > 0){
            $resultado = $consulta->result_object();
            return $resultado[0];
        }else{
            return null;
        }
    }


    public function delImagenInspeccion($id_imagen,$id_vector){
        $query = "delete from imagenes_inspecciones where id_imginspeccion = ? and cd_hallazgo_fk_imginspeccion = ?";
        return $this->db->query($query,array($id_imagen,$id_vector));
    }

}