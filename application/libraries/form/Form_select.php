<?php

Class Form_select{
    
    /**
     * Retorna arreglo preparado
     * para llenar elemento form select
     * @param array $lista
     * @param string $campo nombre del campo de BD de clave
     * @return array
     */
    public function populateMultiselect($lista, $campo){
        $retorno = array();
        if(!is_null($lista) and count($lista)>0){
            foreach($lista as $row){
                $retorno[] = $row[$campo];
            }
        }
        return $retorno;
    }
    
}

