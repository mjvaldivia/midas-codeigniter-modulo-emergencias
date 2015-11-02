var Alarma = {};

(function () {
    
    this.inicioIngreso = function () {

        $("#iComunas").picklist();

        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY HH:mm"
        });

    };
