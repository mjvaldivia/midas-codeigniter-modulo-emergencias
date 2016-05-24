var EventoDocumentos = Class({ extends : MantendorDocumentos}, {
    loadGridArchivos : function(){
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: {"id" : $("#id").val()},
            type: "post",
            url: siteUrl + "evento_documentos/ajax_grilla_documentos", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(html){
                $("#div-grilla-documentos").html(html);
            }
        });
    }
});


