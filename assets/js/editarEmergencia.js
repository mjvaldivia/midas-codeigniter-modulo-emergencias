var EmergenciaEditar = {};

(function () {
    this.inicio = function () {

        var eme_ia_id = $("#eme_ia_id").val();
        console.log(eme_ia_id);
        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function () {


                $.getJSON(siteUrl + 'emergencia/getEmergencia/id/' + eme_ia_id, function (data) {

                    var str_comunas = data.comunas;
                    if (str_comunas !== null) {
                        var arr_com = str_comunas.split(",");
                        
                        $('#iComunas').picklist({
                            'value': arr_com
                        });
                    }
                    else {
                        $('#iComunas').picklist();
                    }
                    $('#eme_ia_id').val(data.eme_ia_id);
                    $('#ala_ia_id').val(data.ala_ia_id);
                    $('#iNombreInformante').val(data.eme_c_nombre_informante);
                    $('#iTelefonoInformante').val(data.eme_c_telefono_informante);
                    $('#iNombreEmergencia').val(data.eme_c_nombre_emergencia);
                    $('#iTiposEmergencias').val(data.tip_ia_id);
                    $('#iLugarEmergencia').val(data.eme_c_lugar_emergencia);
                    $('#fechaEmergencia').val(data.eme_d_fecha_emergencia);
                    $('#usuarioRecepciona').val(data.usuario);
                    $('#fechaRecepcion').val(data.eme_d_fecha_recepcion);
                    $('#iObservacion').val(data.eme_c_observacion);
                    EmergenciaEditar.dibujaTablaDocs();
                    EmergenciaEditar.iniciarUpload();
                });
            },
            initial_text: null
        });

        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });


        $('#iDocMaterial').on('filebatchuploadcomplete', function () {
            EmergenciaEditar.dibujaTablaDocs();
        });

    };

    this.inicioListado = function () {
        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");

        $("#btnBuscar").click(this.eventoBtnBuscar);
        $(window).resize(function () {
            $("table").css("width", "100%");
        });
    };

    this.eventoBtnBuscar = function () {

        var url = siteUrl + "emergencia/jsonEmergenciasDT";

        var anio = $("#iAnio").val();
        var tipoEmergencia = $("#iTiposEmergencias").val();

        if (parseInt(anio)) {
            url += "/anio/" + anio;
        }

        if (parseInt(tipoEmergencia)) {
            url += "/tipoEmergencia/" + tipoEmergencia;
        }

        var tabla = $('#tblEmergencias').DataTable();
        tabla.destroy();
        $('#tblEmergencias').empty();

        $.get(url).done(function (retorno) {
            var json = JSON.parse(retorno);

            json.columns[0]["mRender"] = function (data, type, row) {
                var html = "";
                html += "<div class=\"col-md-12 shadow\" style=\"padding: 10px;\">";
                html += "    <div class=\"col-md-2 text-center\"><img src=\"" + baseUrl + "assets/img/quimico_ico.png\"/></div>";
                html += "    <div class=\"col-md-8\">";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Fecha de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.eme_d_fecha_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Nombre de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.eme_c_nombre_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Tipo de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.eme_c_tipo_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Lugar de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.eme_c_lugar_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "    </div>";
                html += "    <div class=\"col-md-2 text-center\">";
                html += "       <div class=\"btn-group\">";
                html += "           <a title=\"Editar\" class=\"btn btn-default\" onclick=EmergenciaEditar.editarEmergencia(" + row.eme_ia_id + ");>";
                html += "               <i class=\"fa fa-pencil\"></i>";
                html += "           </a>";
                html += "           <a title=\"Eliminar\" class=\"btn btn-default\">";
                html += "               <i class=\"fa fa-trash\"></i>";
                html += "           </a>";
                html += "       </div>";
                html += "    </div>";
                html += "</div>";

                return html;
            };

            $("#tblEmergencias").DataTable({
                data: json.data,
                columns: json.columns,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]]
            });
            $("#pResultados").css("visibility", "visible");
            $("#pResultados").slideDown("slow");
        });
    };

    this.guardarForm = function (btn) {
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');
        if (!Utils.validaForm('frmEditarEmergencia'))
            return false;

        var params = $('#frmEditarEmergencia').serialize();

        $.post(siteUrl + "emergencia/editarEmergencia", params, function (data) {
            if (data == 1) {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha editado correctamente',

                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info",
                            callback: function () {
                                $(btn).attr('disabled',false).html(btnText);
                                location.reload();
                            }
                        }
                    }

                });
            }
            else {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Error al editar',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger",
                            callback : function(){
                                $(btn).attr('disabled',false).html(btnText);
                            }
                        }
                    }
                });
            }
        });
    };

    this.limpiar = function () {
        $('#frmEditarEmergencia')[0].reset();
        $('#iComunas').picklist('destroy');
        $('#iComunas').picklist();
    };

    this.iniciarUpload = function () {
        var ala_ia_id = $('#ala_ia_id').val();
        $("#iDocMaterial").fileinput({
            language: "es",
            uploadUrl: siteUrl + "archivo/subir/tipo/5/id/" + ala_ia_id,
            uploadAsync: true,
            multiple: true,
            initialCaption: "Seleccione archivos y luego presione subir",
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object']
        });
    };

    this.dibujaTablaDocs = function () {
        
        
        var ala_ia_id = $('#ala_ia_id').val();
        $("#tabla_doc").dataTable().fnDestroy();
        $('#tabla_doc').dataTable({
            ajax: {
                url: siteUrl + 'archivo/getDocs/id/' + ala_ia_id + '/tipo/5',
                type: 'POST',
                async: true
            },
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
             "aoColumns": [
                null,
                null,
                null,
                {"sClass": "text-center"}
            ]
        });
        $("#tabla_doc").wrap("<div class='col-sm-12' style='padding-left:0px !important;'></div>");
    };

    

}).apply(EmergenciaEditar);

