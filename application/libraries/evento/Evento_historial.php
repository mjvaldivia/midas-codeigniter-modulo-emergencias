<?php

Class Evento_historial{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var int 
     */
    protected $_id_usuario;
    
    /**
     * 
     * @param int $id_emergencia
     * @param string $comentario
     */
    static function putHistorial($id_emergencia, $comentario){
        $ci =& get_instance();
        $historial = New Evento_historial();
        $historial->setUsuario($ci->session->userdata('session_idUsuario'));
        $historial->setEmergencia($id_emergencia);
        return $historial->guardar($comentario);
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model('alarma_historial_model','alarma_historial_model');
        $this->_id_usuario = $this->_ci->session->userdata('session_idUsuario');
    }
    
    /**
     * 
     * @param int $id_usuario
     */
    public function setUsuario($id_usuario){
        $this->_id_usuario = $id_usuario;
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_id_emergencia = $id_emergencia;
    }
    
    /**
     * 
     * @param string $comentario
     * @return int
     */
    public function guardar($comentario){
        $data = array(
            'historial_alerta' => $this->_id_emergencia,
            'historial_usuario' => $this->_id_usuario,
            'historial_fecha' => date('Y-m-d H:i:s'),
            'historial_comentario' => $comentario
        );
        return $this->_ci->alarma_historial_model->query()->insert($data);
    }
}

