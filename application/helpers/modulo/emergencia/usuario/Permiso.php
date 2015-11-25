<?php

require_once(APPPATH . "helpers/modulo/layout/usuario/Permiso.php");

Class Emergencia_Usuario_Permiso extends Layout_Usuario_Permiso{
    
    /**
     * 
     * @return boolean
     */
    public function puedeFinalizarEmergencia(){
        return $this->usuario->getPermisoFinalizarEmergencia();
    }
}

