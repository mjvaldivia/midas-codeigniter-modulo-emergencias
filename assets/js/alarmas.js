/**
 * Created by claudio on 14-08-15.
 */
var Alarma = {
    inicioIngreso: function() {
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function() {
                $("#iComunas").picklist();
            },
            initial_text: null
        });

        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });
    },

    inicioListado: function() {
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iEstadoAlarma").jCombo(siteUrl + "alarma/jsonEstadosAlarmas");
        $("#btnBuscarAlarmas").click(this.eventoBtnBuscar);
        $(window).resize(function() {
            $("table").css("width", "100%");
        });
    },

    eventoBtnBuscar: function() {

        var url = siteUrl + "alarma/jsonAlarmasDT";

        var anio = $("#iAnio").val();
        var tipoEmergencia = $("#iTiposEmergencias").val();
        var estado = $("#iEstadoAlarma").val();

        if (parseInt(anio)) {
            url += "/anio/" + anio;
        }

        if (parseInt(tipoEmergencia)) {
            url += "/tipoEmergencia/" + tipoEmergencia;
        }

        if (parseInt(estado)) {
            url += "/estado/" + estado;
        }

        var tabla = $('#tblAlarmas').DataTable();
        tabla.destroy();
        $('#tblAlarmas').empty();

        $.get(url).done(function(retorno) {
            var json = JSON.parse(retorno);
            
            json.columns[0]["mRender"] = function(data, type, row) {
                var html = "";
                html += "<div class=\"col-md-12 shadow\" style=\"padding: 10px;\">";
                html += "    <div class=\"col-md-1 text-center\"><i class=\"fa fa-bell fa-4x\"></i></div>";
                html += "    <div class=\"col-md-9\">";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Fecha de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_d_fecha_emergencia + "</p>";;
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Nombre de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_nombre_emergencia + "</p>";;
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Tipo de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_tipo_emergencia + "</p>";;
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Lugar de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_lugar_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "    </div>";
                html += "    <div class=\"col-md-2 text-center\">";
                html += "       <div class=\"btn-group\">";
                html += "           <a title=\"Generar emergencia\" class=\"btn btn-default\">";
                html += "               <i class=\"fa fa-exclamation-triangle\"></i>";
                html += "            </a>";
                html += "           <a title=\"Editar\" class=\"btn btn-default\">";
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
            
            $("#tblAlarmas").DataTable({
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
    }
};