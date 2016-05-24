<?php

Class Cosof_Validar{
    
    /**
     *
     * @var boolean 
     */
    protected $_correcto = true;
    
    /**
     *
     * @var array 
     */
    protected $_error = array();
    
    protected $_ci;
    
    public function __construct() {
        $this->_ci =& get_instance(); 
    }
    
    /**
     * 
     * @return boolean
     */
    public function getCorrecto(){
        return $this->_correcto;
    }
    
    /**
     * 
     * @return array
     */
    public function getErrores(){
        return $this->_error;
    }
    
    /**
     * 
     */
    public function validarRut($rut){
        if(TRIM($rut) != ""){
            $rut = preg_replace('/[^k0-9]/i', '', $rut);
            $dv  = substr($rut, -1);
            $numero = substr($rut, 0, strlen($rut)-1);
            $i = 2;
            $suma = 0;
            foreach(array_reverse(str_split($numero)) as $v)
            {
                if($i==8)
                    $i = 2;

                $suma += $v * $i;
                ++$i;
            }

            $dvr = 11 - ($suma % 11);

            if($dvr == 11)
                $dvr = 0;
            if($dvr == 10)
                $dvr = 'K';

            if($dvr == strtoupper($dv))
                return true;
            else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param string $fecha fecha
     * @param string $formato formato de entrada
     * @return boolean
     */
    public function validarFechaSpanish($fecha, $formato = "d-m-Y h:i"){
        $date = DateTime::createFromFormat($formato, $fecha);
        if($date instanceof DateTime){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param string $string
     * @return boolean
     */
    public function validarVacio($string){
        if(strip_tags(TRIM($string)) == ""){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 
     * @param array $array
     * @return boolean
     */
    public function validarArregloVacio($array){
        if(count($array)>0){
            return true;
        } else {
            return false;
        }
    }
}