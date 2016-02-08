<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emergencia_Model extends MY_Model {

    public $activado = 1;
    public $rechazado = 2;
    public $revision = 3;

    public $nivel_I = 1;
    public $nivel_II = 2;
    public $nivel_III = 3;
    public $nivel_IV = 4;

    public $en_alerta = 1;
    public $emergencia_activa = 2;
    public $emergencia_finalizada = 3;

        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias";
    
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
        return $this->_query->getById("eme_ia_id", $id);
    }
    
    /**
     * Actualiza 
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "eme_ia_id", $id);
    }
    
    /**
     * 
     * @param type $id_region
     * @param DateTime $fecha_inicio
     * @param DateTime $fecha_termino
     */
    public function listarPorRegionYFecha($id_region, $fecha_inicio = NULL, $fecha_termino = NULL){
        $query = $this->_queryEmergenciasPorRegion($id_region);
        
        if($fecha_inicio instanceof DateTime){
            $query->whereAND("eme_d_fecha_emergencia", $fecha_inicio->format("Y-m-d H:i:s"), ">=");
        }
        
        if($fecha_termino instanceof DateTime){
            $query->whereAND("eme_d_fecha_emergencia", $fecha_termino->format("Y-m-d H:i:s"), "<=");
        }
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista emergencias por la region
     * @param int $id_region
     * @return array
     */
    public function listarPorRegion($id_region){
        $result = $this->_queryEmergenciasPorRegion($id_region)
                       ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
        
    /**
     * Lista todas las emergencias
     * @return array
     */
    public function listar(){
        $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("eme_d_fecha_recepcion", "DESC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista emergencias por estado
     * @param int $id_estado
     * @return array
     */
    public function listarEmergenciasPorEstado($id_estado){
        $result = $this->_queryEmergenciasPorEstado($id_estado)
                       ->orderBy("eme_d_fecha_recepcion", "DESC")
                       ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_estado id del estado
     * @return int
     */
    public function cantidadEmergenciasPorEstado($id_estado){
        $result = $this->_queryEmergenciasPorEstado($id_estado)
                       ->select("COUNT(*) as cantidad", false)
                       ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        }else{
            return 0;
        }
    }
    
    /**
     * Lista años con emergencias efectuadas
     * @return array
     */
    public function listarYearsConEmergencias(){
        $query = $this->_query->select("YEAR(e.eme_d_fecha_emergencia) as ano")
                               ->from($this->_tabla . " e")
                               ->groupBy("YEAR(e.eme_d_fecha_emergencia)");
        
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
     * @param int $mes
     * @return int
     */
    public function cantidadEmergenciasMes($mes, $ano){
        $result = $this->_query->select("COUNT(*) as cantidad")
                               ->from()
                               ->whereAND("MONTH(eme_d_fecha_emergencia)", $mes, "=")
                               ->whereAND("YEAR(eme_d_fecha_emergencia)", $ano, "=")
                               ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        } else {
            return 0;
        }
    }
    
    /**
     * 
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     * @return array
     */
    public function listarEmergenciasEntreFechas($fecha_desde, $fecha_hasta){
        $query = $this->_query->select("e.*")
                               ->from($this->_tabla . " e")
                               ->whereAND("e.eme_d_fecha_emergencia", $fecha_desde->format("Y-m-d H:i:s"), ">=")
                               ->whereAND("e.eme_d_fecha_emergencia", $fecha_hasta->format("Y-m-d H:i:s"), "<=")
                               ->orderBy("e.eme_d_fecha_recepcion", "DESC");
        
        $this->_addQueryComunas($query);
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
     /**
     * Retorna cantidad de emergencias entre fechas dadas
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     * @return int
     */
    public function cantidadEmergencias($fecha_desde, $fecha_hasta){
        $result = $this->_query->select("COUNT(*) as cantidad")
                               ->from()
                               ->whereAND("eme_d_fecha_emergencia", $fecha_desde->format("Y-m-d H:i:s"), ">=")
                               ->whereAND("eme_d_fecha_emergencia", $fecha_hasta->format("Y-m-d H:i:s"), "<=")
                               ->getOneResult();
        if(!is_null($result)){
            return $result->cantidad;
        } else {
            return 0;
        }
    }
    

    public function guardarEmergencia($params) {

        $this->load->helper('utils');
        $res = array();
        $query = $this->db->query("
        INSERT INTO emergencias (
        eme_c_nombre_informante, 
        eme_c_telefono_informante,
        eme_c_nombre_emergencia,
        tip_ia_id,
        eme_c_lugar_emergencia,
        eme_d_fecha_emergencia,
        rol_ia_id,
        eme_d_fecha_recepcion,
        usu_ia_id,
        ala_ia_id,
        eme_c_observacion
        )
        VALUES
        (
           '" . $params['iNombreInformante'] . "',
           '" . $params['iTelefonoInformante'] . "',
           '" . $params['iNombreEmergencia'] . "',
           '" . $params['iTiposEmergencias'] . "',
           '" . $params['iLugarEmergencia'] . "',
           '" . spanishDateToISO($params['fechaEmergencia']) . "',
           '" . $this->session->userdata('session_idCargo') . "',
           '" . spanishDateToISO($params['fechaRecepcion']) . "',
           '" . $this->session->userdata('session_idUsuario') . "',
           '" . $params['ala_ia_id'] . "',
           '" . $params['iObservacion'] . "'
        )
        ");

        $eme_ia_id = $this->db->insert_id();
        if ($eme_ia_id && isset($params['iComunas'])) {
            foreach ($params['iComunas'] as $k => $v) {


                $this->db->query("
                INSERT INTO emergencias_vs_comunas (eme_ia_id, com_ia_id)
                VALUES ($eme_ia_id,
                $v
                )
                ");
            }
            $comunas_query = $this->db->query("
            SELECT GROUP_CONCAT(c.com_c_nombre) comunas, GROUP_CONCAT(c.com_ia_id) id_comunas from comunas c join emergencias_vs_comunas evc
            on evc.com_ia_id = c.com_ia_id
            where evc.eme_ia_id = $eme_ia_id");
            $comunas = $comunas_query->result_array();
            $tipo_query = $this->db->query("select aux_c_nombre nombre from auxiliar_emergencias_tipo where aux_ia_id = '" . $params['iTiposEmergencias'] . "'");
            $tipo_emergencia = $tipo_query->result_array();
            $params['lista_comunas'] = $comunas[0]['comunas'];
            $params['lista_id_comunas'] = $comunas[0]['id_comunas'];
            $params['tipo_emergencia'] = $tipo_emergencia[0]['nombre'];
        }   
        if ($query) {
            $this->db->query("
                UPDATE alertas SET est_ia_id = $this->activado WHERE ala_ia_id = '" . $params['ala_ia_id'] . "'");
            $params['eme_ia_id'] = $eme_ia_id;
            $res['res_mail'] = ($this->enviaMsjEmergencia($params)) ? true : false;
        }
        $res['eme_ia_id'] = $eme_ia_id;

        return ($res);
    }

    public function getAlarma($params) {
        $sql = "
            select
                a.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                GROUP_CONCAT(avc.com_ia_id) comunas
            from
              alertas a join usuarios u on a.usu_ia_id = u.usu_ia_id
              join alertas_vs_comunas avc on a.ala_ia_id = avc.ala_ia_id
            where a.ala_ia_id = " . $params['id'];

        $query = $this->db->query($sql);

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['ala_d_fecha_emergencia'] = ISODateTospanish($resultados['ala_d_fecha_emergencia']);
            $resultados['ala_d_fecha_recepcion'] = ISODateTospanish($resultados['ala_d_fecha_recepcion']);
        }

        echo json_encode($resultados);
    }

    function revisaEstado($params) {

        $sql = "
            select
                a.est_ia_id
            from
              alertas a 
            where a.ala_ia_id = " . $params['id'];

        $query = $this->db->query($sql);
        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0]['est_ia_id'];
        }
        return $resultados;
    }
    
    /**
     * 
     * @param array $params filtros array("tipoEmergencia", "anio", "estado_emergencia)
     * @return array
     * --
     * Vladimir: se agrega lista de comunas 
     */
    public function filtrarEmergencias($params) {
        $query = $this->_query->select("e.*, (select GROUP_CONCAT(c.com_c_nombre SEPARATOR ', ') from comunas c
                                       join    emergencias_vs_comunas evc on c.com_ia_id = evc.com_ia_id
                                       where evc.eme_ia_id = e.eme_ia_id
                                     ) comunas, te.aux_c_nombre as eme_c_tipo_emergencia")
                              ->from($this->_tabla . " e")
                              ->join("auxiliar_emergencias_tipo te", "e.tip_ia_id = te.aux_ia_id", "INNER");
        
        if(!empty($params["tipoEmergencia"])){
            $query->whereAND("e.tip_ia_id", $params["tipoEmergencia"]);
        }
        
        if(!empty($params["anio"])){
            $query->whereAND("year(e.eme_d_fecha_recepcion)", $params["anio"]);
        }
        
        if(!empty($params["estado_emergencia"])){
            $query->whereAND("e.est_ia_id", $params["estado_emergencia"]);
        }
        
        $this->_addQueryComunas($query);
                                
        $resultado = $query->getAllResult();
        fb($resultado);
        if(!is_null($resultado)){
            return $resultado;
        } else {
            return array();
        }
    }

    public function getEmergencia($id) {
        $this->load->helper('utils');
        $sql = "
            select
                e.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                te.aux_c_nombre as tipo_emergencia,
                GROUP_CONCAT(evc.com_ia_id) comunas
            from
              emergencias e
              inner join usuarios u on e.usu_ia_id = u.usu_ia_id
              inner join auxiliar_emergencias_tipo te on e.tip_ia_id = te.aux_ia_id
              join emergencias_vs_comunas evc on e.eme_ia_id = evc.eme_ia_id
              join comunas c on c.com_ia_id = evc.com_ia_id
            where e.eme_ia_id = ?";

        $query = $this->db->query($sql, $id);

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['eme_d_fecha_emergencia'] = ISODateTospanish($resultados['eme_d_fecha_emergencia']);
            $resultados['eme_d_fecha_recepcion'] = ISODateTospanish($resultados['eme_d_fecha_recepcion']);
        }

        return $resultados;
    }

    public function getJsonEmergencia($params, $json = true) {


        $this->load->helper("utils");
        $sql = "
            select
                e.*,UCASE(LOWER(CONCAT(usu_c_nombre,' ',usu_c_apellido_paterno,' ',usu_c_apellido_materno))) usuario,
                GROUP_CONCAT(evc.com_ia_id) comunas,
                GROUP_CONCAT(c.com_c_nombre) nombre_comunas,
                te.aux_c_nombre as tipo_emergencia
            from
              emergencias e join usuarios u on e.usu_ia_id = u.usu_ia_id
              inner join auxiliar_emergencias_tipo te on e.tip_ia_id = te.aux_ia_id
              join emergencias_vs_comunas evc on e.eme_ia_id = evc.eme_ia_id
              join comunas c on c.com_ia_id = evc.com_ia_id
            where e.eme_ia_id = ?";

        $query = $this->db->query($sql, array($params['id']));

        $resultados = null;
        if ($query->num_rows() > 0) {
            $resultados = $query->result_array();

            $resultados = $resultados[0];

            $resultados['hora_emergencia'] = ISOTimeTospanish($resultados['eme_d_fecha_emergencia']);
            $resultados['hora_recepcion'] = ISOTimeTospanish($resultados['eme_d_fecha_recepcion']);

            $resultados['eme_d_fecha_emergencia'] = ISODateTospanish($resultados['eme_d_fecha_emergencia'], false);
            $resultados['eme_d_fecha_recepcion'] = ISODateTospanish($resultados['eme_d_fecha_recepcion']);
        }

        if ($json)
            echo json_encode($resultados);
        else
            return $resultados;
    }

    public function editarEmergencia($params) {

        $this->load->helper('utils');

        $query = $this->db->query("
        UPDATE emergencias SET 
        eme_c_nombre_informante = '" . $params['iNombreInformante'] . "',
        eme_c_telefono_informante ='" . $params['iTelefonoInformante'] . "',
        eme_c_nombre_emergencia = '" . $params['iNombreEmergencia'] . "',
        tip_ia_id = '" . $params['iTiposEmergencias'] . "',
        eme_c_lugar_emergencia = '" . $params['iLugarEmergencia'] . "',
        eme_d_fecha_emergencia = '" . spanishDateToISO($params['fechaEmergencia']) . "',
        eme_d_fecha_recepcion = '" . spanishDateToISO($params['fechaRecepcion']) . "',
        eme_c_recursos = '" . $params['eme_c_recursos'] . "',
        eme_c_heridos = '" . $params['eme_c_heridos'] . "',
        eme_c_fallecidos = '" . $params['eme_c_fallecidos'] . "',
        eme_c_riesgo = '" . $params['eme_c_riesgo'] . "',
        eme_c_capacidad = '" . $params['eme_c_capacidad'] . "',
        eme_c_descripcion = '" . $params['eme_c_descripcion'] . "',
        eme_c_acciones = '" . $params['eme_c_acciones'] . "',
        eme_c_informacion_adicional = '" . $params['eme_c_informacion_adicional'] . "',
        eme_c_observacion = '" . $params['iObservacion'] . "'
        WHERE eme_ia_id =  '" . $params['eme_ia_id'] . "'");

        if ($query) {

            $this->db->query("DELETE from emergencias_vs_comunas WHERE eme_ia_id = '" . $params['eme_ia_id'] . "'");
        }
        if ($query && isset($params['iComunas'])) {
            foreach ($params['iComunas'] as $k => $v) {
                $this->db->query("
                INSERT INTO emergencias_vs_comunas (eme_ia_id, com_ia_id)
                VALUES ('" . $params['eme_ia_id'] . "',
                $v
                )
                ");
            }
        }
        return $query;
    }

    public function rechazaEmergencia($params) {


        $query = $this->db->query("
        UPDATE alertas SET  est_ia_id = " . $this->rechazado . " WHERE ala_ia_id = " . $params['ala_ia_id'] . "");
        return $query;
    }

    public function enviaMsjEmergencia($params) {

        $this->load->helper('utils');
        $mensaje = "<b>Confirmación de una situación de emergencia</b><br><br>";
        $mensaje .= "Se ha activado la emergencia código " . $params['eme_ia_id'] . "<br><br>";
        $mensaje .= "<b>Nombre de la emergencia:</b> " . $params['iNombreEmergencia'] . "<br>";
        $mensaje .= "<b>Tipo de emergencia:</b> " . $params['iTiposEmergencias'] . "<br>";
        $mensaje .= "<b>Lugar o dirección de la emergencia:</b> " . $params['iLugarEmergencia'] . "<br>";
        $mensaje .= "<b>Comuna(s):</b> " . $params['lista_comunas'] . "<br>";
        $mensaje .= "<b>Fecha de la emergencia:</b> " . spanishDateToISO($params['fechaEmergencia']) . "<br>";
        $mensaje .= "<b>Fecha recepción de la emergencia:</b> " . spanishDateToISO($params['fechaRecepcion']) . "<br>";
        $mensaje .= "<b>Nombre del informante:</b> " . $params['iNombreInformante'] . "<br>";
        $mensaje .= "<b>Teléfono del informante:</b> " . $params['iTelefonoInformante'] . "<br><br>";
        $mensaje .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'/><br>";

        //$to = 'rukmini.tonacca@redsalud.gov.cl';
        //$to = 'vladimir@cosof.cl';
        $subject = "Confirmación de una situación de emergencia";
        $this->load->model("Sendmail_Model", "SendmailModel");
        $to = $this->SendmailModel->get_destinatariosCorreo($params['iTiposEmergencias'], $params['lista_id_comunas'], null);



        return $this->SendmailModel->emailSend($to, null, null, $subject, $mensaje, false);
    }

    public function obtenerCapas($params) { //capas que estan cargadas en el visor
        $id = $params['id'];
        $qry = "select eme_c_capas from emergencias where eme_ia_id = $id";

        $result = $this->db->query($qry);

        $row = $result->result_array();
        return $row[0]['eme_c_capas'];
    }

    public function get_JsonReferencia($id) {
        $this->load->helper("url");
        $result = $this->db->query(" SELECT ala_c_utm_lat ref_lat, ala_c_utm_lng ref_lng, ala_c_geozone geozone  from alertas a join emergencias e on e.ala_ia_id = a.ala_ia_id where e.eme_ia_id= $id");
        $row = $result->result_array();
        $res = array(
            'ref_lat' => $row[0]['ref_lat'],
            'ref_lng' => $row[0]['ref_lng'],
            'geozone' => $row[0]['geozone']
        );

        return json_encode($res);
    }

    public function eliminar_Emergencia($id = 0) {

        $error = false;
        $this->db->trans_begin();
        $ala_ia_id = 0;
        $this->db->query("delete from emergencias_vs_comunas where eme_ia_id=$id");
        $this->db->query("delete from archivo_vs_emevisor where eme_ia_id=$id");

        $qry = "select ala_ia_id from emergencias where eme_ia_id = $id";

        $result = $this->db->query($qry);
        if ($row = $result->result_array()) {
            $ala_ia_id = $row[0]['ala_ia_id'];
        }

        $this->db->query("delete from emergencias where eme_ia_id=$id");

        if ($this->db->trans_status() === FALSE) {
            $error = true;
            $this->db->trans_rollback();
        } else {

            $this->db->trans_commit();
            $this->load->model("Archivo_Model", "ArchivoModel");
            $path = $this->ArchivoModel->ALARMA_FOLDER . $ala_ia_id;
            $this->ArchivoModel->delete($path);
            $path = $this->ArchivoModel->EMERGENCIA_FOLDER . $id;
            $this->ArchivoModel->delete($path);
        }

        return $error;
    }
    
    /**
     * Consulta para emergencia por estado
     * @param int $id_estado
     * @return QueryBuilder
     */
    protected function _queryEmergenciasPorEstado($id_estado){
        $query = $this->_query->select("*")
                              ->from($this->_tabla . " e")
                              ->whereAND("e.est_ia_id", $id_estado, "=");
        
        $this->_addQueryComunas($query);
        
        return $query;
    }
    
    /**
     * 
     * @param int $id_region
     * @return QueryBuilder
     */
    protected function _queryEmergenciasPorRegion($id_region){
        $query = $this->_query->select("DISTINCT e.eme_ia_id, e.eme_c_nombre_emergencia, a.ala_c_utm_lat, a.ala_c_utm_lng")
                            ->from("emergencias e")
                            ->join("alertas a", "a.ala_ia_id = e.ala_ia_id")
                            ->join("emergencias_vs_comunas ec", "ec.eme_ia_id = e.eme_ia_id", "INNER")
                            ->join("comunas c", "c.com_ia_id = ec.com_ia_id", "INNER")
                            ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                            ->whereAND("p.reg_ia_id", $id_region);
        
        $lista_comunas = $this->usuario_comunas->listaIdComunas($this->_session->userdata("session_idUsuario"));

        if(count($lista_comunas )>0){
            $query->whereAND("ec.com_ia_id", $lista_comunas , "IN");
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
            $query->addWhere("e.eme_ia_id IN (SELECT ec.eme_ia_id FROM emergencias_vs_comunas ec WHERE ec.com_ia_id IN(".$con_coma.") )");
        } else {
            $query->addWhere("1=0");
        }
    }



    public function getByAlarma($id_alarma){
        return $this->_query->getById("ala_ia_id", $id_alarma);
    }



    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function buscar(array $parametros = array()){
        $query = $this->_query->select("e.*")
            ->from($this->_tabla . " e");

        if(!empty($parametros["id_estado"])){
            $query->whereAND("e.est_ia_id", $parametros["id_estado"], "=");
        }

        if(!empty($parametros["id_tipo"])){
            $query->whereAND("e.tip_ia_id", $parametros["id_tipo"], "=");
        }

        if(!empty($parametros["year"])){
            $query->whereAND("year(e.eme_d_fecha_recepcion)", $parametros["year"], "=");
        }

        $this->_addQueryComunas($query);

        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }

}
