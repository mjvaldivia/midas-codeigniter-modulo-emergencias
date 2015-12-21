<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class QueryBuilder{
    
    /**
     * Nombre de tabla
     * @var string
     */
    protected $_table;
    
    /**
     *
     * @var Database 
     */
    protected $_db;
    
    /**
     *
     * @var string 
     */
    protected $select = "";
    
    /**
     *
     * @var string 
     */
    protected $from = "";
    
    /**
     *
     * @var string 
     */
    protected $where = "";
    
    /**
     *
     * @var string 
     */
    protected $orderBy = "";
    
    /**
     *
     * @var string 
     */
    protected $groupBy = "";
    
    /**
     *
     * @var string 
     */
    protected $join = "";
    
    /**
     *
     * @var string 
     */
    protected $limit = "";
    
    /**
     *
     * @var array 
     */
    protected $valores = array();
    
    /**
     * 
     * @param $db
     */
    public function __construct($db = NULL) {
        if(empty($db)){
            
        } else {
            $this->_db = $db;
        }
    }
    
    /**
     * 
     * @param string $table
     */
    public function setTable($table){
        $this->_table = $table;
    }
    
    /**
     * Campos a rescatar
     * @param array $campos
     * @param boolean $append
     * @return \Query
     */
    public function select($campos, $append = true){
        $sql = '';
        if(empty($this->select) or $append == false){
            $sql = 'SELECT ';
        }else{
            $sql = $this->select.',';
        }

        if(is_array($campos)){
            foreach($campos as $campo){
                $sql .= $campo.',';
            }
            $sql = trim(',',$sql);
        }else{
            $sql .= ' '.$campos;
        }

        $this->select = $sql . " ";
        return $this;
    }
    
    /**
     * Tabla from de la consulta
     * @param string $tabla
     * @return \Query
     */
    public function from($tabla = NULL){
        
        if(is_null($tabla)){
            $tabla = $this->_table;
        }
        
        $sql = ' FROM '.$tabla.' ';
        $this->from .= $sql;
        return $this;
    }
    
    /**
     * [whereAnd description]
     * @param  string $campo     
     * @param  mixed $valor     
     * @param  string $condicion 
     * @return Database            
     */
    public function whereAND($campo,$valor,$condicion='='){
        $agregar_valores = true;
        
        $sql = '';

        if(empty($this->where)){
            $this->where = " WHERE ";
        }else{
            $this->where .= " AND ";
        }
                
        $this->where .= $this->_condiciones($campo, $condicion, $valor);
        $this->_valores($condicion, $valor);
        
        return $this;
    }
    
    /**
     * 
     * @param type $campo
     * @param type $valor
     * @param type $condicion
     * @return \Query
     */
    public function whereOR($campo,$valor,$condicion='='){
        $sql = '';

        if(empty($this->where)){
            $sql = " WHERE $campo $condicion ? ";
        }else{
            $sql = " OR $campo $condicion ? ";
        }

        $this->where .= $sql;
        $this->valores[] = $valor;
        return $this;
    }

    /**
     * 
     * @param type $campo
     * @param type $orden
     * @param type $append
     * @return \Query
     */
    public function orderBy($campo, $orden='ASC', $append = true){
        $sql = '';

        if(empty($this->orderBy)){
            $sql = " ORDER BY $campo $orden";
        }else{
            if($append){
                $sql = $this->orderBy . ", $campo $orden";
            } else {
                if($campo == ""){
                    $sql = "";
                }else {
                    $sql = " ORDER BY $campo $orden";
                }
            }
        }

        $this->orderBy = $sql;
        return $this;
    }
    
    /**
     * [groupBy description]
     * @param  [type] $campo [description]
     * @return [type]        [description]
     */
    public function groupBy($campo, $append = true){
        $sql = '';

        if(empty($this->groupBy) OR !$append){
            if($campo!=""){
                $sql = " GROUP BY $campo";
            } else {
                $sql = "";
            }
        }else{
            $sql = $this->groupBy . ", $campo";
        }

        $this->groupBy = $sql;
        return $this;
    }
    
    /**
     * 
     * @param type $tabla
     * @param type $condicion
     * @param type $tipo
     * @return \Query
     */
    public function join($tabla,$condicion,$tipo='LEFT'){
        $sql = '';

        if(empty($this->join)){
            $sql = " $tipo JOIN $tabla ON $condicion ";
        }else{
            $sql = $this->join . " $tipo JOIN $tabla ON $condicion ";
        }

        $this->join = $sql;
        return $this;
    }
    
    /**
     * 
     * @param type $comienzo
     * @param type $total
     * @return \Query
     */
    public function limit($comienzo,$total=''){
        $sql = " LIMIT $comienzo";

        if(!empty($total) && is_numeric($total)){
            $sql .= ",$total ";
        }

        $this->limit = $sql;
        return $this;
    }
    
    /**
     * Obtener solo un resultado de query general formada
     * @return object
     */
    public function getOneResult(){
        $query = $this->getQuery();

        $result = $this->_db->query($query, $this->valores);
        $this->_clear();
        if ($result->num_rows() > 0){
           return $result->row(); 
        } else {
           return NULL;
        }
    }
    
    /**
     * Retorna lista de resultados asociativos
     * @return array
     */
    public function getAllResult(){
        $query = $this->getQuery();

        $result = $this->_db->query($query, $this->valores);
        $this->_clear();
        if ($result->num_rows() > 0){
            return $result->result_array();
        } else {
           return NULL;
        }
    }
    
    /**
     * Retorna la query a ejecutar
     * @return string
     */
    public function getQuery(){
        return $this->select . $this->from . $this->join . $this->where  . $this->groupBy . $this->orderBy . $this->limit;
    }

    
    /**
     * Ingresa datos en tabla
     * @param string $tabla
     * @param array $parametros
     * @return int identificador del nuevo registro
     */
    public function insert($parametros){
        
        $campos_tabla = "";
        $valores_tabla = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $campos_tabla  .= $coma . $campo;
            $valores_tabla .= $coma . "?";
            $coma = ",";
        }
        
        $sql = "INSERT INTO " . $this->_table. "(". $campos_tabla .") VALUES(". $valores_tabla .")";
        $this->_db->query($sql, array_values($parametros));
        return $this->_db->insert_id();
    }
    
    /**
     * Actualiza datos de la tabla
     * @param array $parametros
     * @param int $primaria
     * @param int $id
     * @return boolean
     */
    public function update($parametros = array(), $primaria, $id ){
        $sql = "UPDATE " . $this->_table. " SET ";
        $set = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $set .= $coma. $campo . " = ?";
            $coma = ",";
        }
        $where = " WHERE " . $primaria . " = ?";
        return $this->_db->query($sql . $set . $where, array_merge(array_values($parametros), array($id)));
    }
    
    /**
     * Retorna un registro de acuerdo al campo $primary
     * @param string $primary
     * @param string $id
     * @return mixed
     */
    public function getById($primary, $id){
        $query = $this->_db->query("SELECT * FROM " . $this->_table . " WHERE " . $primary . " = ?", array($id));
        
        if ($query->num_rows() > 0){
           return $query->row(); 
        } else {
           return NULL;
        }
    }
    
    /**
     * Helper model para ingresar datos en relaciones de uno a muchos
     * @param string $primary
     * @param string $secondary
     * @param int $id_primary
     * @param array $array_id_secondary
     */
    public function insertOneToMany($primary, $secondary, $id_primary, $array_id_secondary){
        $query = $this->_db->query("SELECT * FROM " . $this->_table . " WHERE " . $primary . " = ?", array($id_primary));
        
        $guardados = array();
        
        if ($query->num_rows() > 0){
            $lista = $query->result_array();
            foreach ($lista as $row){
                if(!in_array($row[$secondary], $array_id_secondary)){
                    $query = $this->_db->query("DELETE FROM " . $this->_table . " WHERE " . $primary . " = ? AND ". $secondary . " = ?", array($id_primary, $row[$secondary]));
                } else {
                    $guardados[] = $row[$secondary];
                }
            }
        }
        
        foreach($array_id_secondary as $key => $id_secondary){
            if(!in_array($id_secondary, $guardados)){
                $insert = array($primary => $id_primary,
                                $secondary => $id_secondary);
                $this->insert($insert);
            }
        }
        
        
    }
    
    /**
     * Agrega valores de comparar a la consulta
     * @param string $condicion tipo de condicion
     * @param string $valor valor a comparar
     */
    protected function _valores($condicion, $valor){
        if($condicion == "IS NULL" OR $condicion == "IS NOT NULL"){
            $agregar_valores = false;
        } else {
            $agregar_valores = true;
        }
        
        if($agregar_valores){
            if(is_array($valor)){
                foreach($valor as $key => $value){
                    $this->valores[] = $value;
                }
            } else {
                $this->valores[] = $valor;
            }
        }
    }
    
    /**
     * Arma condiciones para el Where
     * @param string $campo campo de la tabla
     * @param string $condicion tipo de condicion
     * @param string $valor valor a comparar
     * @return string
     */
    protected function _condiciones($campo, $condicion, $valor){
        $sql = "";
        switch ($condicion) {
            case $condicion == "IN" OR $condicion == "NOT IN":
                $arreglo = "";
                $coma = "";
                if(count($valor)>0){
                    foreach($valor as $field){
                        $arreglo .= $coma." ? ";
                        $coma = ",";
                    }
                $sql .= $campo. " ".$condicion." (".$arreglo.")";
                }
                break;
            case $condicion == "IS NULL" OR $condicion == "IS NOT NULL":
                $agregar_valores = false;
                $sql .= $campo. " " . $condicion;
                break;
            default:
                $sql .= $campo. " " . $condicion . " ? ";
                break;
        }
        return $sql;
    }
    
    protected function _clear(){
        $this->select = "";
        $this->from   = "";
        $this->groupBy = "";
        $this->where = "";
        $this->join = "";
        $this->limit = "";
        $this->valores = array();
        $this->orderBy = "";
    }


    public function delete($primary, $id){

        return $this->_db->query("DELETE FROM " . $this->_table . " WHERE " . $primary . " = ?", array($id));
        
    }
}

