var MantenedorUsuarios = Class({
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        var yo = this;
        
        this.loadGridUsuario();
        
        $("#region").livequery(function(){
            $(this).change(function(){
                    $.ajax({         
                    dataType: "json",
                    cache: false,
                    async: true,
                    data: "",
                    type: "post",
                    url: siteUrl + "oficina/rest/region/" + $(this).val(), 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(json){
                        
                        $("#oficinas").html("");
                        
                        $.each(json, function(i, oficina){
                           $("#oficinas").append("<option value=\"" + oficina.ofi_ia_id + "\">" + oficina.ofi_c_nombre + "</option>"); 
                        });
                        
                        $("#oficinas").val("");
                        
                        $("#oficinas").trigger("change");
                    }
                }); 
            });
        });
        
        $("#btn-buscar").click(function(){
            yo.loadGridUsuario();
        });
        
        $("#nueva").click(function(){
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mantenedor_usuario/form", 
                error: function(xhr, textStatus, errorThrown){},
                success:function(html){
                    bootbox.dialog({
                        message: html,
                        className: "modal90",
                        title: "Nuevo usuario",
                        buttons: {
                            guardar: {
                                label: " Guardar",
                                className: "btn-success fa fa-check",
                                callback: function() {
                                    return yo.guardar();
                                }
                            },
                            cerrar: {
                                label: " Cancelar",
                                className: "btn-white fa fa-close",
                                callback: function() {

                                }
                            }
                        }
                    });
                }
            }); 
            
            
        });
        
        $(".editar").livequery(function(){
           $(this).unbind("click");
           $(this).click(function(){
               var id = $(this).attr("data");
               $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: "id=" + id,
                    type: "post",
                    url: siteUrl + "mantenedor_usuario/form", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(html){
                        bootbox.dialog({
                            message: html,
                            className: "modal90",
                            title: "Editar usuario",
                            buttons: {
                                guardar: {
                                    label: " Guardar",
                                    className: "btn-success fa fa-check",
                                    callback: function() {
                                        return yo.guardar();
                                    }
                                },
                                cerrar: {
                                    label: " Cancelar",
                                    className: "btn-white fa fa-close",
                                    callback: function() {

                                    }
                                }
                            }
                        });
                    }
                }); 
           });
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    callBackGuardar : function(){
        this.loadGridUsuario();
    },
    
    /**
     * 
     * @returns {Boolean}
     */
    guardar : function(){
        var yo = this;
        
        var parametros = $("#form-usuario").serializeArray();

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mantenedor_usuario/save", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.callBackGuardar();
                    salida = true;
                } else {
                    $("#form_nueva_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    /**
     * Carga la grilla de alarmas
     * @returns void
     */
    loadGridUsuario : function(){
        $("#grilla-usuarios-loading").removeClass("hidden");
        $("#grilla-usuarios").addClass("hidden");
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: $("#busqueda").serializeArray(),
            type: "post",
            url: siteUrl + "mantenedor_usuario/ajax_grilla", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(html){
                $("#grilla-usuarios").html(html);
                $("#grilla-usuarios").removeClass("hidden");
                $("#grilla-usuarios-loading").addClass("hidden");
            }
        });
    }
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var listado = new MantenedorUsuarios();	
});

