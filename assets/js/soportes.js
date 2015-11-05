var Soportes = {};

(function() {

    this.init = function(){
        var tablaSoportes = $("#tabla_soportes").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            order: [[0, "desc"]]
        });
    },


    this.nuevoSoporte = function() {
        /*$("#modal_nuevo_soporte").load();*/
        $("#modal_nuevo_soporte").modal({backdrop: 'static',keyboard: false});
        

    },


    this.enviarSoporte = function(form,btn) {
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Enviando...<i class="fa fa-spin fa-spinner"></i>');

        var error = '';
        if(form.asunto_soporte.value == ""){
            error = '- Debe ingresar el asunto del ticket<br/>';
        }
        if(form.texto_soporte.value == ""){
            error = '- Debe ingresar el texto del ticket<br/>';
        }

        if(error != ""){
            
        }else{
            var formulario = $(form).serialize();
            
        }
    }

}).apply(Soportes);