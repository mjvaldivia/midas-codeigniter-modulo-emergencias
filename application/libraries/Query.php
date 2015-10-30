<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 13-08-15
 * Time: 08:16 AM
 */
class Query{
    
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
     * @param $db
     */
    public function __construct($db) {
        $this->_db = $db;
    }
    
    /**
     * 
     * @param string $table
     */
    public function setTable($table){
        $this->_table = $table;
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
     * Retorna un registro de acuerdo al campo $primary
     * @param string $primary
     * @param string $id
     * @return mixed
     */
    public function getById($primary, $id){
        $query = $this->db->query("SELECT * FROM " . $this->_table . " WHERE " . $primary . " = ?", array($id));
        
        if ($query->num_rows() > 0){
           return $query->row(); 
        } else {
           return NULL;
        }
    }
}

