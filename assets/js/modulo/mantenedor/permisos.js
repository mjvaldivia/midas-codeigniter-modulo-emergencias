var MantenedorPermisos = Class({
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        this.loadGridRoles();
        this.bindButtonEditarPermiso();
        this.bindButtonNuevoRol();
        this.bindButtonEditarRol();
        this.bindButtonEliminarRol();
        this.bindButtonUsuarios();
    },
    
    /**
     * Elimina un rol
     * @param {int} id
     * @returns {Boolean}
     */
    eliminarRol : function(id){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id,
            type: "post",
            url: siteUrl + "mantenedor_rol/eliminar_rol", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                yo.callBackGuardar();
            }
        }); 
        
        return true;
    },
    
    /**
     * Accion para boton eliminar rol
     * @returns {undefined}
     */
    bindButtonEliminarRol : function(){
        var yo = this;
        $(".eliminar-rol").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Eliminar rol",
                    message: '¿Está seguro que desea eliminar este Rol?',
                    buttons: {
                        success: {
                            label: "Aceptar",
                            className: "btn-primary",
                            callback: function () {
                                yo.eliminarRol(id);
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
     * 
     * @returns {undefined}
     */
    callBackEditarPermiso : function(){
        var yo = this;
        
        $(".ver").each(function(index, element){
            yo.clickVer(element);
        });
        
        $(".ver").livequery(function(){
            $(this).unbind("click");
            $(this).click(function(){
                yo.clickVer(this);
            });
        });
    },
    
    /**
     * Verifica que este o no checkeado "ver"
     * @param {type} element
     * @returns {undefined}
     */
    clickVer : function(element){
        var rel = $(element).attr("data-rel");
        if($(element).is(":checked")){
            $("#permisos_io_" + rel).removeClass("hidden");
        } else {
            $("#permisos_io_" + rel).addClass("hidden");
            
            $("#permisos_io_" + rel).find("input").each(function(index, element){
                $(element).attr("checked",false);
            });
        }
    },
    
    /**
     * Llamada despues de guardar
     * @returns {undefined}
     */
    callBackGuardar : function(){
        this.loadGridRoles();
    },
    
    /**
     * Guarda rol
     * @returns {Boolean}
     */
    guardarRol : function(){
         var yo = this;
        
        var parametros = $("#form-rol").serializeArray();

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mantenedor_rol/save", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.callBackGuardar();
                    salida = true;
                } else {
                    $("#form-rol-error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    /**
     * Guarda los permisos
     * @returns {Boolean}
     */
    guardarPermiso : function(){
        var yo = this;
        
        var parametros = $("#form-permisos").serializeArray();

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mantenedor_rol/save_permisos", 
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
    
    bindButtonUsuarios : function(){
        var yo = this;
        $(".usuarios").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                var id = $(this).attr("data");
                $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: "id=" + id,
                    type: "post",
                    url: siteUrl + "mantenedor_rol/usuarios", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(html){
                        bootbox.dialog({
                            message: html,
                            className: "modal90",
                            title: "Usuarios asociados al rol",
                            buttons: {
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
     * accion boton para nuevo rol
     * @returns {undefined}
     */
    bindButtonNuevoRol : function(){
        var yo = this;
        $("#nueva").click(function(){
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mantenedor_rol/form", 
                error: function(xhr, textStatus, errorThrown){},
                success:function(html){
                    bootbox.dialog({
                        message: html,
                        title: "Nuevo rol",
                        buttons: {
                            guardar: {
                                label: " Guardar",
                                className: "btn-success fa fa-check",
                                callback: function() {
                                    return yo.guardarRol();
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
    },
    
    /**
     * Accion boton para editar rol
     * @returns {undefined}
     */
    bindButtonEditarRol : function(){
        var yo = this;
        $(".editar-rol").livequery(function(){
           $(this).unbind("click");
           $(this).click(function(){
               var id = $(this).attr("data");
                $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: "id=" + id,
                    type: "post",
                    url: siteUrl + "mantenedor_rol/form", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(html){
                        bootbox.dialog({
                            message: html,
                            title: "Editar rol",
                            buttons: {
                                guardar: {
                                    label: " Guardar",
                                    className: "btn-success fa fa-check",
                                    callback: function() {
                                        return yo.guardarRol();
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
     * Accion boton para editar permiso
     * @returns {undefined}
     */
    bindButtonEditarPermiso : function(){
        var yo = this;
        $(".editar-permiso").livequery(function(){
           $(this).unbind("click");
           $(this).click(function(){
               var id = $(this).attr("data");
                $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: "id=" + id,
                    type: "post",
                    url: siteUrl + "mantenedor_rol/form_permisos", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(html){
                        bootbox.dialog({
                            message: html,
                            className: "modal90",
                            title: "Editar permiso",
                            buttons: {
                                guardar: {
                                    label: " Guardar",
                                    className: "btn-success fa fa-check",
                                    callback: function() {
                                        return yo.guardarPermiso();
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
                        yo.callBackEditarPermiso();
                    }
                }); 
                
                
           });
        });
    },
    
     /**
     * Carga la grilla 
     * @returns void
     */
    loadGridRoles : function(){
        $("#grilla-roles-loading").removeClass("hidden");
        $("#grilla-roles").addClass("hidden");
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "mantenedor_rol/ajax_grilla", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(html){
                $("#grilla-roles").html(html);
                $("#grilla-roles").removeClass("hidden");
                $("#grilla-roles-loading").addClass("hidden");
            }
        });
    }
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var listado = new MantenedorPermisos();	
});