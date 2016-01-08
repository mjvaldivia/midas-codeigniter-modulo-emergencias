var MapaCapa = Class({
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {

    },
    
    capas : function(){
        var yo = this;
        var id = $("#id").val();
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id,
            type: "post",
            url: siteUrl + "mapa/ajax_capas", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){

            }
        });
    }
});


