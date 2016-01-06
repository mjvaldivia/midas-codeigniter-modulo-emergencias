<?php

class Archivo_Emevisor_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "archivo_vs_emevisor";
    
    /**
     * Borra registros relacionados a archivo
     * @param int $id_archivo
     */
    public function deletePorArchivo($id_archivo){
        $this->query()->delete("arch_ia_id", $id_archivo);
    }
}

