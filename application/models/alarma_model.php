<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Alarma_Model extends CI_Model
{
    
    private $activado = 1;
    private $rechazado = 2;
    private $revision = 3;
    
    public function obtenerEstados() {
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
            "anio" => "year(a.ala_d_fecha_emergencia)"
        );
        
        $where = "1=1";
        $queryParams = array();
        
        foreach($params as $llave => $valor) {
            $queryParams[] = $valor;
            $where .= " and " . $mapeo[$llave] . " = ?";
        }
        
        $sql = "
            select
                a.*,
                te.aux_c_nombre as ala_c_tipo_emergencia
            from
              alertas a
              inner join auxiliar_emergencias_tipo te on a.tip_ia_id = te.aux_ia_id
              where
                $where
            order by a.ala_d_fecha_emergencia desc
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
            order by a.ala_d_fecha_emergencia desc
        ";

        $query = $this->db->query($sql);

        $resultados = array();

        if ($query->num_rows() > 0)
            $resultados = $query->result_array();

        return $resultados;
    }
    
    public function guardarAlarma($params) {
       
        //var_dump($params);die;
        $this->load->helper('utils');
        
        $res = array();
        $this->db->query("
        INSERT INTO alertas (ala_c_nombre_informante, 
        ala_c_telefono_informante,
        ala_c_nombre_emergencia,
        tip_ia_id,
        ala_c_lugar_emergencia,
        ala_d_fecha_emergencia,
        rol_ia_id,
        ala_d_fecha_recepcion,
        usu_ia_id,
        est_ia_id,
        ala_c_observacion)
        VALUES
        (
           '".$params['iNombreInformante']."',
           '".$params['iTelefonoInformante']."',
           '".$params['iNombreEmergencia']."',
           '".$params['iTiposEmergencias']."',
           '".$params['iLugarEmergencia']."',
           '".spanishDateToISO($params['fechaEmergencia'])."',
           '".$this->session->userdata('session_idCargo')."',
           '".spanishDateToISO($params['fechaRecepcion'])."',
           '".$this->session->userdata('session_idUsuario')."',
           $this->revision,
           '".$params['iObservacion']."'   
        )
        ");
        
        $ala_ia_id = $this->db->insert_id();
        if($ala_ia_id && isset($params['iComunas']))
        {
            foreach ($params['iComunas'] as $k => $v){
                
                
                $this->db->query("
                INSERT INTO alertas_vs_comunas (ala_ia_id, com_ia_id)
                VALUES ($ala_ia_id,
                $v
                )
                ");   
            }
            $comunas_query = $this->db->query("
            SELECT GROUP_CONCAT(com_c_nombre) comunas from comunas c join alertas_vs_comunas avc
            on avc.com_ia_id = c.com_ia_id
            where avc.ala_ia_id = $ala_ia_id"); 
            $tipo_query = $this->db->query("select aux_c_nombre nombre from auxiliar_emergencias_tipo where aux_ia_id = '".$params['iTiposEmergencias']."'");
            
            $tipo_emergencia = $tipo_query->result_array();
            $comunas = $comunas_query->result_array();
            
            $params['lista_comunas'] = $comunas[0]['comunas'];
            $params['tipo_emergencia'] = $tipo_emergencia[0]['nombre'];
            $params['ala_ia_id'] = $ala_ia_id;
            
            
            
            
            
            $res['res_mail'] = ($this->enviaMsjAlarma($params))? 'enviado correctamente': 'error al enviar';
            
        }
         $res['ala_ia_id']= $ala_ia_id;
         
         return json_encode($res);
    }
    
    
    public function enviaMsjAlarma($params){
        
        $this->load->helper('utils');
        $this->load->model("usuario_model", "UsuarioModel");
        $key_id = $this->UsuarioModel->generaKeyId($this->session->userdata('session_idUsuario'));
        $mensaje = "<b>SIPRESA: Revisión de Alarma</b><br><br>";
	$mensaje .= $this->session->userdata('session_nombres').$this->session->userdata('session_idCargo')." ha registrado la alarma código : ".$params['ala_ia_id']."<br><br>";
	$mensaje .= "<b>Nombre de la emergencia:</b> ".$params['iNombreEmergencia']."<br>";
	$mensaje .= "<b>Tipo de emergencia:</b> ".$params['tipo_emergencia']."<br>"; 
	$mensaje .= "<b>Lugar o dirección de la emergencia:</b> ".$params['iLugarEmergencia']."<br>"; 
	$mensaje .= "<b>Comuna(s):</b> ".$params['lista_comunas']."<br>"; 
	$mensaje .= "<b>Fecha de la emergencia:</b> ".spanishDateToISO($params['fechaEmergencia'])."<br>"; 
	$mensaje .= "<b>Fecha recepción de la emergencia:</b> ".spanishDateToISO($params['fechaRecepcion'])."<br>"; 
	$mensaje .= "<b>Nombre del informante:</b> ".$params['iNombreInformante']."<br>";
	$mensaje .= "<b>Teléfono del informante:</b> ".$params['iTelefonoInformante']."<br><br>";
	$mensaje .= "<a href='".  site_url('emergencia/generaEmergencia/id/'.$params['ala_ia_id'].'/k/'.$key_id)."'>URL de la alarma a revisar</a><br>";
	$mensaje .= "<br><img src='".  base_url('assets/img/logoseremi.png')  ."' alt='Seremi' title='Seremi'></img><br>";
	
	$to = 'rukmini.tonacca@redsalud.gov.cl';
	//$to = 'vladimir@cosof.cl';
	$subject = "SIPRESA: Revisión de Alarma";
	

        $this->load->model("Sendmail_Model", "SendmailModel");
	
        return $this->SendmailModel->emailSend($to,null,null, $subject, $mensaje);
	
        
    }
}