/**
 * Created by claudio on 14-08-15.
 */
var Alarma = {};

(function() {
    this.inicioIngreso = function() {
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

        $('#iTiposEmergencias').change(function(){
            if($('#iTiposEmergencias').val()==15){
                $('#btnSiguiente').html('Siguiente Paso');
            }
            else{
                $('#btnSiguiente').html('Aceptar');
            }
            
        });


    };



    this.inicioListado = function() {
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iEstadoAlarma").jCombo(siteUrl + "alarma/jsonEstadosAlarmas");
        $("#btnBuscarAlarmas").click(this.eventoBtnBuscar);
        $(window).resize(function() {
            $("table").css("width", "100%");
        });
    };

    this.eventoBtnBuscar = function() {

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
                html += "    <div class=\"col-md-2 text-center\"><img src=\"" + baseUrl + "assets/img/incendio_ico.png\"/></div>";
                html += "    <div class=\"col-md-8\">";
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
                html += "           <a title=\"Generar emergencia\" class=\"btn btn-default\" onclick=Alarma.generaEmergencia("+row.ala_ia_id+"); >";
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
    },
    this.guardarForm = function() {
        if(!Utils.validaForm('frmIngresoAlarma'))
        return false ;
        
        var params = $('#frmIngresoAlarma').serialize(); 
        $.post(siteUrl+"alarma/guardaAlarma", params, function(data) {
            //console.log(data);
            if(data > 0){
            bootbox.dialog({
                title: "Resultado de la operacion",
                message: 'Se ha insertado correctamente',
                buttons: {
                    danger: {
                        label: "Cerrar",
                        className: "btn-info",
                        callback: function(){
                            var tip_ia_id = $('#iTiposEmergencias').val();
                            if(tip_ia_id==15){  
                                location.href=siteUrl+'alarma/paso2/id/'+data+'/tip_ia_id/'+tip_ia_id;
                            }else{
                                Alarma.limpiar();
                            }
                        }
                    }
                }
            });
            
            
            }
            else{
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
    },
    this.generaEmergencia = function(ala_ia_id) {
        window.open(siteUrl+'emergencia/generaEmergencia/id/'+ala_ia_id , '_blank');
    },
    this.limpiar = function(){
        $('#frmIngresoAlarma')[0].reset(); 
        $('#iComunas').picklist('destroy');
        $('#iComunas').picklist();
    }
    ;
    
    
}).apply(Alarma);
