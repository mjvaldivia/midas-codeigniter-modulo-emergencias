<?php


class Marea_Roja_Actas_Model extends MY_Model {



    protected $_tabla = "marea_roja_actas";

    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id_acta", $id);
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
        return $this->_query->update($data, "id_acta", $id);
    }

    /**
     *
     */
    public function delete($id){
        $this->_query->delete("id_acta", $id);
    }
    
    /**
     * Cuenta la cantidad de resultados
     * @param type $parametros
     * @return int
     */
    public function contar($parametros = array()){
        
        
        $result = $this->_listar($parametros)
                       ->select("count(*) as cantidad", false)
                      ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){
        $result = $this->_listar($parametros)->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Consulta para listar
     * @param array $parametros
     * @return queryBuilder
     */
    protected function _listar($parametros = array()){
        $query = $this->_query->select("a.*")
            ->from($this->_tabla . " a")
            ->orderBy("id_acta", "DESC");

        if(!empty($parametros["id_marea"])){
            $query->whereAND("a.id_marea", $parametros["id_marea"]);
        }
        
        return $query;
    }
}