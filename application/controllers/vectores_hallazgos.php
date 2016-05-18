<?php

class Vectores_hallazgos extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hallazgos_model', '_hallazgos_model');
        $this->load->model('usuario_rol_model', '_usuario_rol_model');
    }

    public function index() {
        $this->load->library('Fechas');
        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $listar = $this->_hallazgos_model->listar();

        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $entomologo = false;
        $admin = false;
        $presidencia = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ENTOMOLOGO or $rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $entomologo = true;
            }

            if ($rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $admin = true;
            }

            if($rol['rol_ia_id'] == 66){
                $presidencia = true;
            }
        }

        $data = array(
            'grilla' => $this->load->view('pages/vectores/hallazgos/grilla', array('listado' => $listar, 'entomologo' => $entomologo, 'admin' => $admin, 'presidencia' => $presidencia), true),
            'entomologo' => $entomologo,
            'presidencia' => $presidencia
        );

        $this->template->parse("default", "pages/vectores/hallazgos/index", $data);
        //$this->layout_assets->addJs("hallazgos/index.js");
        //$this->layout_template->view('default', 'pages/hallazgos/index', $data);
    }

    public function denuncias() {

        $this->load->library('Fechas');


        $data = array();


        //$this->layout_assets->addMapaFormulario();
        //$this->layout_assets->addJs("hallazgos/denuncias.js");
        $this->template->parse("default", "pages/vectores/hallazgos/denuncias", $data);
    }

    public function revisarDenuncia() {

        $params = $this->uri->uri_to_assoc();

        $this->load->library('Fechas');

        $vector = $this->_hallazgos_model->getById($params['id']);

        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $cambiar_coordenadas = false;
        $presidencia = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $cambiar_coordenadas = true;
            }
            if ($rol['rol_ia_id'] == 66) {
                $presidencia = true;
            }
        }

        $data = array(
            'id' => $vector->id_hallazgo,
            'longitud' => $vector->cd_longitud_hallazgo,
            'latitud' => $vector->cd_latitud_hallazgo,
            'nombres' => $vector->gl_nombres_hallazgo,
            'apellidos' => $vector->gl_apellidos_hallazgo,
            'telefono' => $vector->gl_telefono_hallazgo,
            'direccion' => $vector->gl_direccion_hallazgo,
            'correo' => $vector->gl_email_hallazgo,
            'referencias' => $vector->gl_referencia_hallazgo,
            'fecha_hallazgo' => Fechas::formatearHtml($vector->fc_fecha_hallazgo_hallazgo),
            'comentarios_ciudadano' => $vector->gl_comentario_hallazgo,
            'cambiar_coordenadas' => $cambiar_coordenadas,
            'presidencia' => $presidencia
        );


        $imagenes = $this->_hallazgos_model->getImagenesInspeccion($params['id']);

        $arr_imagenes = array();
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imginspeccion,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imginspeccion),
                    'nombre' => $img->gl_nombre_imginspeccion,
                    'sha' => $img->gl_sha_imginspeccion,
                    'ruta' => $img->gl_ruta_imginspeccion
                );
            }
        }

        $data['imagenes'] = $arr_imagenes;

        $resultado = '';
        $texto_resultado = '';
        switch ($vector->cd_estado_hallazgo) {
            case 1:
                $resultado = 'SI CORRESPONDE';
                $texto_resultado = ' nuestro equipo se dirigirá a su domicilio para la inspección correspondiente';
                break;
            case 2:
                $resultado = 'NO CORRESPONDE';
                $texto_resultado = ' el insecto recolectado no es de importancia sanitaria ';
                if (!empty($vector->gl_observaciones_resultado_vector)):
                    $texto_resultado .= ', ' . $vector->gl_observaciones_resultado_vector;
                endif;
                break;
            case 3:
                $resultado = 'NO ES CONCLUYENTE';
                $texto_resultado = ' el insecto recolectado no es de importancia sanitaria';
                break;
        }

        $datos = array(
            'persona' => $vector->gl_nombres_hallazgo . ' ' . $vector->gl_apellidos_hallazgo,
            'num_denuncia' => $num_denuncia,
            'resultado' => $resultado,
            'texto_resultado' => $texto_resultado
        );
        $contenido = $this->load->view("pages/vectores/hallazgos/pdf_respuesta", $datos, true);
        $data['contenido'] = strip_tags($contenido);


        /* $this->layout_assets->addMapaFormulario();
          $this->layout_assets->addJs("hallazgos/denuncias.js");
          $this->layout_template->view('default', 'pages/hallazgos/denuncias_entomologo', $data); */

        $this->template->parse("default", "pages/vectores/hallazgos/denuncias_entomologo", $data);
    }

    public function revisar() {
        $params = $this->uri->uri_to_assoc();

        $this->load->library('Fechas');

        $vector = $this->_hallazgos_model->getById($params['id']);

        $data = array(
            'id' => $vector->id_hallazgo,
            'longitud' => $vector->cd_longitud_hallazgo,
            'latitud' => $vector->cd_latitud_hallazgo,
            'nombres' => $vector->gl_nombres_hallazgo,
            'apellidos' => $vector->gl_apellidos_hallazgo,
            'telefono' => $vector->gl_telefono_hallazgo,
            'direccion' => $vector->gl_direccion_hallazgo,
            'fecha_hallazgo' => Fechas::formatearHtml($vector->fc_fecha_hallazgo_hallazgo),
            'comentarios_ciudadano' => $vector->gl_comentario_ciudadano_hallazgo,
            'estado' => $vector->cd_estado_hallazgo,
            'estado_desarrollo' => $vector->cd_estado_desarrollo_hallazgo,
            'observaciones' => $vector->gl_observaciones_resultado_hallazgo,
            'correo' => $vector->gl_email_hallazgo,
            'referencias' => $vector->gl_referencia_hallazgo,
            'enviado' => $vector->cd_enviado_hallazgo
        );


        if ($vector->id_hallazgo < 10)
            $num_denuncia = '00' . $vector->id_hallazgo;
        elseif ($vector->id_hallazgo < 100)
            $num_denuncia = '0' . $vector->id_hallazgo;
        else
            $num_denuncia = $vector->id_hallazgo;

        $resultado = '';
        switch ($vector->cd_estado_hallazgo) {
            case 1:
                $resultado = 'SI CORRESPONDE';
                break;
            case 2:
                $resultado = 'NO CORRESPONDE';
                break;
            case 3:
                $resultado = 'NO ES CONCLUYENTE';
                break;
        }

        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $cambiar_coordenadas = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $cambiar_coordenadas = true;
            }
        }

        $datos = array(
            'persona' => $vector->gl_nombres_hallazgo . ' ' . $vector->gl_apellidos_hallazgo,
            'num_denuncia' => $num_denuncia,
            'resultado' => $resultado,
            'texto_entomologo' => $vector->gl_observaciones_resultado_hallazgo,
            'cambiar_coordenadas' => $cambiar_coordenadas
        );
        $contenido = $this->load->view("pages/vectores/hallazgos/pdf_respuesta", $datos, true);
        $data['contenido'] = strip_tags($contenido);

        /* $this->layout_assets->addMapaFormulario();
          $this->layout_assets->addJs("hallazgos/denuncias.js");
          $this->layout_template->view('default', 'pages/hallazgos/denuncias', $data); */

        $this->template->parse("default", "pages/vectores/hallazgos/denuncias", $data);
    }

    public function guardarDenuncia() {

        $params = $this->input->post();

        $this->load->library('Fechas');

        $json = array();

        /* edicion */
        if (isset($params['id']) and $params['id'] > 0) {
            $data = array(
                'cd_longitud_hallazgo' => $params['longitud'],
                'cd_latitud_hallazgo' => $params['latitud'],
                'gl_nombres_hallazgo' => $params['nombres'],
                'gl_apellidos_hallazgo' => $params['apellidos'],
                'gl_telefono_hallazgo' => $params['telefono'],
                'gl_direccion_hallazgo' => $params['direccion'],
                'fc_fecha_hallazgo_hallazgo' => Fechas::formatearBaseDatos($params['fecha_hallazgo']),
                'gl_comentario_hallazgo' => $params['comentarios_ciudadano'],
                'cd_estado_hallazgo' => 0,
                'gl_email_hallazgo' => $params['correo'],
                'gl_referencia_hallazgo' => $params['referencias']
            );

            $update = $this->_hallazgos_model->update($data, $params['id']);
            if ($insertar) {
                $json['estado'] = true;
                /* $json['mensaje'] = 'Se ha generado la denuncia Nº <br/><span style="font-size:64px;text-align: center;display:block;padding:5px" class="bg-primary">' . $insertar . '</span><span style="display:block;font-size:16;text-align:center" class="bg-primary">Este número debe anotarse en el envase que contenga el vector</span><br/>'; */
                $json['mensaje'] = 'La información del hallazgo código I-' . $insertar . ' se ha guardado correctamente';
            } else {
                $json['false'] = false;
                $json['mensaje'] = 'Hubo problemas al guardar el hallazgo. Intente nuevamente';
            }
        } else {
            $data = array(
                'fc_fecha_registro_hallazgo' => date('Y-m-d H:i:s'),
                'cd_usuario_fk_hallazgo' => $this->session->userdata("id"),
                'cd_longitud_hallazgo' => $params['longitud'],
                'cd_latitud_hallazgo' => $params['latitud'],
                'gl_nombres_hallazgo' => $params['nombres'],
                'gl_apellidos_hallazgo' => $params['apellidos'],
                'gl_telefono_hallazgo' => $params['telefono'],
                'gl_direccion_hallazgo' => $params['direccion'],
                'fc_fecha_hallazgo_hallazgo' => Fechas::formatearBaseDatos($params['fecha_hallazgo']),
                'gl_comentario_hallazgo' => $params['comentarios_ciudadano'],
                'cd_estado_hallazgo' => 0,
                'gl_email_hallazgo' => $params['correo']
            );

            $insertar = $this->_hallazgos_model->insert($data);

            if ($insertar) {
                $json['estado'] = true;
                /* $json['mensaje'] = 'Se ha generado la denuncia Nº <br/><span style="font-size:64px;text-align: center;display:block;padding:5px" class="bg-primary">' . $insertar . '</span><span style="display:block;font-size:16;text-align:center" class="bg-primary">Este número debe anotarse en el envase que contenga el vector</span><br/>'; */
                $json['mensaje'] = 'La información del hallazgo código I-' . $insertar . ' se ha guardado correctamente';
            } else {
                $json['false'] = false;
                $json['mensaje'] = 'Hubo problemas al guardar el hallazgo. Intente nuevamente';
            }
        }


        echo json_encode($json);
    }

    public function guardarResultado() {
        $params = $this->input->post();
        $this->load->model("sendmail_model", "_sendmail");

        $data = array(
            'cd_estado_hallazgo' => $params['resultado_laboratorio'],
            'cd_estado_desarrollo_hallazgo' => $params['estado_desarrollo'],
            'fc_fecha_resultado_hallazgo' => date('Y-m-d H:i:s'),
            'cd_entomologo_fk_hallazgo' => $this->session->userdata('id'),
            'gl_observaciones_resultado_hallazgo' => $params['observaciones_resultado']
        );

        $json = array();
        $contenido = nl2br($params['observaciones_resultado']);
        if ($this->_hallazgos_model->update($data, $params['id'])) {

            $resultado = '';
            switch ($params['resultado_laboratorio']) {
                case 1:
                    $resultado = 'POSITIVO';
                    break;
                case 2:
                    $resultado = 'NEGATIVO';
                    break;
                case 3:
                    $resultado = 'NO CONCLUYENTE';
                    break;
            }

            $vector = $this->_hallazgos_model->getById($params['id']);


            $this->load->library('mailer');
            $this->load->library('Fechas');

            $to = trim($vector->gl_email_hallazgo);
            $subject = 'Inspecciones - SEREMI de Salud Arica y Parinacota';
            $msg = '<h3>Monitoreo - Vigilancia de Vectores</h3>';
            $msg .= 'Estimado/a ' . $vector->gl_nombres_hallazgo . ' ' . $vector->gl_apellidos_hallazgo . ' <br/><br/>';
            $msg .= 'Ud. tiene una respuesta a la inspección realizada en su domicilio el día <strong>' .
                    Fechas::formatearHtml($vector->fc_fecha_hallazgo) . '</strong>, en adjunto podrá revisar el resultado
        y recomendaciones.';
            /* $msg .= '<p>El resultado de la denuncia es : <strong>' . $resultado . '</strong></p>';
              $msg .= '<p>Observaciones : ' . $vector->gl_observaciones_resultado_vector . '</strong></p>';
              $msg .= date('d/m/Y H:i:s'); */
            $msg .= '<p>Atte.<br/>Seremi de Salud Arica y Parinacota</p>';
            //$url_logo = file_get_contents(base_url('assets/img/logo_seremi15.jpg'));
            $url_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
            $msg .= '<img src="data:image/jpg;base64,' . base64_encode($url_logo) . '"/>';

            $this->load->library(
                    array(
                        "pdf"
                    )
            );

            if ($vector->id_hallazgo < 10)
                $num_denuncia = '00' . $vector->id_hallazgo;
            elseif ($vector->id_hallazgo < 100)
                $num_denuncia = '0' . $vector->id_hallazgo;
            else
                $num_denuncia = $vector->id_hallazgo;

            $datos = array(
                'contenido' => $contenido,
                'url_logo' => 'data:image/jpg;base64,' . base64_encode($url_logo),
                'imagen00' =>
                'data:image/jpg;base64,' . base64_encode(file_get_contents(FCPATH . 'assets/img/vectores_zika/imagen00.jpg')),
                'imagen01' =>
                'data:image/jpg;base64,' . base64_encode(file_get_contents(FCPATH . 'assets/img/vectores_zika/imagen01.jpg')),
                'imagen02' =>
                'data:image/jpg;base64,' . base64_encode(file_get_contents(FCPATH . 'assets/img/vectores_zika/imagen02.jpg'))
            );
            $html = $this->load->view("pages/vectores/hallazgos/pdf_envio", $datos, true);

            $pdf = $this->pdf->load();
            $pdf->imagen_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
            $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
            $pdf->WriteHTML($html);
            $ruta_pdf = 'docs/hallazgos/' . $vector->id_hallazgo;

            if (!@mkdir($ruta_pdf, 0777, true) && !is_dir($ruta_pdf)) {
                $json['mensaje'] = 'No se puede guardar PDF de Respuesta para ser enviado';
                $json['estado'] = false;
                $data = array(
                    'cd_enviado_hallazgo' => 0
                );
                $update = $this->_hallazgos_model->update($data, $params['id']);
            } else {
                $documento = $pdf->Output(FCPATH . 'docs/hallazgos/' . $vector->id_hallazgo . '/respuesta_inspeccion_' . $num_denuncia . '.pdf', 'F');

                $attachment = array(FCPATH . '/' . $ruta_pdf . '/respuesta_inspeccion_' . $num_denuncia . '.pdf');
                //$email = $this->mailer->load();
                if ($this->_sendmail->emailSend($to, null, null, $subject, $msg, false, $attachment)) {
                    $json['mensaje'] = 'El resultado ha sido guardado y se le ha enviado un correo a la persona con el aviso';
                    $data = array(
                        'cd_enviado_hallazgo' => 1,
                        'gl_ruta_respuesta_hallazgo' => $ruta_pdf . '/respuesta_inspeccion_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_hallazgos_model->update($data, $params['id']);
                } else {
                    $data = array(
                        'cd_enviado_hallazgo' => 0,
                        'gl_ruta_respuesta_hallazgo' => $ruta_pdf . '/respuesta_inspeccion_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_hallazgos_model->update($data, $params['id']);
                    $json['mensaje'] = 'El resultado ha sido guardado, pero correo de aviso no ha podido ser enviado';
                }


                $json['estado'] = true;
            }


//            if ($this->sendmail->emailSend($to, null, null, $subject, $msg)) {
//                $json['mensaje'] = 'El resultado ha sido guardado y se le ha enviado un correo a la persona con el aviso';
//            } else {
//                $json['mensaje'] = 'El resultado ha sido guardado, pero correo de aviso no ha podido ser enviado';
//            }
//
//            $json['mensaje'] = 'El resultado ha sido guardado';
//            $json['estado'] = true;
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al guardar el resultado. Intente nuevamente';
        }

        echo json_encode($json);
    }

    public function enviarResultado() {
        $params = $this->input->post();
        $this->load->model("sendmail_model", "_sendmail");

        $data = array(
            'cd_enviado_hallazgo' => 1,
            'gl_observaciones_resultado_hallazgo' => $params['observaciones_resultado']
        );

        $contenido = nl2br($params['observaciones_resultado']);
        $json = array();
        if ($this->_hallazgos_model->update($data, $params['id'])) {
            $json['estado'] = true;
            $json['mensaje'] = 'El resultado ha sido guardado, pero correo de aviso no ha podido ser enviado';
            $vector = $this->_hallazgos_model->getById($params['id']);

            $resultado = '';
            switch ($vector->cd_estado_hallazgo) {
                case 1:
                    $resultado = 'SI CORRESPONDE';
                    break;
                case 2:
                    $resultado = 'NO CORRESPONDE';
                    break;
                case 3:
                    $resultado = 'NO ES CONCLUYENTE';
                    break;
            }

            $this->load->library('mailer');
            $this->load->library('Fechas');

            $to = trim($vector->gl_email_hallazgo);
            $subject = 'Denuncias - SEREMI de Salud Arica y Parinacota';
            $msg = '<h3>Monitoreo - Vigilancia de Vectores</h3>';
            $msg .= 'Estimado/a ' . $vector->gl_nombres_hallazgo . ' ' . $vector->gl_apellidos_hallazgo . ' <br/><br/>';
            $msg .= 'Ud. tiene una respuesta a la denuncia realizada el día <strong>' . Fechas::formatearHtml($vector->fc_fecha_entrega_hallazgo) . '</strong>, en adjunto podrá revisar el resultado y recomendaciones.';

            $msg .= '<p>Atte.<br/>Seremi de Salud Arica y Parinacota</p>';
            $url_logo = file_get_contents(base_url('assets/img/logo_seremi15.jpg'));
            $msg .= '<img src="data:image/jpg;base64,' . base64_encode($url_logo) . '" />';

            $this->load->library(
                    array(
                        "core/pdf"
                    )
            );

            if ($vector->id_hallazgo < 10)
                $num_denuncia = '00' . $vector->id_hallazgo;
            elseif ($vector->id_hallazgo < 100)
                $num_denuncia = '0' . $vector->id_hallazgo;
            else
                $num_denuncia = $vector->id_hallazgo;

            $datos = array(
                'contenido' => $contenido,
                'url_logo' => 'data:image/jpg;base64,' . base64_encode($url_logo),
                'imagen00' => 'data:image/jpg;base64,' . base64_encode(file_get_contents(base_url('assets/img/hallazgos_zika/imagen00.jpg'))),
                'imagen01' => 'data:image/jpg;base64,' . base64_encode(file_get_contents(base_url('assets/img/hallazgos_zika/imagen01.jpg'))),
                'imagen02' => 'data:image/jpg;base64,' . base64_encode(file_get_contents(base_url('assets/img/hallazgos_zika/imagen02.jpg')))
            );
            $html = $this->load->view("pages/hallazgos/pdf_envio", $datos, true);

            $pdf = $this->pdf->load();
            $pdf->imagen_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
            $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
            $pdf->WriteHTML($html);
            $ruta_pdf = 'docs/hallazgos/' . $vector->id_hallazgo;
            if (!@mkdir($ruta_pdf, 0777, true) && !is_dir($ruta_pdf)) {
                $json['mensaje'] = 'No se puede guardar PDF de Respuesta para ser enviado';
                $json['estado'] = false;
                $data = array(
                    'cd_enviado_hallazgo' => 0
                );
                $update = $this->_hallazgos_model->update($data, $params['id']);
            } else {
                $documento = $pdf->Output(FCPATH . 'docs/hallazgos/' . $vector->id_hallazgo . '/respuesta_denuncia_' . $num_denuncia . '.pdf', 'F');

                $attachment = array(FCPATH . '/' . $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf');
                if ($this->sendmail->emailSend($to, null, null, $subject, $msg, false, $attachment)) {
                    $json['mensaje'] = 'El resultado ha sido guardado y se le ha enviado un correo a la persona con el aviso';
                    $data = array(
                        'gl_ruta_respuesta_hallazgo' => $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_hallazgos_model->update($data, $params['id']);
                } else {
                    $data = array(
                        'cd_enviado_hallazgo' => 0,
                        'gl_ruta_respuesta_hallazgo' => $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_hallazgos_model->update($data, $params['id']);
                    $json['mensaje'] = 'El resultado ha sido guardado, pero correo de aviso no ha podido ser enviado';
                }


                $json['estado'] = true;
            }
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al guardar el resultado. Intente nuevamente';
        }

        echo json_encode($json);
    }

    public function adjuntarImagenesInspeccion($id = null) {

        $params = $this->uri->uri_to_assoc();


        $imagenes = $this->_hallazgos_model->getImagenesInspeccion($params['id']);

        $this->load->library('Fechas');

        $arr_imagenes = array();
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imginspeccion,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imginspeccion),
                    'nombre' => $img->gl_nombre_imginspeccion,
                    'sha' => $img->gl_sha_imginspeccion,
                    'ruta' => $img->gl_ruta_imginspeccion
                );
            }
        }

        $data = array(
            'id' => $params['id'],
            'imagenes' => $arr_imagenes
        );
        $this->template->parse("default", "pages/vectores/hallazgos/upload_imagenes", $data);
        //$this->layout_assets->addJs("hallazgos/denuncias.js");
        //$this->layout_template->view('default', 'pages/vectores/hallazgos/upload_imagenes', $data);
    }

    public function subirImagenInspeccion() {

        $params = $this->input->post();
        $imagenes = $this->_hallazgos_model->getImagenesInspeccion($params['id']);


        $archivo = $_FILES['imagen'];

        $error = false;

        if ($archivo['type'] != 'image/png' and $archivo['type'] != 'image/jpeg' and $archivo['type'] != 'image/jpg') {
            $error = true;
            $error_mensaje = 'Formato de imagen no permitido. Sólo se aceptan PNG o JPG';
        }


        $data = array(
            'id' => $params['id']
        );

        if ($error) {
            $data['error'] = true;
            $data['error_mensaje'] = $error_mensaje;
        } else {
            $dir = 'docs/hallazgos/' . $params['id'];

            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }

            $nombre = str_replace(' ', '_', $archivo['name']);

            if (move_uploaded_file($archivo['tmp_name'], $dir . '/' . $nombre)) {
                if (is_file($dir . '/' . $nombre)) {
                    $datos = array();
                    $datos['inspeccion'] = $params['id'];
                    $datos['usuario'] = $this->session->userdata('id');
                    $datos['fecha'] = date('Y-m-d H:i:s');
                    $datos['ruta'] = $dir;
                    $datos['mime'] = $archivo['type'];
                    $datos['sha'] = sha1($nombre);
                    $datos['nombre'] = $nombre;

                    $insertar = $this->_hallazgos_model->insImagenInspeccion($datos);
                    if ($insertar) {
                        $data['error_mensaje'] = 'Imagen agregada';
                        $data['error'] = false;
                    } else {
                        $data['error_mensaje'] = 'Imagen no guardada. Intente nuevamente';
                        $data['error'] = true;
                    }
                } else {
                    $data['error'] = true;
                    $data['error_mensaje'] = 'No se ha podido comprobar la subida de la imagen. Intente de nuevo por favor.';
                }
            } else {
                $data['error'] = true;
                $data['error_mensaje'] = 'Error al subir imagen. Por favor intente nuevamente';
            }
        }

        $imagenes = $this->_hallazgos_model->getImagenesInspeccion($params['id']);

        $this->load->library('Fechas');

        $arr_imagenes = array();
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imginspeccion,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imginspeccion),
                    'nombre' => $img->gl_nombre_imginspeccion,
                    'sha' => $img->gl_sha_imginspeccion,
                    'ruta' => $img->gl_ruta_imginspeccion
                );
            }
        }

        $data['imagenes'] = $arr_imagenes;
        $this->template->parse("default", "pages/vectores/hallazgos/upload_imagenes", $data);
        //$this->layout_template->view('default', 'pages/hallazgos/upload_imagenes', $data);
    }

    public function verImagenInspeccion() {
        $params = $this->uri->uri_to_assoc();

        $imagen = $this->_hallazgos_model->getImagenInspeccion($params['id'], $params['sha']);

        $this->load->library('Fechas');


        $data = array(
            'fecha' => Fechas::formatearHtml($imagen->fc_fecha_imginspeccion),
            'ruta' => $imagen->gl_ruta_imginspeccion,
            'nombre' => $imagen->gl_nombre_imginspeccion,
            'sha' => $imagen->gl_sha_imginspeccion,
            'id' => $imagen->id_imginspeccion
        );

        if (isset($params['otra']) and $params['otra'] == true) {
            $data['boton'] = true;
        }

        echo $this->load->view('pages/vectores/hallazgos/ver_imagen', $data, true);
    }

    public function eliminarImagen() {
        $params = $this->input->post();

        $imagen = $this->_hallazgos_model->getImagenInspeccion($params['imagen']);

        $del = $this->_hallazgos_model->delImagenInspeccion($params['imagen'], $params['denuncia']);
        $json = array();
        if ($del) {
            @unlink($imagen->gl_ruta_imginspeccion . '/' . $imagen->gl_nombre_imginspeccion);

            $json['estado'] = true;
            $json['mensaje'] = 'Imagen eliminada';
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al eliminar la imagen';
        }

        echo json_encode($json);
    }

    public function cambiarCoordenadas() {
        $params = $this->input->post();

        $data = array(
            'cd_longitud_hallazgo' => $params['lon'],
            'cd_latitud_hallazgo' => $params['lat']
        );

        $json = array();
        if ($this->_hallazgos_model->update($data, $params['id'])) {
            $json['mensaje'] = 'Coordenadas actualizadas';
            $json['estado'] = true;
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al cambiar las coordenadas. Intente nuevamente';
        }

        echo json_encode($json);
    }

    public function excel() {

        $this->load->library("excel");
        $this->load->library("Fechas");

        $lista = $this->_hallazgos_model->listar();

        $datos_excel = array();
        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                $estado = '';
                if ($caso['cd_estado_hallazgo'] == 0 and $caso['cd_enviado_hallazgo'] == 0):
                    $estado = 'Ingresado';
                elseif ($caso['cd_estado_hallazgo'] > 0 and $caso['cd_enviado_hallazgo'] == 0):
                    $estado = 'Revisado -  Respondido';
                elseif ($caso['cd_estado_hallazgo'] > 0 and $caso['cd_enviado_hallazgo'] == 1):
                    $estado = 'Enviado';
                endif;

                $resultado = '';
                if ($caso['cd_estado_hallazgo'] == 0):
                    $resultado = 'En Revisión';
                elseif ($caso['cd_estado_hallazgo'] == 1):
                    $resultado = 'Positivo';
                elseif ($caso['cd_estado_hallazgo'] == 2):
                    $resultado = 'Negativo';
                elseif ($caso['cd_estado_hallazgo'] == 3):
                    $resultado = 'No concluyente';
                endif;

                $estadio_desarrollo = '';
                if ($caso['cd_estado_desarrollo_hallazgo'] == 1)
                    $estadio_desarrollo = 'Larva';
                elseif ($caso['cd_estado_desarrollo_hallazgo'] == 2)
                    $estadio_desarrollo = 'Pupa';
                elseif ($caso['cd_estado_desarrollo_hallazgo'] == 3)
                    $estadio_desarrollo = 'Adulto';


                $datos_excel[] = array(
                    'codigo' => 'I-' . $caso['id_hallazgo'],
                    'fecha_registro' => Fechas::formatearHtml($caso['fc_fecha_registro_hallazgo']),
                    'nombre' => $caso['gl_nombres_hallazgo'] . ' ' . $caso['gl_apellidos_hallazgo'],
                    'rut' => $caso['gl_run_hallazgo'],
                    'direccion' => $caso['gl_direccion_hallazgo'] . ' ' . $caso['gl_referencias_hallazgo'],
                    'latitud' => $caso['cd_latitud_hallazgo'],
                    'longitud' => $caso['cd_longitud_hallazgo'],
                    'telefono' => $caso['gl_telefono_hallazgo'],
                    'email' => $caso['gl_email_hallazgo'],
                    'fecha_hallazgo' => Fechas::formatearHtml($caso['fc_fecha_hallazgo_hallazgo']),
                    'estado' => $estado,
                    'resultado' => $resultado,
                    'estadio_desarrollo' => $estadio_desarrollo,
                    'observaciones' => $caso['gl_observaciones_resultado_hallazgo']
                );

                /* $datos_excel[count($datos_excel)-1]["id_estado"]  = $caso["id_estado"]; */
            }

            $excel = $this->excel->nuevoExcel();
            $excel->getProperties()
                    ->setCreator("Midas - Monitoreo")
                    ->setLastModifiedBy("Midas - Monitoreo")
                    ->setTitle("Exportación de Vectores - Denuncias")
                    ->setSubject("Monitoreo")
                    ->setDescription("Denuncias")
                    ->setKeywords("office 2007 openxml php monitoreo")
                    ->setCategory("Midas");

            $columnas = reset($datos_excel);


            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, "INSPECCION");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, "FECHA REGISTRO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, "NOMBRE");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, 1, "RUT/PASAPORTE");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, 1, "DIRECCION");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, 1, "LATITUD");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, 1, "LONGITUD");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, 1, "TELEFONO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 1, "EMAIL");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, 1, "FECHA HALLAZGO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, 1, "ESTADO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, 1, "RESULTADO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 1, "ESTADIÓ DESARROLLO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 1, "OBSERVACIONES");

            $j = 2;
            foreach ($datos_excel as $id => $valores) {

                //unset($valores["id_usuario"]);

                $i = 0;
                foreach ($valores as $columna => $valor) {
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, mb_strtoupper($valor));
                    $i++;
                }
                $j++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="vectores_inspecciones_' . date('d-m-Y') . '.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            echo "No hay registros para generar el excel";
        }
    }

}
