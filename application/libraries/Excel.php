<?php

require_once APPPATH.'/third_party/PHPExcel/PHPExcel.php';

Class Excel{
    
    protected $_excel;
    
    public function __construct() {
        $this->_excel = New PHPExcel();
    }
    
    public function nuevoExcel(){
        return $this->_excel;
    }
}

