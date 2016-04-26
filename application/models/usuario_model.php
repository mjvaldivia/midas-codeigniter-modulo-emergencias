<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Vladimir
 * @since 14-09-15
 */
class Usuario_Model extends MY_Model {

    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "usuarios";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
    /**
     *
     * @var Modulo_Model 
     */
    protected $_modulo_model;
    
    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct();
        $this->load->model("modulo_model");
        $this->load->model("cargo_model");
        $this->_modulo_model = New Modulo_Model();
    }
    
    /**
     * Retorna la alarma por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        $clave = $this->_tabla . "_getid_" . $id;
        if(!Zend_Registry::isRegistered($clave)){
            Zend_Registry::set($clave, $this->_query->getById("usu_ia_id", $id));
        }
        return Zend_Registry::get($clave);
    }
    
    /**
     * 
     * @param string $login
     * @return type
     */
    public function getByLogin($login){
        return $this->_query->getById("usu_c_login", $login);
    }
    
    /**
     * 
     * @param string $nombre
     * @param string $apellido_paterno
     * @param string $apellido_materno
     * @return type
     */
    public function getByNombre($nombre, $apellido_paterno, $apellido_materno){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("usu_c_nombre", $nombre)
                               ->whereAND("usu_c_apellido_paterno", $apellido_paterno)
                               ->whereAND("usu_c_apellido_materno", $apellido_materno)
                               ->getOneResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param string $usuario
     * @param string $password
     * @return array
     */
    public function getByUserAndPass($usuario, $password){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("usu_c_login", $usuario)
                               ->whereAND("usu_c_clave", sha1($password))
                               ->getOneResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("usu_ia_id", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Actualiza la alarma
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "usu_ia_id", $id);
    }
    
    /**
     * 
     * @param array $data
     * @return int identificador usuario ingresado
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * 
     * @param int $id_region
     * @return array
     */
    public function listarUsuariosPorRegion($id_region){
        $result = $this->_query->select("DISTINCT u.*")
                               ->from($this->_tabla . " u")
                               ->join("usuarios_region r", "r.id_usuario = u.usu_ia_id", "INNER")
                               ->whereAND("r.id_region", $id_region)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_rol
     * @return array
     */
    public function listarUsuariosPorRol($id_rol){
        $result = $this->_query->select("DISTINCT u.*")
                               ->from($this->_tabla . " u")
                               ->join("usuarios_vs_roles ur", "ur.usu_ia_id = u.usu_ia_id", "INNER")
                               ->whereAND("ur.rol_ia_id", $id_rol)
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista usuarios pertenecientes a emergencias
     */
    public function listarUsuariosEmergencia($rut = NULL, $nombre = NULL, $id_region = NULL){
        $query = $this->_query->select("DISTINCT u.*")
                               ->from($this->_tabla . " u");
                               /*->join("usuarios_vs_roles ur", "ur.usu_ia_id = u.usu_ia_id", "INNER")
                               ->join("roles_vs_permisos rp", "rp.rol_ia_id = ur.rol_ia_id", "INNER")
                               ->whereAND("rp.per_ia_id", $this->_modulo_model->listSubmodulos(), "IN");*/

        if(!is_null($rut) and $rut!=""){
            $query->whereAND("u.usu_c_rut", "%" . $rut . "%", "LIKE");
        }
        
        if(!is_null($nombre) and $nombre!=""){
            $query->whereAND("CONCAT_WS(\" \", u.usu_c_nombre, u.usu_c_apellido_paterno, u.usu_c_apellido_materno)", "%" . $nombre . "%", "LIKE");
        }
        
        if(!is_null($id_region) and $id_region != ""){
            $query->whereAND("u.reg_ia_id", $id_region);
        }
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $tipo_emergencia
     * @param string $comunas comunas separadas por coma
     * @param int $id_usuario_excluir
     * @return array
     */
    public function listarDestinatariosCorreo($tipo_emergencia = null, $comunas = null, $id_usuario_excluir = null) {

        $excluir_str = ($id_usuario_excluir == null) ? "" : " AND u.usu_ia_id <> $id_usuario_excluir";

        $qry = "
                SELECT distinct(a.usu_c_email) as usu_c_email FROM (
                    SELECT distinct(usu_c_email) usu_c_email FROM usuarios u
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE crg_ia_id IN (".Cargo_Model::SEREMI.",".Cargo_Model::JEFE_DAS.",".Cargo_Model::JEFE_SP.")
                    AND ovc.com_ia_id IN ($comunas) 
                    AND u.est_ia_id = 1 $excluir_str
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = ".Cargo_Model::CRE." AND usu_b_cre_activo = 1 
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str limit 1
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = ".Cargo_Model::JEFE_OFICINA."
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str
                
                UNION 
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    join usuarios_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = ".Cargo_Model::EAT_REGIONAL."
                    AND teva.aux_ia_id = $tipo_emergencia 
                    AND ovc.com_ia_id IN ($comunas)
                    AND u.est_ia_id = 1 $excluir_str
                UNION
                    SELECT distinct(usu_c_email) usu_c_email from usuarios u 
                    join usuarios_ambitos uva on uva.usu_ia_id = u.usu_ia_id
                    join tipo_emergencia_vs_ambitos teva on teva.amb_ia_id=uva.amb_ia_id
                    JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                    JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                    WHERE u.crg_ia_id = ".Cargo_Model::EAT_OFICINA."
                    AND teva.aux_ia_id = $tipo_emergencia
                    AND ovc.com_ia_id IN ($comunas) $excluir_str
                    AND u.est_ia_id = 1) a
               ";
        $row = array();
        if ($result = $this->db->query($qry))
            $row = $result->result_array();
        return $row;
    }
    
    
    
    public function generaKeyId($idUser = null) {
        $key_id = ($idUser == null) ? md5(uniqid($idUser)) : md5(uniqid());
        $query = $this->db->query('INSERT INTO nologin (usu_ia_id,key_id) VALUES (' . $idUser . ',"' . $key_id . '")');
        if ($query)
            return $key_id;
        else
            return false;
    }

    public function bajaKeyId($key_id = null) {

        $query = $this->db->query('UPDATE nologin SET activo = 0 WHERE key_id = "' . $key_id . '"');
        return $query;
    }

    public function validaKey($key_id = null) {

        $query = $this->db->query('SELECT u.usu_c_rut, n.activo FROM nologin n join usuarios u on u.usu_ia_id = n.usu_ia_id WHERE key_id = "' . $key_id . '"');
        $row = $query->result_array();
        return $row[0];
    }

    function nologin($rut = null) {

        $this->load->model("session_model", "SessionModel");
        $resultado = $this->SessionModel->autentificar($rut);

        if (!$resultado) {
            show_error("Ha ocurrido un error interno", 500);
        }
        return;
    }

    public function get_mails($id_region = null) {
        $result = $this->db->query("select CONCAT(TRIM(u.usu_c_nombre),' ',TRIM(u.usu_c_apellido_paterno)) nombre, u.usu_c_email from usuarios u
                   where u.reg_ia_id = $id_region
                    AND u.est_ia_id = 1");
        $res = array();

        foreach ($result->result_array() as $row) {
            $res[] = '('.$row['nombre'].') '.$row['usu_c_email'];
        }

        echo json_encode($res);
    }


    public function getByEmail($email){
        $query = "select * from usuarios where usu_c_email = ? limit 1";
        $resultado = $this->db->query($query,array($email));
        if($resultado->num_rows() > 0){
            foreach ($resultado->result_array() as $row) {
                $usuario = $row;
            }
            return $usuario;
        }else{
            return null;
        }
    }

}
