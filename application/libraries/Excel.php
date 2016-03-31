<?php

require_once APPPATH.'/third_party/PHPExcel/PHPExcel.php';

Class Excel{
    
    protected $_excel;
    
    /**
     * 
     */
    public function __construct() {
        $this->_excel = New PHPExcel();
    }
    
    /**
     * 
     * @return type
     */
    public function nuevoExcel(){
        return $this->_excel;
    }
    
    /**
     * 
     * @param type $ubicacion
     * @return type
     */
    public function leerExcel($ubicacion){
       $tipo = PHPExcel_IOFactory::identify($ubicacion);
       $excel = \PHPExcel_IOFactory::createReader($tipo);
       return $excel->load($ubicacion);
    }
}

