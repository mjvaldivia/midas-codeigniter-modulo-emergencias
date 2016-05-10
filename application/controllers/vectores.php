<?php

class vectores extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->login_authentificate->validar();

        $this->load->model('vectores_model', '_vectores_model');
        $this->load->model('usuario_rol_model', '_usuario_rol_model');

    }


    public function index()
    {
        $this->load->library('Fechas');
        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $listar = $this->_vectores_model->listar();

        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $entomologo = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ENTOMOLOGO or $rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $entomologo = true;
            }

        }

        $data = array(
            'grilla' => $this->load->view('pages/vectores/denuncias/grilla', array('listado' => $listar, 'entomologo' => $entomologo), true),
            'entomologo' => $entomologo
        );
        //$this->layout_assets->addJs("vectores/index.js");
        
        $this->template->parse("default", "pages/vectores/denuncias/index", $data);
        
    }

    /**
     *
     */
    public function denuncias()
    {

        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $cambiar_coordenadas = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $cambiar_coordenadas = true;
            }

        }

        $this->load->library('Fechas');
        $data = array(
            'cambiar_coordenadas' => $cambiar_coordenadas,
            "js" => $this->load->view("pages/mapa/js-plugins", array(), true)
        );
        
        /*$this->layout_assets->addMapaFormulario();
        $this->layout_assets->addJs("vectores/denuncias.js");
        $this->layout_template->view('default', 'pages/vectores/denuncias', $data);*/

        $this->template->parse("default", 'pages/vectores/denuncias/denuncias', $data);
    }

    /**
     *
     */
    public function revisarDenuncia()
    {

        $params = $this->uri->uri_to_assoc();

        $this->load->library('Fechas');

        $vector = $this->_vectores_model->getById($params['id']);

        $this->load->model('rol_model');
        $rol_model = new Rol_Model();
        $roles = $this->_usuario_rol_model->listarRolesPorUsuario($this->session->userdata('session_idUsuario'));
        $cambiar_coordenadas = false;
        foreach ($roles as $rol) {
            if ($rol['rol_ia_id'] == $rol_model::ADMINISTRADOR) {
                $cambiar_coordenadas = true;
            }

        }

        $imagenes = $this->_vectores_model->getImagenesVector($params['id']);

        $arr_imagenes = array();
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imgdenuncia,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imgdenuncia),
                    'nombre' => $img->gl_nombre_imgdenuncia,
                    'sha' => $img->gl_sha_imgdenuncia,
                    'ruta' => $img->gl_ruta_imgdenuncia
                );
            }
        }

        
        $data = array(
            'id' => $vector->id_vector,
            'longitud' => $vector->cd_longitud_vector,
            'latitud' => $vector->cd_latitud_vector,
            'nombres' => $vector->gl_nombres_vector,
            'apellidos' => $vector->gl_apellidos_vector,
            'cedula' => $vector->gl_run_vector,
            'telefono' => $vector->gl_telefono_vector,
            'correo' => $vector->gl_email_vector,
            'direccion' => $vector->gl_direccion_vector,
            'referencias' => $vector->gl_referencias_vector,
            'fecha_hallazgo' => Fechas::formatearHtml($vector->fc_fecha_hallazgo_vector),
            'fecha_entrega' => Fechas::formatearHtml($vector->fc_fecha_entrega_vector),
            'comentarios_ciudadano' => $vector->gl_comentario_ciudadano_vector,
            'js' => $this->load->view("pages/mapa/js-plugins", array(), true),
            'imagenes' => $arr_imagenes,
            'cambiar_coordenadas' => $cambiar_coordenadas
        );


        //$this->layout_assets->addMapaFormulario();
        //$this->layout_assets->addJs("vectores/denuncias.js");
        //$this->layout_template->view('default', 'pages/vectores/denuncias_entomologo', $data);
        $this->template->parse("default", 'pages/vectores/denuncias/denuncias_entomologo', $data);
    }

    /**
     *
     */
    public function revisar()
    {
        $params = $this->uri->uri_to_assoc();

        $this->load->library('Fechas');

        $vector = $this->_vectores_model->getById($params['id']);

        $data = array(
            'id' => $vector->id_vector,
            'longitud' => $vector->cd_longitud_vector,
            'latitud' => $vector->cd_latitud_vector,
            'nombres' => $vector->gl_nombres_vector,
            'apellidos' => $vector->gl_apellidos_vector,
            'cedula' => $vector->gl_run_vector,
            'telefono' => $vector->gl_telefono_vector,
            'correo' => $vector->gl_email_vector,
            'direccion' => $vector->gl_direccion_vector,
            'referencias' => $vector->gl_referencias_vector,
            'fecha_hallazgo' => Fechas::formatearHtml($vector->fc_fecha_hallazgo_vector),
            'fecha_entrega' => Fechas::formatearHtml($vector->fc_fecha_entrega_vector),
            'comentarios_ciudadano' => $vector->gl_comentario_ciudadano_vector,
            'estado' => $vector->cd_estado_vector,
            'estado_desarrollo' => $vector->cd_estado_desarrollo_vector,
            'observaciones' => $vector->gl_observaciones_resultado_vector
        );


        if ($vector->id_vector < 10)
            $num_denuncia = '00' . $vector->id_vector;
        elseif ($vector->id_vector < 100)
            $num_denuncia = '0' . $vector->id_vector;
        else
            $num_denuncia = $vector->id_vector;

        $resultado = '';
        $texto_resultado = '';
        switch ($vector->cd_estado_vector) {
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
            'persona' => $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector,
            'num_denuncia' => $num_denuncia,
            'resultado' => $resultado,
            'texto_resultado' => $texto_resultado
        );
        $contenido = $this->load->view("pages/vectores/denuncias/pdf_respuesta", $datos, true);
        $data['contenido'] = strip_tags($contenido);

        //$this->layout_assets->addMapaFormulario();
        //$this->layout_assets->addJs("vectores/denuncias.js");
        $this->template->parse("default", 'pages/vectores/denuncias/denuncias', $data);
        //$this->layout_template->view('default', 'pages/vectores/denuncias', $data);
    }


    public function guardarDenuncia()
    {

        $params = $this->input->post();

        $this->load->library('Fechas');

        $json = array();

        /* edicion */
        if (isset($params['id']) and $params['id'] > 0) {
            $data = array(
                'cd_longitud_vector' => $params['longitud'],
                'cd_latitud_vector' => $params['latitud'],
                'gl_nombres_vector' => $params['nombres'],
                'gl_apellidos_vector' => $params['apellidos'],
                'gl_run_vector' => $params['cedula'],
                'gl_telefono_vector' => $params['telefono'],
                'gl_email_vector' => $params['correo'],
                'gl_direccion_vector' => $params['direccion'],
                'gl_referencias_vector' => $params['referencias'],
                'fc_fecha_hallazgo_vector' => Fechas::formatearBaseDatos($params['fecha_hallazgo']),
                'fc_fecha_entrega_vector' => Fechas::formatearBaseDatos($params['fecha_entrega']),
                'gl_comentario_ciudadano_vector' => $params['comentarios_ciudadano'],
                'cd_estado_vector' => 0
            );

            $update = $this->_vectores_model->update($data, $params['id']);

            if ($update) {
                $mensaje_envio = '';
                $json['estado'] = true;
                $json['mensaje'] = 'Datos guardados' . $mensaje_envio;
            } else {
                $json['false'] = false;
                $json['mensaje'] = 'Hubo problemas al guardar la denuncia. Intente nuevamente';

            }
        } else {
            $data = array(
                'fc_fecha_registro_vector' => date('Y-m-d H:i:s'),
                'cd_usuario_fk_vector' => $this->session->userdata("id"),
                'cd_longitud_vector' => $params['longitud'],
                'cd_latitud_vector' => $params['latitud'],
                'gl_nombres_vector' => $params['nombres'],
                'gl_apellidos_vector' => $params['apellidos'],
                'gl_run_vector' => $params['cedula'],
                'gl_telefono_vector' => $params['telefono'],
                'gl_email_vector' => $params['correo'],
                'gl_direccion_vector' => $params['direccion'],
                'gl_referencias_vector' => $params['referencias'],
                'fc_fecha_hallazgo_vector' => Fechas::formatearBaseDatos($params['fecha_hallazgo']),
                'fc_fecha_entrega_vector' => Fechas::formatearBaseDatos($params['fecha_entrega']),
                'gl_comentario_ciudadano_vector' => $params['comentarios_ciudadano'],
                'cd_estado_vector' => 0
            );

            $insertar = $this->_vectores_model->insert($data);

            if ($insertar) {
                /*$vector = $this->_vectores_model->getById($insertar);

                $this->load->library('sendmail');
                $this->load->library('Fechas');

                $to = trim($vector->gl_email_vector);
                $subject = 'Denuncias - SEREMI de Salud Arica y Parinacota';
                $msg = '<h3>Comprobante de Denuncia</h3>';
                $msg .= 'Estimado/a ' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . ' <br/><br/>';
                $msg .= 'Ud. ha realizado una denuncia el día <strong>' . Fechas::formatearHtml($vector->fc_fecha_entrega_vector) .
                    '</strong>, detallado como:<br/><br/>';

                if($vector->id_vector < 10)
                $num_denuncia = '00'.$vector->id_vector;
                elseif($vector->id_vector < 100)
                $num_denuncia = '0'.$vector->id_vector;
                else
                $num_denuncia = $vector->id_vector;

                $msg .= 'Número denuncia : <strong>' . $num_denuncia . '</strong><br/>';
                $msg .= 'Nombre : <strong>' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . '</strong><br/>';
                $msg .= 'Rut/Pasaporte : <strong>' . $vector->gl_rut_vector . '</strong><br/>';
                $msg .= 'Dirección : <strong>' . $vector->gl_direccion_vector . ' , '.$vector->gl_referencias_vector.'</strong><br/>';
                $msg .= 'Fecha de Hallazgo : <strong>' . Fechas::formatearHtml($vector->fc_fecha_hallazgo_vector). '</strong><br/>';
                $msg .= 'Teléfono : <strong>' . $vector->gl_telefono_vector. '</strong><br/>';
                $msg .= 'Comentario : <strong>' . $vector->gl_comentario_ciudadano_vector. '</strong><br/>';
                $msg .= '<p>Atte.<br/>Seremi de Salud Arica y Parinacota</p>';
                $contenido = $msg;

                $url_logo = file_get_contents(base_url('assets/img/logo_seremi15.jpg'));
                $msg .= '<img src="data:image/jpg;base64,'.base64_encode($url_logo).'"/>';

                $this->load->library(
                array(
                "core/pdf"
                )
                );

                if($vector->id_vector < 10)
                $num_denuncia = '00'.$vector->id_vector;
                elseif($vector->id_vector < 100)
                $num_denuncia = '0'.$vector->id_vector;
                else
                $num_denuncia = $vector->id_vector;

                $datos = array(
                'contenido' => $contenido,
                'url_logo' => 'data:image/jpg;base64,'.base64_encode($url_logo)
                );
                $html = $this->load->view("pages/vectores/pdf_comprobante", $datos, true);

                $pdf = $this->pdf->load();
                $pdf->imagen_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
                $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
                $pdf->WriteHTML($html);
                $ruta_pdf = 'docs/vectores/'.$vector->id_vector;
                if(!@mkdir($ruta_pdf,0777,true) && !is_dir($ruta_pdf)){

                }else{
                $documento = $pdf->Output(FCPATH . 'docs/vectores/'.$vector->id_vector.'/comprobante_denuncia_'.$num_denuncia.'.pdf', 'F');

                $attachment = array(FCPATH . '/'.$ruta_pdf.'/comprobante_denuncia_'.$num_denuncia.'.pdf');

                if ($this->sendmail->emailSend($to, null, null, $subject, $msg, false, $attachment)) {
                $mensaje_envio = ' Comprobante de Denuncia ha sido enviado a correo ';
                } else {
                $mensaje_envio = ' Comprobante de denuncia no ha sido enviado a correo de ciudadano ';
                }


                }*/

                $mensaje_envio = '';
                $json['estado'] = true;
                $json['mensaje'] = 'Se ha generado la denuncia Nº<br/><span
    style="font-size:64px;text-align: center;display:block;padding:5px" class="bg-primary">D-' . $insertar . '</span>
<span style="display:block;font-size:16;text-align:center" class="bg-primary">Este número debe anotarse en el envase que contenga el vector</span>
<br/>' . $mensaje_envio;
            } else {
                $json['false'] = false;
                $json['mensaje'] = 'Hubo problemas al guardar la denuncia. Intente nuevamente';
            }
        }


        echo json_encode($json);

    }


    public function guardarResultado()
    {
        $params = $this->input->post();

        $data = array(
            'cd_estado_vector' => $params['resultado_laboratorio'],
            'cd_estado_desarrollo_vector' => $params['estado_desarrollo'],
            'fc_fecha_resultado_vector' => date('Y-m-d H:i:s'),
            'cd_entomologo_fk_vector' => $this->session->userdata('id'),
            'gl_observaciones_resultado_vector' => $params['observaciones_resultado']
        );

        $json = array();
        if ($this->_vectores_model->update($data, $params['id'])) {

            /*$resultado = '';
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

            $vector = $this->_vectores_model->getById($params['id']);


            $this->load->library('sendmail');
            $this->load->library('Fechas');

            $to = trim($vector->gl_email_vector);
            $subject = 'Monitoreo - Denuncias';
            $msg = '<h3>Monitoreo - Vigilancia de Vectores</h3>';
            $msg .= 'Estimado/a ' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . ' <br/><br/>';
            $msg .= 'Ud. tiene una respuesta a la denuncia realizada el día <strong>' .
                Fechas::formatearHtml($vector->fc_fecha_entrega_vector) . '<strong>';
                    $msg .= '<p>El resultado de la denuncia es : <strong>' . $resultado . '</strong></p>';
                    $msg .= date('d/m/Y H:i:s');

                    if ($this->sendmail->emailSend($to, null, null, $subject, $msg)) {
                    $json['mensaje'] = 'El resultado ha sido guardado y se le ha enviado un correo a la persona con el aviso';
                    } else {
                    $json['mensaje'] = 'El resultado ha sido guardado, pero correo de aviso no ha podido ser enviado';
                    }*/

            $json['mensaje'] = 'El resultado ha sido guardado';
            $json['estado'] = true;

        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al guardar el resultado. Intente nuevamente';
        }

        echo json_encode($json);
    }


    public function enviarResultado()
    {
        $params = $this->input->post();
        $this->load->model("sendmail_model","_sendmail");

        $data = array(
            'cd_enviado_vector' => 1,
            'gl_observaciones_resultado_vector' => $params['observaciones_resultado']
        );

        $contenido = nl2br($params['observaciones_resultado']);
        $json = array();
        if ($this->_vectores_model->update($data, $params['id'])) {


            $vector = $this->_vectores_model->getById($params['id']);

            $resultado = '';
            switch ($vector->cd_estado_vector) {
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

            $to = trim($vector->gl_email_vector);
            $subject = 'Denuncias - SEREMI de Salud Arica y Parinacota';
            $msg = '<h3>Monitoreo - Vigilancia de Vectores</h3>';
            $msg .= 'Estimado/a ' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . ' <br/><br/>';
            $msg .= 'Ud. tiene una respuesta a la denuncia realizada el día <strong>' .
                Fechas::formatearHtml($vector->fc_fecha_entrega_vector) . '</strong>, en adjunto podrá revisar el resultado
        y recomendaciones.';
            /*$msg .= '<p>El resultado de la denuncia es : <strong>' . $resultado . '</strong></p>';
            $msg .= '<p>Observaciones : ' . $vector->gl_observaciones_resultado_vector . '</strong></p>';
        $msg .= date('d/m/Y H:i:s');*/
            $msg .= '<p>Atte.<br/>Seremi de Salud Arica y Parinacota</p>';
            //$url_logo = file_get_contents(base_url('assets/img/logo_seremi15.jpg'));
            $url_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
            $msg .= '<img src="data:image/jpg;base64,' . base64_encode($url_logo) . '"/>';

            $this->load->library(
                array(
                    "pdf"
                )
            );

            if ($vector->id_vector < 10)
                $num_denuncia = '00' . $vector->id_vector;
            elseif ($vector->id_vector < 100)
                $num_denuncia = '0' . $vector->id_vector;
            else
                $num_denuncia = $vector->id_vector;

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
            $html = $this->load->view("pages/vectores/denuncias/pdf_envio", $datos, true);

            $pdf = $this->pdf->load();
            $pdf->imagen_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
            $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
            $pdf->WriteHTML($html);
            $ruta_pdf = 'docs/vectores/' . $vector->id_vector;
            if (!@mkdir($ruta_pdf, 0777, true) && !is_dir($ruta_pdf)) {
                $json['mensaje'] = 'No se puede guardar PDF de Respuesta para ser enviado';
                $json['estado'] = false;
                $data = array(
                    'cd_enviado_vector' => 0
                );
                $update = $this->_vectores_model->update($data, $params['id']);
            } else {
                $documento = $pdf->Output(FCPATH . 'docs/vectores/' . $vector->id_vector . '/respuesta_denuncia_' . $num_denuncia . '.pdf',
                    'F');

                $attachment = array(FCPATH . '/' . $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf');
                //$email = $this->mailer->load();
                if ($this->_sendmail->emailSend($to, null, null, $subject, $msg, false, $attachment)) {
                    $json['mensaje'] = 'El resultado ha sido guardado y se le ha enviado un correo a la persona con el aviso';
                    $data = array(
                        'gl_ruta_respuesta_vector' => $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_vectores_model->update($data, $params['id']);
                } else {
                    $data = array(
                        'cd_enviado_vector' => 0,
                        'gl_ruta_respuesta_vector' => $ruta_pdf . '/respuesta_denuncia_' . $num_denuncia . '.pdf'
                    );

                    $update = $this->_vectores_model->update($data, $params['id']);
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


    public function descargarComprobanteDenuncia()
    {

        $params = $this->uri->uri_to_assoc();

        $vector = $this->_vectores_model->getById($params['id']);

        $this->load->library('Fechas');

        $to = trim($vector->gl_email_vector);
        $subject = 'Denuncias - SEREMI de Salud Arica y Parinacota';
        $msg = '<h3 style="text-align:center">Comprobante de Denuncia</h3>';
        $msg .= 'Estimado/a ' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . ' <br/><br/>';
        $msg .= 'Ud. ha realizado una denuncia el día <strong>' . Fechas::formatearHtml($vector->fc_fecha_entrega_vector) .
            '</strong>, detallado como:<br/><br/>';

        if ($vector->id_vector < 10)
            $num_denuncia = '00' . $vector->id_vector;
        elseif ($vector->id_vector < 100)
            $num_denuncia = '0' . $vector->id_vector;
        else
            $num_denuncia = $vector->id_vector;

        $msg .= 'Número denuncia : <strong>' . $num_denuncia . '</strong><br/>';
        $msg .= 'Nombre : <strong>' . $vector->gl_nombres_vector . ' ' . $vector->gl_apellidos_vector . '</strong><br/>';
        $msg .= 'Rut/Pasaporte : <strong>' . $vector->gl_rut_vector . '</strong><br/>';
        $msg .= 'Dirección : <strong>' . $vector->gl_direccion_vector . ' , ' . $vector->gl_referencias_vector . '</strong><br/>';
        $msg .= 'Fecha de Hallazgo : <strong>' . Fechas::formatearHtml($vector->fc_fecha_hallazgo_vector) . '</strong><br/>';
        $msg .= 'Teléfono : <strong>' . $vector->gl_telefono_vector . '</strong><br/>';
        $msg .= 'Comentario : <strong>' . $vector->gl_comentario_ciudadano_vector . '</strong><br/>';
        $msg .= '<p>Atte.<br/>Seremi de Salud Arica y Parinacota</p>';
        $contenido = $msg;

        //$url_logo = file_get_contents(base_url('assets/img/logo_seremi15.jpg'));
        $url_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
        //$msg .= '<img src="data:image/jpg;base64,'.base64_encode($url_logo).'"/>';

        $this->load->library(
            array(
                "pdf"
            )
        );

        if ($vector->id_vector < 10)
            $num_denuncia = '00' . $vector->id_vector;
        elseif ($vector->id_vector < 100)
            $num_denuncia = '0' . $vector->id_vector;
        else
            $num_denuncia = $vector->id_vector;

        $datos = array(
            'contenido' => $contenido,
            'url_logo' => "data:image/jpg;base64," . base64_encode($url_logo)
        );
        $html = $this->load->view("pages/vectores/denuncias/pdf_comprobante", $datos, true);

        $pdf = $this->pdf->load();
        //$pdf->imagen_logo = file_get_contents(FCPATH . "assets/img/logo_seremi15.jpg");
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}/{nb}|' . date('d-m-Y'));
        $pdf->WriteHTML($html);
        $ruta_pdf = 'docs/vectores/' . $vector->id_vector;
        if (!@mkdir($ruta_pdf, 0777, true) && !is_dir($ruta_pdf)) {

        } else {
            $documento = $pdf->Output(
                'docs/vectores/' . $vector->id_vector . '/comprobante_denuncia_' . $num_denuncia . '.pdf', 'S');

            //$ruta = array(FCPATH . '/'.$ruta_pdf.'/comprobante_denuncia_'.$num_denuncia.'.pdf');
            //$ruta = array(FCPATH . '/'.$ruta_pdf.'/comprobante_denuncia_'.$num_denuncia.'.pdf');

            header('Content-type:application/pdf');
            header("Content-Disposition:attachment;filename=comprobante_denuncia_" . $num_denuncia . ".pdf");

            echo $documento;
            exit();


        }
    }


    public function adjuntarImagenesDenuncia($id = null)
    {

        $params = $this->uri->uri_to_assoc();


        $imagenes = $this->_vectores_model->getImagenesVector($params['id']);

        $this->load->library('Fechas');

        $arr_imagenes = array();
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imgdenuncia,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imgdenuncia),
                    'nombre' => $img->gl_nombre_imgdenuncia,
                    'sha' => $img->gl_sha_imgdenuncia,
                    'ruta' => $img->gl_ruta_imgdenuncia
                );
            }
        }

        $data = array(
            'id' => $params['id'],
            'imagenes' => $arr_imagenes
        );

        //$this->layout_assets->addJs("vectores/denuncias.js");
        $this->template->parse("default", 'pages/vectores/denuncias/upload_imagenes', $data);
        //$this->layout_template->view('default', 'pages/vectores/denuncias/upload_imagenes', $data);
    }


    public function subirImagenDenuncia()
    {

        $params = $this->input->post();
        $imagenes = $this->_vectores_model->getImagenesVector($params['id']);


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
            $dir = 'docs/vectores/' . $params['id'];

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $nombre = str_replace(' ', '_', $archivo['name']);

            if (move_uploaded_file($archivo['tmp_name'], $dir . '/' . $nombre)) {
                if (is_file($dir . '/' . $nombre)) {
                    $datos = array();
                    $datos['denuncia'] = $params['id'];
                    $datos['usuario'] = $this->session->userdata('session_idUsuario');
                    $datos['fecha'] = date('Y-m-d H:i:s');
                    $datos['ruta'] = $dir;
                    $datos['mime'] = $archivo['type'];
                    $datos['sha'] = sha1($nombre);
                    $datos['nombre'] = $nombre;

                    $insertar = $this->_vectores_model->insImagenVector($datos);
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

        $imagenes = $this->_vectores_model->getImagenesVector($params['id']);

        $this->load->library('Fechas');

        $arr_imagenes = array();    
        if ($imagenes) {
            foreach ($imagenes as $img) {
                $arr_imagenes[] = array(
                    'id' => $img->id_imgdenuncia,
                    'fecha' => Fechas::formatearHtml($img->fc_fecha_imgdenuncia),
                    'nombre' => $img->gl_nombre_imgdenuncia,
                    'sha' => $img->gl_sha_imgdenuncia,
                    'ruta' => $img->gl_ruta_imgdenuncia
                );
            }
        }

        $data['imagenes'] = $arr_imagenes;

        $this->template->parse("default", 'pages/vectores/denuncias/upload_imagenes', $data);
       // $this->layout_template->view('default', 'pages/vectores/upload_imagenes', $data);


    }


    public function verImagenDenuncia()
    {
        $params = $this->uri->uri_to_assoc();

        $imagen = $this->_vectores_model->getImagenVector($params['id'], $params['sha']);

        $this->load->library('Fechas');


        $data = array(
            'fecha' => Fechas::formatearHtml($imagen->fc_fecha_imgdenuncia),
            'ruta' => $imagen->gl_ruta_imgdenuncia,
            'nombre' => $imagen->gl_nombre_imgdenuncia,
            'sha' => $imagen->gl_sha_imgdenuncia,
            'id' => $imagen->id_imgdenuncia
        );

        if (isset($params['otra']) and $params['otra'] == true) {
            $data['boton'] = true;
        }

        echo $this->load->view('pages/vectores/denuncias/ver_imagen', $data, true);
    }


    public function eliminarImagen()
    {
        $params = $this->input->post();

        $imagen = $this->_vectores_model->getImagenVector($params['imagen']);

        $del = $this->_vectores_model->delImagenVector($params['imagen'], $params['denuncia']);
        $json = array();
        if ($del) {
            @unlink($imagen->gl_ruta_imgdenuncia . '/' . $imagen->gl_nombre_imgdenuncia);

            $json['estado'] = true;
            $json['mensaje'] = 'Imagen eliminada';
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al eliminar la imagen';
        }

        echo json_encode($json);
    }


    public function excel()
    {

        $this->load->library("excel");
        $this->load->library("Fechas");

        $lista = $this->_vectores_model->listar();

        $datos_excel = array();
        if (!is_null($lista)) {
            foreach ($lista as $caso) {
                $estado = '';
                if ($caso['cd_estado_vector'] == 0 and $caso['cd_enviado_vector'] == 0):
                    $estado = 'Ingresado';
                elseif ($caso['cd_estado_vector'] > 0 and $caso['cd_enviado_vector'] == 0):
                    $estado = 'Revisado -  Respondido';
                elseif ($caso['cd_estado_vector'] > 0 and $caso['cd_enviado_vector'] == 1):
                    $estado = 'Enviado';
                endif;

                $resultado = '';
                if ($caso['cd_estado_vector'] == 0):
                    $resultado = 'En Revisión';
                elseif ($caso['cd_estado_vector'] == 1):
                    $resultado = 'Positivo';
                elseif ($caso['cd_estado_vector'] == 2):
                    $resultado = 'Negativo';
                elseif ($caso['cd_estado_vector'] == 3):
                    $resultado = 'No concluyente';
                endif;

                $estadio_desarrollo = '';
                if ($caso['cd_estado_desarrollo_vector'] == 1)
                    $estadio_desarrollo = 'Larva';
                elseif ($caso['cd_estado_desarrollo_vector'] == 2)
                    $estadio_desarrollo = 'Pupa';
                elseif ($caso['cd_estado_desarrollo_vector'] == 3)
                    $estadio_desarrollo = 'Adulto';


                $datos_excel[] = array(
                    'codigo' => 'D-' . $caso['id_vector'],
                    'fecha_registro' => Fechas::formatearHtml($caso['fc_fecha_registro_vector']),
                    'nombre' => $caso['gl_nombres_vector'] . ' ' . $caso['gl_apellidos_vector'],
                    'rut' => $caso['gl_run_vector'],
                    'direccion' => $caso['gl_direccion_vector'] . ' ' . $caso['gl_referencias_vector'],
                    'latitud' => $caso['cd_latitud_vector'],
                    'longitud' => $caso['cd_longitud_vector'],
                    'telefono' => $caso['gl_telefono_vector'],
                    'email' => $caso['gl_email_vector'],
                    'fecha_hallazgo' => Fechas::formatearHtml($caso['fc_fecha_hallazgo_vector']),
                    'fecha_entrega' => Fechas::formatearHtml($caso['fc_fecha_entrega_vector']),
                    'estado' => $estado,
                    'resultado' => $resultado,
                    'estadio_desarrollo' => $estadio_desarrollo,
                    'observaciones' => $caso['gl_observaciones_resultado_vector']
                );

                /*$datos_excel[count($datos_excel)-1]["id_estado"]  = $caso["id_estado"];*/
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


            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, "DENUNCIA");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, "FECHA REGISTRO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, "NOMBRE");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, 1, "RUT/PASAPORTE");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, 1, "DIRECCION");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, 1, "LATITUD");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, 1, "LONGITUD");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, 1, "TELEFONO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 1, "EMAIL");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, 1, "FECHA HALLAZGO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, 1, "FECHA ENTREGA");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, 1, "ESTADO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 1, "RESULTADO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 1, "ESTADIÓ DESARROLLO");
            $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 1, "OBSERVACIONES");

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
            header('Content-Disposition: attachment;filename="vectores_denuncias_' . date('d-m-Y') . '.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            echo "No hay registros para generar el excel";
        }
    }


    public function cambiarCoordenadas()
    {
        $params = $this->input->post();

        $data = array(
            'cd_longitud_vector' => $params['lon'],
            'cd_latitud_vector' => $params['lat']
        );

        $json = array();
        if ($this->_vectores_model->update($data, $params['id'])) {
            $json['mensaje'] = 'Coordenadas actualizadas';
            $json['estado'] = true;
        } else {
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al cambiar las coordenadas. Intente nuevamente';
        }

        echo json_encode($json);
    }

}