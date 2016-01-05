<?php

Class Archivo_upload{
    
    /**
     *
     * @var string 
     */
    protected $_path = "./media/doc/uploads/";
    
    /**
     *
     * @var string
     */
    protected $_error = "";
    
    /**
     *
     * @var Archivo_Model 
     */
    protected $_archivo_model;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var CI_Upload
     */
    protected $upload;
    
    /**
     *
     * @var CI_Session
     */
    protected $session;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("archivo_model");
        $this->_ci->load->library(array('upload',"session")); 
        
        $this->session = New CI_Session();
        
        $this->_archivo_model = New Archivo_Model();
    }
    
    /**
     * @param string $file_name
     * @return boolean
     */
    public function upload($file_name){
        $path = $this->_nuevoDirectorio();
        $config = array('upload_path'   => $path,
                        'allowed_types' => 'gif|jpg|png|bmp|doc|docx|pdf|xls|xlsx|txt|ppt|pptx',
                        'max_size'   => '0',
                        'max_width'  => '0',
                        'max_height' => '0');
                
        $this->upload = New CI_Upload($config);
        
        if ( ! $this->upload->do_upload($file_name))
        {
            rmdir($path);
            $this->_error = $this->upload->display_errors();
            return false;
        }
        else
        {
            $data = $this->upload->data();
            
            $relative_path = str_replace(realpath(BASEPATH . "../"), "", realpath($data["full_path"]));
            $relative_path = substr($relative_path, 1, strlen($relative_path));
            
            $insert = array("arch_c_tamano" => $data["file_size"],
                            "arch_c_nombre" => $relative_path,
                            "arch_c_mime"   => $data["file_type"],
                            "arch_c_hash"   => $this->_fileHash(),
                            "arch_f_fecha"  => DATE("Y-m-d H:i:s"),
                            "usu_ia_id"     => $this->session->userdata('session_idUsuario'));
            $this->_archivo_model->query()
                                 ->insert($insert);
            return true;
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getError(){
        return $this->_error;
    }
    
    /**
     * Retorna el HASH que identifica al archivo
     * @return string
     */
    protected function _fileHash(){
        $hash = $this->_rand_string(15);
        $existe = $this->_archivo_model->getByHash($hash);
        if(is_null($existe)){
            return $hash;
        } else {
            return $this->_fileHash();
        }
    }
    
    /**
     * 
     * @return string
     */
    protected function _nuevoDirectorio(){
        $random = $this->_rand_string(12);
        if(is_dir($this->_path . $random)){
            return $this->_nuevoDirectorio();
        } else {
            mkdir($this->_path . $random);
            return $this->_path . $random;
        }
    }
    
    /**
     * Genera un nombre aleatorio para el archivo temporal
     * @param int $length
     * @return string
     */
    protected function _rand_string( $length ) {
        $str = "";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
    }
}

