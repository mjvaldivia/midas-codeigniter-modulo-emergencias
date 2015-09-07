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
        $("#tblAlarmas").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            }
        });
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iEstadoAlarma").jCombo(siteUrl + "alarma/jsonEstadosAlarmas");
        $("#btnBuscarAlarmas").click(this.eventoBtnBuscar);
    },

    eventoBtnBuscar: function() {
        $("#pResultados").slideUp("slow");

        var url = siteUrl + "alarmas/buscar";

        $.get(url).done(function() {
            $("#pResultados").slideDown("slow");
        });
    }
    ,
    guardarAlarma: function() {
        var params = $( "#form_alarma" ).serialize();
        console.log(params);
        //$.post(siteUrl+"alarma/guardar/", params, function (data) {
        //});
        
    }
};