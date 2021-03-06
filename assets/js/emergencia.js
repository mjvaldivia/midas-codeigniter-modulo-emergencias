var content;

$(document).ready(function() {
    $("#btnCancelar").livequery(function(){
       $(this).click(function(){
           Emergencia.cancelarEdicion();
       });
    });
});


var Emergencia = {};

(function () {
    this.inicioIngreso = function () {

        var ala_ia_id = $("#ala_ia_id").val();

        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function () {


                $.getJSON(siteUrl + 'emergencia/getAlarma/id/' + ala_ia_id, function (data) {
                    var str_comunas = data.comunas;

                    if (str_comunas !== null) {
                        var arr_com = str_comunas.split(",");
                        
                        $('#iComunas').picklist({
                            'value': arr_com
                        });
                    } else {
                        $('#iComunas').picklist();
                    }

                    $('#iNombreInformante').val(data.ala_c_nombre_informante);
                    $('#iTelefonoInformante').val(data.ala_c_telefono_informante);
                    $('#iNombreEmergencia').val(data.ala_c_nombre_emergencia);
                    $('#iTiposEmergencias').val(data.tip_ia_id);
                    $('#iLugarEmergencia').val(data.ala_c_lugar_emergencia);
                    $('#fechaEmergencia').val(data.ala_d_fecha_emergencia);
                    $('#usuarioRecepciona').val(data.usuario);
                    $('#fechaRecepcion').val(data.ala_d_fecha_recepcion);
                    $('#iObservacion').val(data.ala_c_observacion);

                });
            },
            initial_text: null
        });

        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });
        
    };


    this.inicioListado = function () {
        
        var yo = this;
        
        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");

        /*$("#btnBuscar").click(this.eventoBtnBuscar);*/
        /*this.eventoBtnBuscar();*/
        $(window).resize(function () {
            $("table").css("width", "100%");
        });
        
        $.getScript(baseUrl + "assets/js/modulo/general/permisos.js", function(){
            yo.eventoBtnBuscar();
        });
        
        
    };
    
    this.eventoBtnBuscar = function () {
        var btnText = $("#btnBuscar").html();
        $("#btnBuscar").attr('disabled',true).html('Buscando... <i class="fa fa-spin fa-spinner"></i>');
        var url = siteUrl + "emergencia/jsonEmergenciasDT";

        var anio = $("#iAnio").val();
        var tipoEmergencia = $("#iTiposEmergencias").val();
        var estadoEmergencia = $("#iEstadoEmergencias").val();

        if (parseInt(anio)) {
            url += "/anio/" + anio;
        }

        if (parseInt(tipoEmergencia)) {
            url += "/tipoEmergencia/" + tipoEmergencia;
        }
        
        if(parseInt(estadoEmergencia)){
            url += "/estado_emergencia/" + estadoEmergencia;
        }

        var tabla = $('#tblEmergencias').DataTable();
        tabla.destroy();
        $('#tblEmergencias').empty();

        var permisos = new Permisos("emergencia");	
        
        
        $.ajax({
            format: "json",
            cache: false,
            url: url,
            data: '',
            success: function (retorno) {

            var json = JSON.parse(retorno);

            json.columns[0]["mRender"] = function (data, type, row) {
                var icon = '';
                //console.log(row);
                switch (parseInt(row.tip_ia_id)) {
                    case 1:
                    case 2:
                        icon = '<i class=\"glyphicon glyphicon-fire icono\"></i>';
                        break;
                    case 3:
                        icon = '<i class=\"fa fa-4x fa-flask icono\"></i>';
                        break;
                    case 4:
                        icon = '<i class=\"fa fa-4x fa-cloud icono\"></i>';
                        break;
                    case 5:
                        icon = '<i class=\"fa fa-4x fa-bullseye icono\"></i>';
                        break;
                    case 6:
                        icon = '<i class=\"fa fa-4x fa-life-ring icono\"></i>';
                        break;
                    case 7:
                        icon = '<i class=\"fa fa-4x fa-globe icono\"></i>';
                        break;
                    case 8:
                        icon = '<i class=\"glyphicon glyphicon-tint icono\"></i>';
                        break;
                    case 9:
                    case 10:
                        icon = '<i class=\"fa fa-4x fa-medkit icono\"></i>';
                        break;
                    case 11:
                        icon = '<i class=\"fa fa-4x fa-bomb icono\"></i>';
                        break;
                    case 12:
                    case 13:
                        icon = '<i class=\"fa fa-4x fa-user-md icono\"></i>';
                        break;
                    case 15:
                        icon = '<i class=\"fa fa-4x fa-bolt icono\"></i>';
                        break;
                    case 14:
                        icon = '<i class=\"fa fa-4x fa-bullhorn icono\"></i>';
                        break;
                }

                var html = "";
                html += "<div class=\"col-md-12 shadow\" style=\"padding: 10px;\">";
                html += "    <div class=\"col-md-2 text-center\">" + icon + "</div>";
                html += "    <div class=\"col-md-7\">";
                html += "        <div class=\"form-group col-md-12\">";
                html += "           <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Fecha:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                " + row.eme_d_fecha_emergencia + "";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Nombre:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                " + row.eme_c_nombre_emergencia + "";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Tipo:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                " + row.eme_c_tipo_emergencia + "";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Lugar:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                " + row.eme_c_lugar_emergencia + "";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Comunas(s):</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                " + row.comunas + "";
                html += "            </div>";
                html += "        </div>";
                html += "    </div>";
                html += "    <div class=\"col-md-3 text-center\">";
                html += "       <div class=\"btn-group\">";
                
                
          
                    html += "     <a class='btn btn-primary emergencia-reporte' onclick=\"Emergencia.reporte(" + row.eme_ia_id + ");\" ><i class='fa fa-fa2x fa-file-text-o'></i></a>";
                
//                html += "           <a title=\"Reporte\" class=\"btn btn-default\" onclick=Emergencia.openIframe(" + row.eme_ia_id + "); >";
               // html += "               <i class=\"fa fa-fa2x fa-file-text-o\"></i>";
               // html += "           </a>";
                html += "           <a data-toggle=\"tooltip\" data-toogle-param=\"arriba\" title=\"Visor\" class=\"btn btn-primary\" href='" + siteUrl + "mapa/index/id/" + row.eme_ia_id + "' target='_blank'>";
                html += "               <i class=\"fa fa-fa2x fa-globe\"></i>";
                html += "           </a>";
                
                if(row.est_ia_id != 2){
                    
                    if(permisos.getFinalizaremergencia()){
                        html += "           <a data-toggle=\"tooltip\" data-toogle-param=\"arriba\" title=\"Cerrar emergencia\" class=\"btn btn-primary\" onclick=\"Emergencia.cerrar(" + row.eme_ia_id + ");\">";
                        html += "               <i class=\"fa fa-fa2x fa-check\"></i>";
                        html += "           </a>";
                    }
                    
                    if(permisos.getEditar()){
                        html += "           <a data-toggle=\"tooltip\" data-toogle-param=\"arriba\" title=\"Editar\" class=\"btn btn-primary\" onclick=\"Emergencia.editarEmergencia(" + row.eme_ia_id + ");\">";
                        html += "               <i class=\"fa fa-fa2x fa-pencil\"></i>";
                        html += "           </a>";
                    } 
                    
                    if(permisos.getEliminar()){
                        html += "           <a data-toggle=\"tooltip\" data-toogle-param=\"arriba\" title=\"Eliminar\" class=\"btn btn-primary\" onclick=\"Emergencia.eliminarEmergencia(" + row.eme_ia_id + ");\">";
                        html += "               <i class=\"fa fa-fa2x fa-trash\"></i>";
                        html += "           </a>";
                    }
                }

                html += "     <a class='btn btn-primary' onclick=\"xModal.open('" + siteUrl + "alarma/expediente/id/"+row.ala_ia_id + "', 'Expediente Alarma/Emergencia',75);\" title='Expediente' ><i class='fa fa-fa2x fa-files-o'></i></a>";
                
                html += "       </div>";
                html += "    </div>";
                html += "</div>";

                return html;
            };

            $("#tblEmergencias").DataTable({
                data: json.data,
                columns: json.columns,
                language: {
                    url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]]
            });
            $("#pResultados").css("visibility", "visible");
            $("#pResultados").slideDown("slow");
            $("#btnBuscar").attr('disabled',false).html(btnText);
        }
    });
    };
    this.openIframe = function(id){

    var i = document.createElement('iframe');
    i.style.display = 'block';
    i.id= id;
    i.width = 0;
    i.heigth = 0;
    i.src = siteUrl+'visor/loadExportMap/id/'+id;
    document.body.appendChild(i);

    };
     this.closeIframe = function(id) {
        var iframe = document.getElementById(id);
        iframe.parentNode.removeChild(iframe);
    };
    this.cargando = function(){$('.cargando').fadeToggle('slow');};
    this.guardarForm = function () {
        if (!Utils.validaForm('frmIngresoEmergencia'))
            return false;

        var params = $('#frmIngresoEmergencia').serialize();
        $.post(siteUrl + "emergencia/ingreso", params, function (data) {
            var response = jQuery.parseJSON(data);
            if (response.eme_ia_id > 0) {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha insertado correctamente<br>' +
                            'Estado email: ' + response.res_mail
                    ,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info",
                            callback: function () {
                                location.reload();
                            }
                        }
                    }

                });
            } else {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Error al insertar',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
            }
        });
    };

    this.rechazar = function () {

        var params = 'eme_ia_id=' + $('#eme_ia_id').val();
        $.post(siteUrl + "emergencia/rechaza", params, function (data) {
            if (data == 1) {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha rechazado correctamente',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info",
                            callback: function () {
                                location.reload();
                            }
                        }
                    }

                });
            } else {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Error al rechazar',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
            }
        });
    };
    
    this.cerrar = function(id){
        var formulario = new FormEmergenciasCerrar(id);	
        formulario.mostrarFormulario();
    };
    
    this.editarEmergencia = function (id) {
        var formulario = new FormEmergenciasEditar(id);
        formulario.mostrarFormulario();
    };
    
    this.eliminarEmergencia = function (eme_ia_id) {
        bootbox.dialog({
            title: "Eliminar elemento",
            message: '¿Está seguro que desea eliminar esta emergencia?',
            buttons: {
                success: {
                    label: "Aceptar",
                    className: "btn-primary",
                    callback: function () {
                        $.get(siteUrl + 'emergencia/eliminarEmergencia/id/' + eme_ia_id).done(function (retorno) {
                            if (retorno == 0) { // sin error
                                bootbox.dialog({
                                    title: "Resultado de la operacion",
                                    message: 'Se eliminó correctamente',
                                    buttons: {
                                        danger: {
                                            label: "Cerrar",
                                            className: "btn-info",
                                            callback: function () {
                                                Emergencia.eventoBtnBuscar();
                                            }
                                        }
                                    }
                                });
                            } else {
                                bootbox.dialog({
                                    title: "Resultado de la operacion",
                                    message: 'Error al eliminar',
                                    buttons: {
                                        danger: {
                                            label: "Cerrar",
                                            className: "btn-danger"
                                        }
                                    }
                                });
                            }




                        });

                    }
                },
                danger: {
                    label: "Cancelar",
                    className: "btn-default"
                }
            }

        });
    };

    this.cancelarEdicion = function(){
        $("#contenedor-emergencia").fadeOut(function(){
            $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
                $(this).html(content);
                Emergencia.inicioListado();
            });
        });
    };
    
    this.reporte = function(id){
        var reporte = new EmergenciaReporteForm();
        reporte.seteaEmergencia(id);
        reporte.mostrar();
    };

    this.borrarAdjunto = function(adjunto,item){
        bootbox.confirm("Desea eliminar este adjunto?",function(result){
            if(result === true){
                $.post(siteUrl + "emergencia/borrarAdjuntoEmergencia",{adjunto:adjunto},function(response){
                    if(response.estado == true){
                        bootbox.alert(response.mensaje,function(){
                            $(item).parent().fadeOut(function(){
                                $(this).remove();
                            });
                        });

                    }else{
                        bootbox.alert(response.mensaje);
                    }
                },'json');
            }
        });
    };

    this.finalizar = function(id){
        xModal.confirm('Desea Finalizar este Evento?',function(){
            xModal.open(siteUrl + 'emergencia/comentarioCierreEmergencia/id/'+id,'Finalizar Evento en Emergencia');
        })
    };


    this.finalizarEvento = function(form,btn){
        btn.disabled = true;
        var btnText = $(btn).html();
        $(btn).html('Finalizando...<i class="fa fa-spin fa-spinner"></i>');

        if(form.comentarios_cierre.value == ""){
            xModal.danger('No puede ingresar comentario vacío',function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var formulario = $(form).serialize();
            $.post(siteUrl + 'emergencia/finalizarEmergencia',{data:formulario},function(response){
                if(response.estado == true){
                    xModal.close();
                    xModal.success(response.mensaje,function(){
                        location.reload();
                    });
                }else{
                    xModal.danger(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            },'json').fail(function(){
                xModal.danger('Error en Sistema. Intente nuevamente o comuníquese con Soporte',function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            });
        }
    }



    


}).apply(Emergencia);
