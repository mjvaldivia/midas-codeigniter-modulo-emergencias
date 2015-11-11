<?php

Class MY_Model extends CI_Model {
    
     /**
     * QueryBuilder
     * @var QueryBuilder
     */
    protected $_query;
    
    /**
     * Db table name
     * @var string 
     */
    protected $_tabla;
     
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('model/QueryBuilder');
        $this->_query = New QueryBuilder($this->db);
        $this->_query->setTable($this->_tabla);
    }
    
    /**
     * Retorna HELPER para consultas generales
     * @return Query
     */
    public function query(){
        return $this->_query;
    }
    
    
}

