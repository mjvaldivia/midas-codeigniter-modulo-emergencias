<?php 

if (!defined("BASEPATH")) exit("No direct script access allowed");


class Soportes extends CI_Controller {


    function __construct(){
        parent::__construct();
        $this->load->helper(array("session","utils"));

        sessionValidation();
        $this->load->library('template');

        $this->load->model("soportes_model", "SoportesModel");
        $this->load->model("soportes_mensajes_model", "SoportesMensajesModel");

    }
    
    public function bandeja_usuario(){
        
        $id_usuario = $this->session->userdata['session_idUsuario'];
        $soportes = $this->SoportesModel->obtSoportesUsuario($id_usuario);

        $data = array(
            'soportes' => $soportes
            );
        $this->template->parse("default", "pages/soportes/bandeja_usuario", $data);
    } 


    public function nuevoSoporte(){
        $this->load->view("pages/soportes/nuevo_soporte.php");
    }

    public function enviarSoporte(){
        $data = array();
        parse_str($_POST['data'],$data);

        $region = $this->session->userdata['session_region_codigo'];

        $codigo = $this->SoportesModel->obtUltimoCorrelativoRegion($region);

        $usuario = $this->session->userdata['session_idUsuario'];
        $estado = 1; /* ingresada */
        $asunto = $data['asunto_soporte'];
        $texto = nl2br($data['texto_soporte']);
        $email = 0;
        if(isset($data['email_soporte']) and $data['email_soporte'] == 1){
            $email = 1;
        }
        $fecha = date('Y-m-d H:i:s');
        $datos = array(
            'soporte_usuario_fk' => $usuario,
            'soporte_region' => $region,
            'soporte_codigo' => $codigo,
            'soporte_fecha_ingreso' => $fecha,
            'soporte_asunto' => $asunto,
            'soporte_estado' => $estado,
            'soporte_email' => $email
            );

        $soporte = $this->SoportesModel->insNuevoSoporte($datos);
        $json = array();
        if($soporte){
            $datos = array(
                'soportemensaje_soporte_fk' => $soporte,
                'soportemensaje_fecha' => $fecha,
                'soportemensaje_texto' => $texto,
                'soportemensaje_usuario_fk' => $usuario,
                'soportemensaje_tipo' => 1,
                'soportemensaje_visto_usuario' => 1,
                'soportemensaje_visto_soporte' => 0
            );

            $soporte_mensaje = $this->SoportesMensajesModel->insNuevoMensajeSoporte($datos);
            if($soporte_mensaje){
                $json['estado'] = true;
                $json['mensaje'] = "Soporte enviado correctamente";    
            }else{
                $delete = $this->SoportesModel->delSoporte($soporte);
                $json['estado'] = false;
                $json['mensaje'] = "Hubo un problema al enviar el soporte. Intente nuevamente";
            }
            
        }else{
            $json['estado'] = false;
            $json['mensaje'] = "Hubo un problema al enviar el soporte. Intente nuevamente";
        }

        echo json_encode($json);
    }   



    public function cargarGrillaSoportes(){
        $grilla = $_POST['grilla'];

        if($grilla == "usuario"){
            $soportes = $this->SoportesModel->obtSoportesUsuario($id_usuario);
            $html = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $html .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.mb_strtoupper($item->nombre_usuario).'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $html .= '</tbody>    
                    </table>';

        }

        echo $html;
    }


    public function verSoporte() {
        $params = $this->uri->uri_to_assoc();
        $id_soporte = $params['id'];

        $soporte = $this->SoportesModel->obtSoporteId($id_soporte);
        $soporte_mensaje = $this->SoportesMensajesModel->obtMensajePrincipalSoporte($id_soporte);
        $mensajes = $this->SoportesMensajesModel->obtMensajeSoporte($id_soporte);

        $cerrarTicket = ($this->session->userdata['session_idUsuario'] != $soporte[0]->soporte_usuario_fk);
        
        $data = array(
            'soporte'=>$soporte[0],
            'soporte_mensaje' => $soporte_mensaje[0],
            'mensajes' => $mensajes,
            'cerrar_ticket' => $cerrarTicket
            );
        $this->load->view("pages/soportes/ver_soporte.php",$data);
    }


    public function nuevoMensaje() {
        $params = $this->uri->uri_to_assoc();
        $id_soporte = $params['id'];

        $soporte = $this->SoportesModel->obtSoporteId($id_soporte);
        $data = array(
            'soporte'=>$soporte[0]
            );
        $this->load->view("pages/soportes/nuevo_mensaje.php",$data);
    }


    public function enviarMensaje() {

        $data = array();
        parse_str($_POST['data'],$data);
        $fecha = date('Y-m-d H:i:s');
        $usuario = $this->session->userdata['session_idUsuario'];
        if($usuario == $data['usuario_soporte']){
            $visto_usuario = 1;
            $visto_soporte = 0;
        }else{
            $visto_usuario = 0;
            $visto_soporte = 1;
        }
        $datos = array(
            'soportemensaje_soporte_fk' => $data['id_soporte'],
            'soportemensaje_fecha' => $fecha,
            'soportemensaje_texto' => nl2br($data['texto_mensaje']),
            'soportemensaje_usuario_fk' => $usuario,
            'soportemensaje_tipo' => 2,
            'soportemensaje_visto_usuario' => $visto_usuario,
            'soportemensaje_visto_soporte' => $visto_soporte
        );

        $soporte_mensaje = $this->SoportesMensajesModel->insNuevoMensajeSoporte($datos);
        if($soporte_mensaje){
            $json['estado'] = true;
            $json['mensaje'] = "Mensaje enviado correctamente";    
        }else{
            $delete = $this->SoportesModel->delSoporte($soporte);
            $json['estado'] = false;
            $json['mensaje'] = "Hubo un problema al enviar el mensaje. Intente nuevamente";
        }

        echo json_encode($json);
    }


}