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
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = true;
     
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('model/QueryBuilder');
        $this->load->library('Enviroment');
        
        
        $this->db = $this->getDb();
        
        $this->_query = New QueryBuilder($this->db);
        $this->_query->setTable($this->_tabla);
    }
    
    public function getDb(){
       /* if($this->_bo_simulacion){*/
            $this->_enviroment = New Enviroment();
        /*    return $this->load->database($this->_enviroment->getDatabase(), true);
        } else {*/
            return $this->load->database(ENVIRONMENT, true);
       // }
    }
    
    /**
     * Retorna HELPER para consultas generales
     * @return Query
     */
    public function query(){
        return $this->_query;
    }
    
    
}

