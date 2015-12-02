var AlarmaListado = Class({
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        this.loadGridAlarma();
        this.bindBtnEmergenciaNueva();
        this.bindBtnAlarmaEliminar();
        this.bindBtnEditarAlarma();
        this.bindBtnBuscar();
        this.bindBtnNuevaAlarma();
        
        var url = $(location).attr('href');
        var nuevo = url.indexOf("tab/nuevo");
        console.log(nuevo);
        if(nuevo != -1){
            $("#nueva").trigger("click");
        }
    },
    
    
    bindBtnNuevaAlarma : function(){
        var yo = this;
        
        $("#nueva").click(function(e){
            e.preventDefault();
            var id = $(this).attr("data");
            var formulario = new FormAlarma(id, yo);	
            formulario.mostrarFormulario();
        });
        
    },
    
    bindBtnBuscar : function(){
        var yo = this;
        $("#btnBuscarAlarmas").click(function(){
            yo.loadGridAlarma();
        });
    },
    
    /**
     * Asocia el evento para desplegar formulario para ingresar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEditarAlarma : function(){
        var yo = this;
        
        $(".editar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                var formulario = new FormAlarmasEditar(id, yo);	
                formulario.mostrarFormulario();
            });
        });
        
    },
    
    /**
     * Asocia el evento para desplegar formulario para ingresar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEmergenciaNueva : function(){
        var yo = this;
        
        $(".emergencia-nueva").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                var formulario = new FormEmergenciasNueva(id, yo);	
                formulario.mostrarFormulario();
            });
        });
        
    },
    
    bindBtnAlarmaEliminar : function(){
        var yo = this;
        $(".alarma-eliminar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Eliminar elemento",
                    message: '¿Está seguro que desea eliminar esta alarma?',
                    buttons: {
                        success: {
                            label: "Aceptar",
                            className: "btn-primary",
                            callback: function () {
                                $.get(siteUrl + 'alarma/eliminarAlarma/id/' + id).done(function (retorno) {
                                    if (retorno == 0) { // sin error
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Se eliminó correctamente',
                                            buttons: {
                                                danger: {
                                                    label: "Cerrar",
                                                    className: "btn-info",
                                                    callback: function () {
                                                        yo.loadGridAlarma();
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
                });
        });
    },
    
    /**
     * Carga la grilla de alarmas
     * @returns void
     */
    loadGridAlarma : function(){
        $("#grilla-alarma-loading").removeClass("hidden");
        $("#grilla-alarma").addClass("hidden");
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: $("#busqueda").serializeArray(),
            type: "post",
            url: siteUrl + "alarma/ajax_grilla_alarmas", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#grilla-alarma").html(html);
                $("#grilla-alarma").removeClass("hidden");
                $("#grilla-alarma-loading").addClass("hidden");
            }
        });
    },
    
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var listado = new AlarmaListado();	
});

