/**
 * Control de formulario para cerrar emergencia
 */

var FormEmergenciasCerrar = Class({
    
    // Se declara la propiedad id, que es el identificador de la emergencia
    id : null,

    // Funcion que se ejecuta al instanciar
    __construct : function(value) {
        this.id = value;
    },
    
    //funcion de retorno al guardar formulario
    callBack : function(){
        $("#btnBuscar").trigger("click");
    },

    //guarda el formulario de cierre
    guardaFormulario : function(){
        
        var yo = this;
        
        var parametros = $("#form-cerrar").serializeArray();
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/cerrarEmergencia", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.callBack();
                    salida = true;
                } else {
                    $("#form-cerrar-error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    // Despliega el formulario
    mostrarFormulario : function(){
        
        var yo = this;

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "emergencia/formCerrar/id/" + this.id, 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                bootbox.dialog({
                    message: html,
                    title: "Finalizar emergencia",
                    buttons: {
                        guardar: {
                            label: " Aceptar",
                            className: "btn-default fa fa-check",
                            callback: function() {
                                return yo.guardaFormulario();
                            }
                        },
                        cerrar: {
                            label: " Cancelar",
                            className: "btn-primary fa fa-close",
                            callback: function() {

                            }
                        }
                    }
                });
            }
        }); 
    }
});


