<?php

require_once(APPPATH . "helpers/modulo/layout/usuario/Permiso.php");

Class Emergencia_Usuario_Permiso extends Layout_Usuario_Permiso{
    
    /**
     * 
     * @return boolean
     */
    public function puedeFinalizarEmergencia($id_modulo){
        $this->usuario->setModulo($id_modulo);
        return $this->usuario->getPermisoFinalizarEmergencia();
    }
}

