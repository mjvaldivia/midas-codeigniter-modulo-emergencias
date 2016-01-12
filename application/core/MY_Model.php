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
     *
     * @var Enviroment 
     */
    protected $_enviroment;
     
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('model/QueryBuilder');
        $this->load->library('Enviroment');
        
        $this->_enviroment = New Enviroment();
        $this->db = $this->load->database($this->_enviroment->getDatabase(), true);
        
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

