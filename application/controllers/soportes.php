<?php 
session_start();
if (!defined("BASEPATH")) exit("No direct script access allowed");


class Soportes extends MY_Controller {

    const NUEVO_TICKET = 'Ticket creado';
    const NUEVO_MENSAJE = 'Nuevo mensaje en ticket';
    const TICKET_DERIVADO = 'Ticket es derivado a Mesa Central';
    const TICKET_CERRADO = 'Ticket es cerrado';

    function __construct(){
        parent::__construct();
        $this->load->helper(array("session","utils"));

        sessionValidation();
        $this->load->library('template');

        $this->load->model("soportes_model", "SoportesModel");
        $this->load->model("soportes_mensajes_model", "SoportesMensajesModel");
        $this->load->model("soportes_adjuntos_model", "SoportesAdjuntosModel");
        $this->load->model("soportes_historial_model", "SoportesHistorialModel");

    }
    
    public function bandeja_usuario(){
        
        $id_usuario = $this->session->userdata['session_idUsuario'];
        $soportes = $this->SoportesModel->obtSoportesUsuario($id_usuario);

        $soportes_ingresados = array();
        $soportes_cerrados = array();

        foreach($soportes as $item){
            if($item->soporte_estado == 3){
                $soportes_cerrados[] = $item;
            }else{
                $soportes_ingresados[] = $item;
            }
        }
        $data = array(
            'soportes_ingresados' => $soportes_ingresados,
            'soportes_cerrados' => $soportes_cerrados
            );
        $this->template->parse("default", "pages/soportes/bandeja_usuario", $data);
    } 


    public function nuevoSoporte(){
        if(isset($_SESSION['adjuntos_soporte'])){
            unset($_SESSION['adjuntos_soporte']);
        }
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
                /** guardar adjuntos de mensaje en caso de tener */
                $json['mensaje'] = "Ticket enviado correctamente"; 
                if(isset($_SESSION['adjuntos_soporte']) and count($_SESSION['adjuntos_soporte']) > 0){
                    $dir = 'media/soportes/'.$soporte;
                    if(!is_dir($dir)){
                        mkdir($dir,0777,true);
                    }
                    $adjuntos = $_SESSION['adjuntos_soporte'];
                    $totalAdjuntos = count($adjuntos);
                    $i = 0;
                    foreach($adjuntos as $adjunto){
                        $file = $dir . '/' .$adjunto['name'];
                        $fp = fopen($file,'w+b');
                        $guardado = fwrite($fp,$adjunto['contenido']);
                        fclose($fp);
                        
                        if($guardado !== false){
                            $data = array(
                                    'soporteadjunto_mensaje_fk'=>$soporte_mensaje,
                                    'soporteadjunto_nombre'=>$adjunto['name'],
                                    'soporteadjunto_ruta'=>$dir,
                                    'soporteadjunto_mime'=>$adjunto['mime'],
                                    'soporteadjunto_sha'=>$adjunto['sha']
                                );
                            $id_adjunto = $this->SoportesAdjuntosModel->insNuevoAdjuntoSoporte($data);
                            if($id_adjunto){
                                $i++;
                            }else{
                                @unlink($file);
                            }
                        }
                        
                        
                    }

                    if($i != $totalAdjuntos){
                        $json['mensaje'] = "Ticket enviado, pero algunos adjuntos no pudieron enviarse " .$i." ".$totalAdjuntos ;
                    }
                }

                $dataLog = array(
                    'soportehistorial_soporte_fk' => $soporte,
                    'soportehistorial_usuario_fk' => $usuario,
                    'soportehistorial_fecha' => $fecha,
                    'soportehistorial_evento' => $this::NUEVO_TICKET
                    );
                $insertLog = $this->SoportesHistorialModel->insNuevoHistorialSoporte($dataLog);
                $json['estado'] = true;
                   
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
            $id_usuario = $this->session->userdata['session_idUsuario'];
            $soportes = $this->SoportesModel->obtSoportesUsuario($id_usuario);

            $soportes_ingresados = array();
            $soportes_cerrados = array();

            foreach($soportes as $item){
                if($item->soporte_estado == 3){
                    $soportes_cerrados[] = $item;
                }else{
                    $soportes_ingresados[] = $item;
                }
            }
            
            /* soportes ingresados y en desarrollo */
            $ingresados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes_ingresados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $ingresados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $ingresados .= '</tbody>    
                    </table>';

            /* soportes cerrados */
            $cerrados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes_cerrados">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th>Fecha Cierre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes_cerrados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $cerrados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">'.$item->soporte_fecha_cierre.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $cerrados .= '</tbody>    
                    </table>';

            $json = array(
                'ingresados' => $ingresados,
                'cerrados' => $cerrados
                );

        }elseif($grilla == "soporte"){
            $region = $this->session->userdata['session_region_codigo'];
            $soportes = $this->SoportesModel->obtSoportes($region);

            $soportes_ingresados = array();
            $soportes_cerrados = array();

            foreach($soportes as $item){
                if($item->soporte_estado == 3){
                    $soportes_cerrados[] = $item;
                }else{
                    $soportes_ingresados[] = $item;
                }
            }
            
            $ingresados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
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
            foreach($soportes_ingresados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $ingresados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.mb_strtoupper($item->nombre_usuario).'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $ingresados .= '</tbody>    
                    </table>';

            /* soportes cerrados */
            $cerrados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes_cerrados">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Estado</th>
                    <th>Fecha Cierre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes_cerrados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $cerrados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.mb_strtoupper($item->nombre_usuario).'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">'.$item->soporte_fecha_cierre.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $cerrados .= '</tbody>    
                    </table>';

            $json = array(
                'ingresados' => $ingresados,
                'cerrados' => $cerrados
                );

        }elseif($grilla == "central"){
            /*$region = $this->session->userdata['session_region_codigo'];*/
            $soportes = $this->SoportesModel->obtSoportesCentral();

            $soportes_ingresados = array();
            $soportes_cerrados = array();

            foreach($soportes as $item){
                if($item->soporte_estado == 3){
                    $soportes_cerrados[] = $item;
                }else{
                    $soportes_ingresados[] = $item;
                }
            }
            
            $ingresados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Región</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes_ingresados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $ingresados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.mb_strtoupper($item->nombre_usuario).'</td>
                    <td class="text-center">'.$item->nombre_region.'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $ingresados .= '</tbody>    
                    </table>';

            /* soportes cerrados */
            $cerrados = '<table class="table table-hover table-condensed table-bordered " id="tabla_soportes_cerrados">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Región</th>
                    <th>Estado</th>
                    <th>Fecha Cierre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($soportes_cerrados as $item):
                $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);
                $cerrados .='<tr>
                    <td class="text-center">'.$item->soporte_codigo.'</td>
                    <td class="text-center">'.$item->soporte_fecha_ingreso.'</td>
                    <td class="text-center">'.$item->soporte_asunto.'</td>
                    <td class="text-center">'.mb_strtoupper($item->nombre_usuario).'</td>
                    <td class="text-center">'.$item->nombre_region.'</td>
                    <td class="text-center">'.$item->estado.'</td>
                    <td class="text-center">'.$item->soporte_fecha_cierre.'</td>
                    <td class="text-center">
                        <a data-toggle="modal" class="btn btn-primary btn-square btn-xs modal-sipresa" href="'.$url.'" data-title="Información de la actividad" data-success="" data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>';
            endforeach;
            $cerrados .= '</tbody>    
                    </table>';

            $json = array(
                'ingresados' => $ingresados,
                'cerrados' => $cerrados
                );

        }

        echo json_encode($json);
    }


    public function verSoporte() {
        $params = $this->uri->uri_to_assoc();
        $id_soporte = $params['id'];

        $soporte = $this->SoportesModel->obtSoporteId($id_soporte);
        $soporte_mensaje = $this->SoportesMensajesModel->obtMensajePrincipalSoporte($id_soporte);

        $arr_adjuntos_principal = array();
        $adjuntos = $this->SoportesAdjuntosModel->obtAdjuntosMensaje($soporte_mensaje[0]->soportemensaje_id);
        if($adjuntos){
            foreach($adjuntos as $item){
                $arr_adjuntos_principal[] = array('nombre' => $item->soporteadjunto_nombre, 'sha' => $item->soporteadjunto_sha);
            }
        }


        $mensajes = $this->SoportesMensajesModel->obtMensajesSoporte($id_soporte);

        $arr_adjuntos_mensajes = array();
        if($mensajes){
            foreach($mensajes as $mensaje){
                $adjuntos = $this->SoportesAdjuntosModel->obtAdjuntosMensaje($mensaje->soportemensaje_id);
                if($adjuntos){
                    foreach($adjuntos as $item){
                        $arr_adjuntos_mensajes[$mensaje->soportemensaje_id][] = array('nombre' => $item->soporteadjunto_nombre, 'sha' => $item->soporteadjunto_sha);
                    }
                }
            }
        }
        




        $cerrarTicket = ($this->session->userdata['session_idUsuario'] != $soporte[0]->soporte_usuario_fk);
        $derivarTicket = (($this->session->userdata['session_idUsuario'] != $soporte[0]->soporte_usuario_fk) && $soporte[0]->soporte_derivado == 0);

        if($this->session->userdata['session_idUsuario'] == $soporte[0]->soporte_usuario_fk){
            $data = array('soportemensaje_visto_usuario' => 1);
            $updateMensajes = $this->SoportesMensajesModel->updSoporteMensaje($data,$id_soporte,'soportemensaje_soporte_fk');
        }else{
            $data = array('soportemensaje_visto_soporte' => 1);
            $updateMensajes = $this->SoportesMensajesModel->updSoporteMensaje($data,$id_soporte,'soportemensaje_soporte_fk');
        }
        
        $data = array(
            'soporte'=>$soporte[0],
            'soporte_mensaje' => $soporte_mensaje[0],
            'mensajes' => $mensajes,
            'cerrar_ticket' => $cerrarTicket,
            'derivar_ticket' => $derivarTicket,
            'adjuntos_principal' => $arr_adjuntos_principal,
            'adjuntos_mensajes' => $arr_adjuntos_mensajes
            );
        
        $this->load->view("pages/soportes/ver_soporte.php",$data);
    }


    public function nuevoMensaje() {
        if(isset($_SESSION['adjuntos_soporte'])){
            unset($_SESSION['adjuntos_soporte']);
        }
        $params = $this->uri->uri_to_assoc();
        $id_soporte = $params['id'];

        $soporte = $this->SoportesModel->obtSoporteId($id_soporte);

        if($this->session->userdata['session_idUsuario'] == $soporte[0]->soporte_usuario_fk){
            $grilla = 'usuario';
        }else{
            $grilla = 'soporte';

            if($soporte[0]->soporte_derivado == 1){
                $grilla = 'central';
            }
        }

        $data = array(
            'soporte'=>$soporte[0],
            'grilla' => $grilla
            );
        $this->load->view("pages/soportes/nuevo_mensaje.php",$data);
    }


    public function enviarMensaje() {

        $data = array();
        parse_str($_POST['data'],$data);
        $fecha = date('Y-m-d H:i:s');
        $usuario = $this->session->userdata['session_idUsuario'];
        $cambiarEstado = false;
        if($usuario == $data['usuario_soporte']){
            $visto_usuario = 1;
            $visto_soporte = 0;
        }else{
            $visto_usuario = 0;
            $visto_soporte = 1;
            $cambiarEstado = true;
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
            $id_soporte = $data['id_soporte'];
            if($cambiarEstado){
                $datos = array('soporte_estado' => 2);
                $update = $this->SoportesModel->updSoporte($datos,$data['id_soporte']);

                $soporte_data = $this->SoportesModel->obtSoporteId($id_soporte);
                if($soporte_data[0]->soporte_email == 1){
                    $this->load->model("sendmail_model", "sendMail");
                    $to = $soporte_data[0]->email_usuario;
                    $subject = '[MIDAS::EMERGENCIA] Ticket '.$soporte_data[0]->soporte_codigo.' - Nuevo mensaje';
                    $message = 'Se ha generado un nuevo mensaje en respuesta al Ticket #'.$soporte_data[0]->soporte_codigo.'';
                    $email = $this->sendMail->emailSend($to, $cc = null, $bcc = null, $subject, $message, $dry_run = false);
                }
            }
            
            $json['estado'] = true;
            $json['mensaje'] = "Mensaje enviado correctamente";   
            $dataLog = array(
                'soportehistorial_soporte_fk' => $id_soporte,
                'soportehistorial_usuario_fk' => $usuario,
                'soportehistorial_fecha' => $fecha,
                'soportehistorial_evento' => $this::NUEVO_MENSAJE
                );
            $insertLog = $this->SoportesHistorialModel->insNuevoHistorialSoporte($dataLog);

            if(isset($_SESSION['adjuntos_soporte']) and count($_SESSION['adjuntos_soporte']) > 0){
                $dir = 'media/soportes/'.$id_soporte;
                if(!is_dir($dir)){
                    mkdir($dir,0777,true);
                }
                $adjuntos = $_SESSION['adjuntos_soporte'];
                $totalAdjuntos = count($adjuntos);
                $i = 0;
                foreach($adjuntos as $adjunto){
                    $file = $dir . '/' .$adjunto['name'];
                    $fp = fopen($file,'w+b');
                    $guardado = fwrite($fp,$adjunto['contenido']);
                    fclose($fp);
                    error_log($guardado);
                    if($guardado !== false){
                        $data = array(
                                'soporteadjunto_mensaje_fk'=>$soporte_mensaje,
                                'soporteadjunto_nombre'=>$adjunto['name'],
                                'soporteadjunto_ruta'=>$dir,
                                'soporteadjunto_mime'=>$adjunto['mime'],
                                'soporteadjunto_sha'=>$adjunto['sha']
                            );
                        $id_adjunto = $this->SoportesAdjuntosModel->insNuevoAdjuntoSoporte($data);
                        if($id_adjunto){
                            $i++;
                        }else{
                            @unlink($file);
                        }
                    }
                    
                    
                }

                if($i != $totalAdjuntos){
                    $json['mensaje'] = "Mensaje enviado correctamente, pero algunos adjuntos no pudieron enviarse ";
                }
            }
        }else{
            $delete = $this->SoportesModel->delSoporte($soporte);
            $json['estado'] = false;
            $json['mensaje'] = "Hubo un problema al enviar el mensaje. Intente nuevamente";
        }

        echo json_encode($json);
    }


    public function bandeja_soportes(){
        
        $id_region = $this->session->userdata['session_region_codigo'];
        $soportes = $this->SoportesModel->obtSoportes($id_region);

        $soportes_ingresados = array();
        $soportes_cerrados = array();

        foreach($soportes as $item){
            if($item->soporte_estado == 3){
                $soportes_cerrados[] = $item;
            }else{
                $soportes_ingresados[] = $item;
            }
        }
        $data = array(
            'soportes_ingresados' => $soportes_ingresados,
            'soportes_cerrados' => $soportes_cerrados
            );

        $this->template->parse("default", "pages/soportes/bandeja_soportes", $data);
    } 


    public function cerrarSoporte(){
        $id_soporte = $_POST['soporte'];    
        $fecha = date('Y-m-d H:i:s');
        $data = array('soporte_estado' => 3, 'soporte_fecha_cierre' => $fecha);
        $update = $this->SoportesModel->updSoporte($data,$id_soporte);

        if($update){
            

            $this->load->model("sendmail_model", "sendMail");
            $soporte_data = $this->SoportesModel->obtSoporteId($id_soporte);
            $to = $soporte_data[0]->email_usuario;
            $subject = '[MIDAS::EMERGENCIA] Ticket '.$soporte_data[0]->soporte_codigo.' - Cerrado';
            $message = 'Ticket #'.$soporte_data[0]->soporte_codigo.' ha sido cerrado para su conocimiento.';
            $email = $this->sendMail->emailSend($to, $cc = null, $bcc = null, $subject, $message, $dry_run = false);

            $json['estado'] = true;
            $json['mensaje'] = "El ticket ha sido cerrado";
            $json['grilla'] = 'soporte';
            if($soporte_data[0]->soporte_derivado == 1){
                $json['grilla'] = 'central';
            }

            $dataLog = array(
                'soportehistorial_soporte_fk' => $id_soporte,
                'soportehistorial_usuario_fk' => $this->session->userdata['session_idUsuario'],
                'soportehistorial_fecha' => $fecha,
                'soportehistorial_evento' => $this::TICKET_CERRADO
                );
            $insertLog = $this->SoportesHistorialModel->insNuevoHistorialSoporte($dataLog);
        }else{
            $json['estado'] = false;
            $json['estado'] = "Hubo un problema al cerrar el ticket. Intente nuevamente";
        }

        echo json_encode($json);
    }


    public function agregarAdjunto() {
        $this->load->view("pages/soportes/agregar_adjunto_soporte.php");
    }

    public function cargarAdjunto() {
        
        $data = array();
        if(isset($_FILES['adjunto']) and isset($_POST)){
            $adjunto = array();
            $adjunto['name'] = $_FILES['adjunto']['name'];
            $adjunto['mime'] = $_FILES['adjunto']['type'];
            $adjunto['sha'] = sha1($_FILES['adjunto']['name'] . date('YmdHis'));
            $fp = fopen($_FILES['adjunto']['tmp_name'], 'r+b');
            $adjunto['contenido'] = fread($fp, filesize($_FILES['adjunto']['tmp_name']));
            fclose($fp);

            if($adjunto['contenido'] == ""){
                $error = true;
                $mensaje = 'Error al adjuntar archivo. Intente nuevamente';
            }else{
                $indice = 0;
                if(isset($_SESSION['adjuntos_soporte'])){
                    $indice = count($_SESSION['adjuntos_soporte']) + 1;
                }
                $_SESSION['adjuntos_soporte'][] = $adjunto;
                
                $error = false;
                /*$mensaje = $indice;*/
                $mensaje = '<strong>'.$adjunto['name'] .'</strong>  adjuntado correctamente';
                
            }

            $data = array('error' => $error, 'mensaje' => $mensaje);
        }

        $this->load->view("pages/soportes/cargar_adjunto.php",$data);   
    }


    public function cargarGrillaAdjuntos(){
        $adjuntos = array();
        $html = '';
        if(isset($_SESSION['adjuntos_soporte']) and count($_SESSION['adjuntos_soporte']) > 0){
            $adjuntos = $_SESSION['adjuntos_soporte'];
            $html = '<table class="table table-condensed table-bordered table-hover small table-green table-middle">';
            $html .= '<thead>
                        <tr>
                            <th>Nombre Adjunto</th>
                            <th></th>
                    </thead>';
            $html .= '<tbody>';
            $i = 0;
            foreach($adjuntos as $item){
                $html .= '<tr>
                            <td class="text-center">'.$item['name'].'</td>
                            <td class="text-center">
                                <a href="'.site_url('soportes/verAdjunto/adjunto/'.$i).'" target="_blank" class="btn btn-xs btn-blue btn-square"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0);" class="btn btn-xs btn-red btn-square" onclick="Soportes.sacarAdjunto('.$i.')"><i class="fa fa-trash"></i></a>
                            </td>';
                $i++;
            }
            $html .= '</tbody></table>';
        } 

        echo $html;
    }


    public function verAdjunto(){
        $params = $this->uri->uri_to_assoc();
        if(isset($params['token'])){
            $adjunto = $this->SoportesAdjuntosModel->obtAdjuntoSha($params['token']);
            $ruta = $adjunto->soporteadjunto_ruta . '/' . $adjunto->soporteadjunto_nombre;
            if(is_file($ruta) and filesize($ruta)){
                header('Content-Type: '.$adjunto->soporteadjunto_mime);
                header('Content-Disposition: inline; filename="'.$adjunto->soporteadjunto_nombre.'"');
                header('Expires: 0');
                //header('Content-Length: '.filesize($adjunto['contenido']));
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                readfile($ruta);
                exit;
            }else{
                exit("Adjunto no encontrado");
            }
        }elseif(isset($params['adjunto'])){
            $adjunto = $params['adjunto'];
            if(isset($_SESSION['adjuntos_soporte'][$adjunto])){
                $adjunto = $_SESSION['adjuntos_soporte'][$adjunto];
                header('Content-Type: '.$adjunto['type']);
                header('Content-Disposition: inline; filename="'.$adjunto['name'].'"');
                header('Expires: 0');
                //header('Content-Length: '.filesize($adjunto['contenido']));
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                echo $adjunto['contenido'];
                exit;
            }else{
                exit("Adjunto no encontrado");
            }
        }
        
        /*echo $adjunto;
        echo "<pre>";
        print_r($_SESSION['adjuntos_soporte'][$adjunto]);*/
        

    }


    public function sacarAdjunto(){
        $adjunto = $_POST['adjunto'];
        $i = 0;
        $total = count($_SESSION['adjuntos_soporte']);
        $adjuntos = $_SESSION['adjuntos_soporte'];
        unset($_SESSION['adjuntos_soporte']);
        for($i=0; $i<$total;$i++){
            if($i != $adjunto){
                $_SESSION['adjuntos_soporte'][] = $adjuntos[$i];
            }
        }

        if($total > count($_SESSION['adjuntos_soporte'])){
            $json['estado'] = true;
        }else{
            $json['estado'] = false;
        }

        echo json_encode($json);
    }


    public function derivarSoporte(){
        $id_soporte = $_POST['soporte'];    

        $data = array('soporte_derivado' => 1);
        $update = $this->SoportesModel->updSoporte($data,$id_soporte);

        if($update){
            $json['estado'] = true;
            $json['mensaje'] = "El ticket ha sido derivado a Mesa Central";

            $this->load->model("sendmail_model", "sendMail");
            $soporte_data = $this->SoportesModel->obtSoporteId($id_soporte);
            $to = $soporte_data[0]->email_usuario;
            $subject = '[MIDAS::EMERGENCIA] Ticket '.$soporte_data[0]->soporte_codigo.' - Derivado';
            $message = 'Ticket #'.$soporte_data[0]->soporte_codigo.' ha sido derivado a Mesa Central';
            $email = $this->sendMail->emailSend($to, $cc = null, $bcc = null, $subject, $message, $dry_run = false);

            $dataLog = array(
                'soportehistorial_soporte_fk' => $id_soporte,
                'soportehistorial_usuario_fk' => $this->session->userdata['session_idUsuario'],
                'soportehistorial_fecha' => date('Y-m-d H:i:s'),
                'soportehistorial_evento' => $this::TICKET_DERIVADO
                );
            $insertLog = $this->SoportesHistorialModel->insNuevoHistorialSoporte($dataLog);

        }else{
            $json['estado'] = false;
            $json['estado'] = "Hubo un problema al derivar el ticket. Intente nuevamente";
        }

        echo json_encode($json);
    }


    public function bandeja_soportes_central(){
        
        $id_region = $this->session->userdata['session_region_codigo'];
        $soportes = $this->SoportesModel->obtSoportesCentral();

        $soportes_ingresados = array();
        $soportes_cerrados = array();

        foreach($soportes as $item){
            if($item->soporte_estado == 3){
                $soportes_cerrados[] = $item;
            }else{
                $soportes_ingresados[] = $item;
            }
        }
        $data = array(
            'soportes_ingresados' => $soportes_ingresados,
            'soportes_cerrados' => $soportes_cerrados
            );

        $this->template->parse("default", "pages/soportes/bandeja_soportes_central", $data);
    } 


    public function historialSoporte(){
        $params = $this->uri->uri_to_assoc();
        $id_soporte = $params['id'];

        $soporte = $this->SoportesModel->obtSoporteId($id_soporte);

        $historial = $this->SoportesHistorialModel->obtHistorialSoporte($id_soporte);

        $data = array(
            'soporte' => $soporte[0],
            'historial' => $historial
            );

        $this->load->view("pages/soportes/soporte_historial.php",$data);  

    }


}