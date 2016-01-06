var MantenedorPermisos = Class({
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        var yo = this;
        this.loadGridRoles();
        
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