<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_Cobertura_Model extends MY_Model {

    public $PUNTO = 1;
    public $LINEA = 2;
    public $POLIGONO = 3;
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "categorias_capas_coberturas";
    
    /**
     * Retorna capas por comuna
     * @param array $lista_comunas
     * @return array
     */
    public function listarCategoriasPorComunas(array $lista_comunas){
        $result = $this->_query->select("DISTINCT cc.*")
                               ->from($this->_tabla . " cc")
                               ->join("capas c", "c.ccb_ia_categoria = cc.ccb_ia_categoria", "INNER")
                               ->join("capas_geometria g", "g.geometria_capa = c.cap_ia_id", "INNER")
                               ->join("capas_poligonos_informacion p", "p.poligono_capitem = g.geometria_id")
                               ->whereAND("p.poligono_comuna", $lista_comunas, "IN")
                               ->orderBy("cc.ccb_c_categoria", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }

    public function obtenerTodos() {
        $sql = "
        select
            cc.*
           
        from
            categorias_capas_coberturas cc 
        ";
        
        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }


    public function getById($id){
        $query = "select * from categorias_capas_coberturas where ccb_ia_categoria = ? limit 1";
        $resultado = $this->db->query($query,array($id));
        if($resultado->num_rows > 0){
            $resultado = $resultado->result_array();
            return $resultado[0];
        }else{
            return null;
        }


    }
}