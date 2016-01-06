var MantenedorPermisos = Class({
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        this.loadGridRoles();
        this.bindButtonEditar();
    },
    
    /**
     * 
     * @returns {undefined}
     */
    callBackEditar : function(){
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
    
    callBackGuardar : function(){
        this.loadGridRoles();
    },
    
    guardar : function(){
        var yo = this;
        
        var parametros = $("#form-permisos").serializeArray();

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mantenedor_permiso/save", 
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
     * 
     * @returns {undefined}
     */
    bindButtonEditar : function(){
        var yo = this;
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
                    url: siteUrl + "mantenedor_permiso/form", 
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
                        yo.callBackEditar();
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
            url: siteUrl + "mantenedor_permiso/ajax_grilla", 
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