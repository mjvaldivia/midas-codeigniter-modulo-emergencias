<?php
if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Alarma_Model extends MY_Model {

    /**
     * Alarma rechazada
     * @see tip_ia_id en tabla alertas 
     */
    const RECHAZADO = 2;
    
    /**
     * La alarma se convierte en 
     * emergencia
     * @see tip_ia_id en tabla alertas 
     */
    const ACTIVADO = 1;
    
    /**
     * La alarma esta ingresada
     * @see tip_ia_id en tabla alertas 
     */
    const REVISION = 3;

    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "alertas";
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    /**
     *
     * @var Usuario_comunas 
     */
    public $usuario_comunas;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->_session = New CI_Session();
        $this->load->library("usuario/usuario_comunas");
        $this->usuario_comunas = New Usuario_comunas();
    }
        
    /**
     * Retorna la alarma por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("ala_ia_id", $id);
    }
    
    /**
     * Actualiza la alarma
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "ala_ia_id", $id);
    }
    
    /**
     * 
     * @param int $id_estado id del estado
     * @return int
     */
    public function cantidadAlarmasPorEstado($id_estado){
        $result = $this->_queryAlarmasPorEstado($id_estado)
                       ->select("COUNT(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        }else{
            return 0;
        }
    }
    
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function buscar(array $parametros = array()){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a");
        
        if(!empty($parametros["id_estado"])){
            $query->whereAND("a.est_ia_id", $parametros["id_estado"], "=");
        }
        
        if(!empty($parametros["id_tipo"])){
            $query->whereAND("a.tip_ia_id", $parametros["id_tipo"], "=");
        }
        
        if(!empty($parametros["year"])){
            $query->whereAND("year(a.ala_d_fecha_recepcion)", $parametros["year"], "=");
        }
        
        $this->_addQueryComunas($query);
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_estado id del estado
     * @return array
     */
    public function listarAlarmasPorEstado($id_estado){
        $result = $this->_queryAlarmasPorEstado($id_estado)
                       ->orderBy("a.ala_d_fecha_recepcion", "DESC")
                       ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param type $id_region
     * @param DateTime $fecha_inicio
     * @param DateTime $fecha_termino
     */
    public function listarPorRegionYFecha($id_region, $fecha_inicio = NULL, $fecha_termino = NULL){
        $query = $this->_queryAlarmasPorRegion($id_region);
        
        if($fecha_inicio instanceof DateTime){
            $query->whereAND("ala_d_fecha_emergencia", $fecha_inicio->format("Y-m-d H:i:s"), ">=");
        }
        
        if($fecha_termino instanceof DateTime){
            $query->whereAND("ala_d_fecha_emergencia", $fecha_termino->format("Y-m-d H:i:s"), "<=");
        }
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista alarmas por la region
     * @param int $id_region
     * @return array
     */
    public function listarPorRegion($id_region){
        $result = $this->_queryAlarmasPorRegion($id_region)
                       ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista todas las alarmas
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("ala_d_fecha_recepcion", "DESC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista alarmas entre fechas dadas
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     * @return array
     */
    public function listarAlarmasEntreFechas($fecha_desde, $fecha_hasta){
        $result = $this->_queryAlarmasEnRevisionEntreFechas($fecha_desde, $fecha_hasta)
                       ->orderBy("a.ala_d_fecha_recepcion", "DESC")
                       ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Retorna cantidad de alarmas entre fechas dadas
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     * @return int
     */
    public function cantidadAlarmasEntreFechas($fecha_desde, $fecha_hasta){
        $result = $this->_queryAlarmasEnRevisionEntreFechas($fecha_desde, $fecha_hasta)
                       ->select("COUNT(*) as cantidad")
                       ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        }else{
            return 0;
        }
    }
    
    public function obtenerEstados()
    {

        $query = $this->db->query("select * from estados_alertas order by est_c_nombre;");

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function filtrarAlarmas($params) {
        $mapeo = array(
            "estado" => "a.est_ia_id",
            "tipoEmergencia" => "a.tip_ia_id",
            "anio" => "year(a.ala_d_fecha_recepcion)"
        );

        $where = "1=1";
        $queryParams = array();

        foreach ($params as $llave => $valor) {
            $queryParams[] = $valor;
            $where .= " and " . $mapeo[$llave] . " = ?";
        }

        $sql = "
            select
                a.*,
                 (select GROUP_CONCAT(c.com_c_nombre SEPARATOR ', ') from comunas c
                                       join    alertas_vs_comunas avc on c.com_ia_id = avc.com_ia_id
                                       where avc.ala_ia_id = a.ala_ia_id
                                     ) comunas,
                te.aux_c_nombre as ala_c_tipo_emergencia
            from
              alertas a
              left join auxiliar_emergencias_tipo te on a.tip_ia_id = te.aux_ia_id
              where
                $where
            order by a.ala_ia_id desc , est_ia_id desc
        ";

        $query = $this->db->query($sql, $queryParams);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function obtenerTodas() {
        $sql = "
            select
                a.*
            from
              alertas a
            order by a.ala_ia_id desc
        ";

        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }

    public function enviaCorreo($params) {


        $comunas_query = $this->db->query("
            SELECT GROUP_CONCAT(com_c_nombre) comunas, GROUP_CONCAT(c.com_ia_id) id_comunas from comunas c join emergencias_vs_comunas avc
        on avc.com_ia_id = c.com_ia_id
        where avc.eme_ia_id = " . $params["eme_ia_id"]);

        $tipo_query = $this->db->query("select aux_c_nombre nombre from auxiliar_emergencias_tipo where aux_ia_id = '" . $params['tipo_emergencia'] . "'");


        $tipo_emergencia = $tipo_query->result_array();
        $comunas = $comunas_query->result_array();

        $params["id_tipo_emergencia"] = $params['tipo_emergencia'];
        $params['lista_comunas'] = $comunas[0]['comunas'];
        $params['lista_id_comunas'] = $comunas[0]['id_comunas'];
        $params['tipo_emergencia'] = $tipo_emergencia[0]['nombre'];

        return ($this->enviaMsjAlarma($params)) ? true : false;
    }

    public function enviaMsjAlarma($params) {
        $this->load->library('Simulacion');
        
        $error = 0;
        $this->load->helper('utils');
        $this->load->helper('session');
        $this->load->model("usuario_model", "UsuarioModel");
        $key_id = $this->UsuarioModel->generaKeyId($this->session->userdata('session_idUsuario'));
        $mensaje = "<b>EMERGENCIAS: Revisión de Evento</b><br><br>";
        $mensaje .= $this->session->userdata('session_nombres') . " ha registrado la alarma código : " . $params['eme_ia_id'] . "<br><br>";
        $mensaje .= "<b>Nombre de la emergencia:</b> " . $params['nombre_emergencia'] . "<br>";
        $mensaje .= "<b>Tipo de emergencia:</b> " . $params['tipo_emergencia'] . "<br>";
        $mensaje .= "<b>Nivel de emergencia:</b> " . $params['nivel_emergencia'] . "<br>";
        $mensaje .= "<b>Lugar o dirección de la emergencia:</b> " . $params['nombre_lugar'] . "<br>";
        $mensaje .= "<b>Comuna(s):</b> " . $params['lista_comunas'] . "<br>";
        $mensaje .= "<b>Fecha de la emergencia:</b> " . spanishDateToISO($params['fecha_emergencia']) . "<br>";
        $mensaje .= "<b>Fecha recepción de la emergencia:</b> " . spanishDateToISO($params['fecha_recepcion']) . "<br>";
        $mensaje .= "<b>Origen de la información:</b> " . $params['nombre_informante'] . "<br>";


        //$to = 'rukmini.tonacca@redsalud.gov.cl';
        //$to = 'vladimir@cosof.cl';
        $simulacion = New Simulacion();
        $subject = $simulacion . "EMERGENCIAS: Revisión de Evento";


        $this->load->model("Sendmail_Model", "SendmailModel");


        //obtengo al CRE activo y le mando el mail con la url de activacion
        /*$qry_usu_cre = $this->db->query("
                SELECT u.usu_ia_id,u.usu_c_email from usuarios u
                JOIN usuarios_vs_oficinas uvo ON uvo.usu_ia_id = u.usu_ia_id
                JOIN oficinas_vs_comunas ovc ON ovc.ofi_ia_id = uvo.ofi_ia_id
                WHERE crg_ia_id = 4 and usu_b_cre_activo=1
                AND ovc.com_ia_id IN (".$params['lista_id_comunas'].") limit 1");*/

        /*$id_usuario_excluir = null;
        if ($usu_cre = $qry_usu_cre->result_array()) {
            $mensajeCRE = $mensaje;
            $mensajeCRE .= "<a href='" . site_url('emergencia/generaEmergencia/id/' . $params['eme_ia_id'] . '/k/' . $key_id) . "'>URL del Evento a revisar</a><br>";
            $mensajeCRE .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'></img><br>";
            //envio mail al CRE
            $this->SendmailModel->emailSend($usu_cre[0]['usu_c_email'], null, null, $subject, $mensajeCRE);
            if ($this->session->userdata('session_idUsuario') == $usu_cre[0]['usu_ia_id']) {
                $id_usuario_excluir = $usu_cre[0]['usu_ia_id'];
            }
        } else {
            $error++;
        }*/


        // mando mail al resto
        $mensaje .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'></img><br>";
        /*$to = $this->SendmailModel->get_destinatariosCorreo($params["id_tipo_emergencia"], $params['lista_id_comunas'], $id_usuario_excluir);*/
        $to = $params['correos_evento'];
        
        if(count($to)>0){
        if (!$this->SendmailModel->emailSend($to, null, null, $subject, $mensaje)) {
            $error++;
        }
        } else {
            $error++;
        }
        return ($error==0)?true:false;
    }

    
    
    public function eliminarAlarma($id = 0) {
        $error = false;
        $this->db->trans_begin();

        $this->db->query("delete from alertas_historial where historial_alerta=$id");
        $this->db->query("delete from alertas_vs_comunas where ala_ia_id=$id");
        $this->db->query("delete from emergencias where eme_ia_id=$id");

        if ($this->db->trans_status() === FALSE) {
            $error = true;
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $error;
    }

    public function getJsonAlarma($params, $json = true) {


        $this->load->helper("utils");
        $sql = "
            select
                a.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                GROUP_CONCAT(avc.com_ia_id) comunas,
                GROUP_CONCAT(c.com_c_nombre) nombre_comunas,
                te.aux_c_nombre as tipo_emergencia
            from
              alertas a join usuarios u on a.usu_ia_id = u.usu_ia_id
              inner join auxiliar_emergencias_tipo te on a.tip_ia_id = te.aux_ia_id
              join alertas_vs_comunas avc on a.ala_ia_id = avc.ala_ia_id
              join comunas c on c.com_ia_id = avc.com_ia_id
            where a.ala_ia_id = ?";

        $query = $this->db->query($sql, array($params['id']));

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['hora_emergencia'] = ISOTimeTospanish($resultados['ala_d_fecha_emergencia']);
            $resultados['hora_recepcion'] = ISOTimeTospanish($resultados['ala_d_fecha_recepcion']);

            $resultados['ala_d_fecha_emergencia'] = ISODateTospanish($resultados['ala_d_fecha_emergencia']);
            $resultados['ala_d_fecha_recepcion'] = ISODateTospanish($resultados['ala_d_fecha_recepcion']);
        }

        if ($json)
            echo json_encode($resultados);
        else
            return $resultados;
    }
    
    /**
     * Consulta para alarmas por estado
     * @return QueryBuilder
     */
    protected function _queryAlarmasPorEstado($id_estado){
        $query = $this->_query->select("*")
                              ->from($this->_tabla . " a")
                              ->whereAND("a.est_ia_id", $id_estado, "=");
        
        $this->_addQueryComunas($query);
        
        return $query;
    }
    
    /**
     * Consulta para alarmas en revision entre rango de fechas
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     * @return QueryBuilder
     */
    protected function _queryAlarmasEnRevisionEntreFechas($fecha_desde, $fecha_hasta){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->whereAND("a.ala_d_fecha_emergencia", $fecha_desde->format("Y-m-d H:i:s"), ">=")
                               ->whereAND("a.ala_d_fecha_emergencia", $fecha_hasta->format("Y-m-d H:i:s"), "<=")
                               ->whereAND("a.est_ia_id", Alarma_Model::REVISION, "=");
        
        $this->_addQueryComunas($query);
        
        return $query;
    }
    
    /**
     * 
     * @param int $id_region
     * @return QueryBuilder
     */
    protected function _queryAlarmasPorRegion($id_region){
        $query = $this->_query->select("DISTINCT a.ala_ia_id, a.ala_c_nombre_emergencia, a.ala_c_utm_lat, a.ala_c_utm_lng")
                            ->from("alertas a")
                            ->join("alertas_vs_comunas ac", "ac.ala_ia_id = a.ala_ia_id", "INNER")
                            ->join("comunas c", "c.com_ia_id = ac.com_ia_id", "INNER")
                            ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                            ->whereAND("a.est_ia_id", Alarma_Estado_Model::ACTIVADO, "<>")
                            ->whereAND("p.reg_ia_id", $id_region);
        
        $lista_comunas = $this->usuario_comunas->listaIdComunas($this->_session->userdata("session_idUsuario"));

        if(count($lista_comunas)>0){
            $query->whereAND("ac.com_ia_id", $lista_comunas, "IN");
        }
        
        return $query;
    }
    
    /**
     * Filtra por las comunas del usuario
     * @param QueryBuilder $query
     */
    protected function _addQueryComunas(&$query){
        
        $lista_comunas = $this->usuario_comunas->listaIdComunas($this->_session->userdata("session_idUsuario"));

        if(count($lista_comunas)>0){
            $con_coma = implode(",",$lista_comunas);
            $query->addWhere("a.ala_ia_id IN (SELECT ac.ala_ia_id FROM alertas_vs_comunas ac WHERE ac.com_ia_id IN(".$con_coma.") )");
        } else {
            $query->addWhere("1=0");
        }
        
    }
}
