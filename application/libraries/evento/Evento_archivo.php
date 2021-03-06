<?php

Class Evento_archivo{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_evento;
    
    /**
     *
     * @var array 
     */
    protected $_agregados;
    
    /**
     * Directorio de archivos
     * @var string
     */
    protected $_dir = "media/doc/emergencia/";
    
    /**
     * Ubicacion del archivo
     * @var string 
     */
    protected $_path = "";
    
    /**
     * Si se eliminan o no los archivos no agregados
     * @var boolean
     */
    protected $_eliminar = true;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("cache");
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_archivo_model", "_emergencia_archivo_model");
        $this->_ci->load->model("archivo_model", "_archivo_model");
        
        
    }
    
    /**
     * 
     * @param boolean $boolean
     */
    public function setEliminar($boolean){
        $this->_eliminar = $boolean;
    }
    
    /**
     * 
     * @param int $id_evento
     * @throws Exception
     */
    public function setEvento($id_evento){
        $this->_evento = $this->_ci->_emergencia_model->getById($id_evento);
        if(is_null($this->_evento)){
            throw new Exception("El evento no existe");
        }
        
        $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $this->_evento->eme_d_fecha_recepcion);
        if(!($fecha instanceof DateTime)){
            $fecha = New DateTime("now");
        }
        
        if(!is_dir(FCPATH . $this->_dir . $fecha->format("Y"))){
            mkdir(FCPATH . $this->_dir . $fecha->format("Y"), "0755");
        }
        
        $this->_path = $this->_dir . $fecha->format("Y") . "/" . $this->_evento->eme_ia_id . "/";
        
        if(!is_dir(FCPATH . $this->_path)){
            mkdir(FCPATH . $this->_path, "0755");
        }
    }
    
    /**
     * Agrega los archivos que ya existian en el evento al stack
     */
    public function agregarArchivosAnteriores(){
        $lista = $this->_ci->_emergencia_archivo_model->listaPorEmergencia($this->_evento->eme_ia_id);
        if(count($lista)>0){
            foreach($lista as $archivo){
                $this->_agregados[] = $archivo["arch_ia_id"];
            }
        }
    }
    
    /**
     * Asocia archivos al evento
     */
    public function guardar(){
        
        if($this->_eliminar){
            //se elimina el archivo fisico si no esta asignado a ningun otro evento
            $this->_ci->_emergencia_archivo_model
                      ->deleteArchivoNotIn($this->_evento->eme_ia_id, $this->_agregados);
        
        
            //se elimina la relacion
            $this->_ci->_emergencia_archivo_model
                      ->query()
                      ->insertOneToMany("id_emergencia", "id_archivo", $this->_evento->eme_ia_id, $this->_agregados);        
        } else {
            foreach($this->_agregados as $archivo){
                $this->_ci->_emergencia_archivo_model->insert(
                    array(
                        "id_archivo" => $archivo,
                        "id_emergencia" => $this->_evento->eme_ia_id
                    )
                );
            }
        }
    }
    
    /**
     * Agrega archivo
     * @param string $hash
     * @param int $tipo
     * @param int $id
     */
    public function addArchivo($hash, $descripcion, $tipo, $id = null, $id_usuario){
        $cache = Cache::iniciar();
        $archivo = $this->_ci->_archivo_model->getById($id);
        if(!is_null($archivo)){
            $this->_agregados[] = $archivo->arch_ia_id;
        } else {
            if($temporal = $cache->load($hash)){
                $nuevo_hash = $this->_ci->_archivo_model->newHash();
                $nombre_archivo = $nuevo_hash . "." . $temporal["tipo"];
                file_put_contents(FCPATH . $this->_path . $nombre_archivo, $temporal["archivo"]);
                
                $data = array("arch_c_nombre" => $temporal["archivo_nombre"],
                              "arch_c_descripcion" => $descripcion,
                              "path" => $this->_path . $nombre_archivo,
                              "arch_c_mime" => $temporal["mime"],
                              "arch_c_tipo" => $tipo,
                              "arch_c_hash" => $nuevo_hash,
                              "usu_ia_id" => $id_usuario,
                              "arch_f_fecha" => Date("Y-m-d H:i:s"));
                $this->_agregados[] = $this->_ci->_archivo_model->insert($data);
            }
        }
        
        return $this->_agregados[count($this->_agregados)-1];
    }
}

