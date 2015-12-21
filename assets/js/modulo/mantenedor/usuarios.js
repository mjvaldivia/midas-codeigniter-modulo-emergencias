var MantenedorUsuarios = Class({
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        this.loadGridUsuario();
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

