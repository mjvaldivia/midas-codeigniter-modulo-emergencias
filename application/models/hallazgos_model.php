<?php


class Hallazgos_model extends MY_Model
{


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
    public function getById($id)
    {
        return $this->_query->getById("id_hallazgo", $id);
    }


    /**
     *
     * @param array $data
     * @return int identificador del registro ingresado
     */
    public function insert($data)
    {
        return $this->_query->insert($data);
    }

    /**
     * Actualiza
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id)
    {
        return $this->_query->update($data, "id_hallazgo", $id);
    }

    /**
     *
     */
    public function delete($id)
    {
        $this->_query->delete("id_hallazgo", $id);
    }

    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array())
    {
        $query = $this->_query->select("a.*")
            ->from($this->_tabla . " a")
            ->orderBy("fc_fecha_registro_hallazgo", "DESC");


        if (!empty($parametros["cd_estado_hallazgo"])) {
            $query->whereAND("cd_estado_hallazgo", $parametros["cd_estado_hallazgo"]);
        }


        $result = $query->getAllResult();
        if (!is_null($result)) {
            return $result;
        } else {
            return NULL;
        }
    }


    public function getNumeroInspecciones(){
        $query = "select count(*) as total from ".$this->_tabla;
        $consulta = $this->db->query($query);
        $consulta = $consulta->result_object();

        return $consulta[0]->total;
    }


    public function getImagenesInspeccion($id_hallazgo)
    {
        $query = "select * from imagenes_inspecciones where cd_hallazgo_fk_imginspeccion = ? order by fc_fecha_imginspeccion DESC";
        $consulta = $this->db->query($query, array($id_hallazgo));

        if ($consulta->num_rows() > 0) {
            return $consulta->result_object();
        } else {
            return null;
        }
    }


    public function insImagenInspeccion($data)
    {
        $query = "insert into imagenes_inspecciones values(NULL,?,?,?,?,?,?,?)";
        $parametros = array($data['inspeccion'], $data['usuario'], $data['fecha'], $data['ruta'], $data['mime'], $data['sha'], $data['nombre']);
        return $this->db->query($query, $parametros);
    }


    public function getImagenInspeccion($id, $sha = null)
    {
        if (is_null($sha)) {
            $query = "select * from imagenes_inspecciones where id_imginspeccion = ? limit 1";
            $consulta = $this->db->query($query, array($id));
        } else {
            $query = "select * from imagenes_inspecciones where id_imginspeccion = ? and gl_sha_imginspeccion = ? limit 1";
            $consulta = $this->db->query($query, array($id, $sha));
        }


        if ($consulta->num_rows() > 0) {
            $resultado = $consulta->result_object();
            return $resultado[0];
        } else {
            return null;
        }
    }


    public function delImagenInspeccion($id_imagen, $id_vector)
    {
        $query = "delete from imagenes_inspecciones where id_imginspeccion = ? and cd_hallazgo_fk_imginspeccion = ?";
        return $this->db->query($query, array($id_imagen, $id_vector));
    }


    public function listadoInspecciones($parametros=null)
    {
        $order = ' order by id_hallazgo DESC ';
        $where = '';
        $limit = ' limit 0,10';

        $query = 'select
              concat("I-",id_hallazgo) as codigo,
              fc_fecha_registro_hallazgo as fecha_registro,
              concat(gl_nombres_hallazgo," ",gl_apellidos_hallazgo) as nombre,
              gl_direccion_hallazgo as direccion,
              gl_telefono_hallazgo as telefono,
              fc_fecha_hallazgo_hallazgo as fecha_hallazgo,
              if(cd_estado_hallazgo=0 and cd_enviado_hallazgo=0,"Ingresado",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=0,"Revisado - Respondido",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=1,"Enviado",""))) as estado,
              case cd_estado_hallazgo
                when 0 then "En Revisión"
                when 1 then "Aedes"
                when 2 then "Negativo"
              when 3 then "Negativo"
              when 4 then "Negativo"
                else "Sin información" end
              as resultado,
              id_hallazgo as id_hallazgo,
              cd_estado_hallazgo,
              cd_estado_desarrollo_hallazgo,
              cd_enviado_hallazgo 
            
              from hallazgos
        ';

        if(!is_null($parametros)){
            if(isset($parametros['search']) and $parametros['search']['value'] != ""){
                $valor = $parametros['search']['value'];
                $where = " where id_hallazgo like '%".$valor."%' or fc_fecha_registro_hallazgo like '%".$valor."%' or gl_direccion_hallazgo like '%".$valor."%' or gl_telefono_hallazgo like '%".$valor."%' or fc_fecha_hallazgo_hallazgo like '%".$valor."%' or if(cd_estado_hallazgo=0 and cd_enviado_hallazgo=0,\"Ingresado\",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=0,\"Revisado - Respondido\",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=1,\"Enviado\",\"\"))) like '%".$valor."%' or if(cd_estado_hallazgo=0,\"En Revisión\",if(cd_estado_hallazgo=1,\"Aedes\",\"Negativo\")) like '%".$valor."%' ";
            }

            if(isset($parametros['start']) and isset($parametros['length'])){
                $limit = ' limit '.$parametros['start'].','.$parametros['length'];
            }

            if(isset($parametros['order'])){
                if($parametros['order']['column'] == 0){
                    $order = ' order by id_hallazgo ';
                }elseif($parametros['order']['column'] == 1){
                    $order = ' order by fc_fecha_registro ';
                }elseif($parametros['order']['column'] == 2){
                    $order = ' order by gl_nombres_hallazgo,gl_apellidos_hallazgo ';
                }elseif($parametros['order']['column'] == 3){
                    $order = ' order by gl_direccion_hallazgo ';
                }elseif($parametros['order']['column'] == 4){
                    $order = ' order by gl_telefono_hallazgo ';
                }elseif($parametros['order']['column'] == 5){
                    $order = ' order by fc_fecha_hallazgo_hallazgo ';
                }elseif($parametros['order']['column'] == 6){
                    $order = ' order by if(cd_estado_hallazgo=0 and cd_enviado_hallazgo=0,"Ingresado",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=0,"Revisado - Respondido",if(cd_estado_hallazgo>0 and cd_enviado_hallazgo=1,"Enviado",""))) ';
                }elseif($parametros['order']['column'] == 7){
                    $order = ' order by if(cd_estado_hallazgo=0,"En Revisión",if(cd_estado_hallazgo=1,"Aedes","Negativo"))';
                }
                $order .= ' '.$parametros['order']['dir'].' ';
            }
        }



        $query .= $where . $order ;
        
        $consulta = $this->db->query($query);
        $arr_resultado['total'] = $consulta->num_rows();

        $query .= $limit;
        $consulta = $this->db->query($query);
        if($consulta->num_rows() > 0){
            $arr_resultado['listado'] = $consulta->result_array();
        }else{
            $arr_resultado['listado'] = null;
        }

        return $arr_resultado;

    }
}