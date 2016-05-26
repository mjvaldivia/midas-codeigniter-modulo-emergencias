<?php


class vectores_model extends MY_Model {


    /**
     * Nombre de tabla
     * @var string
     */
    protected $_tabla = "vectores";


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
        return $this->_query->getById("id_vector", $id);
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
        return $this->_query->update($data, "id_vector", $id);
    }

    /**
     *
     */
    public function delete($id){
        $this->_query->delete("id_vector", $id);
    }

    /**
     * Lista
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){
        $query = $this->_query->select("a.*")
            ->from($this->_tabla . " a")
            ->orderBy("fc_fecha_registro_vector", "DESC");


        if(!empty($parametros["cd_estado_vector"])){
            $query->whereAND("cd_estado_vector", $parametros["cd_estado_vector"]);
        }


        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }


    public function getImagenesVector($id_vector){
        $query = "select * from imagenes_denuncias where cd_denuncia_fk_imgdenuncia = ? order by fc_fecha_imgdenuncia DESC";
        $consulta = $this->db->query($query,array($id_vector));

        if($consulta->num_rows() > 0){
            return $consulta->result_object();
        }else{
            return null;
        }
    }


    public function insImagenVector($data){
        $query = "insert into imagenes_denuncias values(NULL,?,?,?,?,?,?,?)";
        $parametros = array($data['denuncia'],$data['usuario'],$data['fecha'],$data['ruta'],$data['mime'],$data['sha'],$data['nombre']);
        return $this->db->query($query,$parametros);
    }


    public function getImagenVector($id,$sha=null){
        if(is_null($sha)){
            $query = "select * from imagenes_denuncias where id_imgdenuncia = ? limit 1";
            $consulta = $this->db->query($query,array($id));
        }else{
            $query = "select * from imagenes_denuncias where id_imgdenuncia = ? and gl_sha_imgdenuncia = ? limit 1";
            $consulta = $this->db->query($query,array($id,$sha));
        }

        if($consulta->num_rows() > 0){
            $resultado = $consulta->result_object();
            return $resultado[0];
        }else{
            return null;
        }
    }


    public function delImagenVector($id_imagen,$id_vector){
        $query = "delete from imagenes_denuncias where id_imgdenuncia = ? and cd_denuncia_fk_imgdenuncia = ?";
        return $this->db->query($query,array($id_imagen,$id_vector));
    }
}