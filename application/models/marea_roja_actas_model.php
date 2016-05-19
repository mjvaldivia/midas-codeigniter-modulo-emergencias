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
}