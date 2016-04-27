var VisorCapa = Class({ extends : MapaCapa}, {
    
    /**
     * Añade una capa al visor
     * @param {int} id_capa
     * @returns {void}
     */
    addCapa : function(id_subcapa){
        var yo = this;
        Messenger().run({
            action: $.ajax,
            successMessage: '<strong> Agregando capa </strong> <br> Ok',
            errorMessage: '<strong> Agregando capa </strong> <br> Se produjo un error al cargar',
            progressMessage: '<strong> Agregando capa </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
        }, {
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_subcapa + "&id_region=" + $("#regiones").val(),
            type: "post",
            url: siteUrl + "visor/ajax_carga_capa", 
            success:function(data){
                if(data.correcto){
                    if(($.isEmptyObject(yo.capas[id_subcapa]))){
                        yo.capas[id_subcapa] = data.capa;
                        yo.cargaCapa(id_subcapa, data.capa);
                        yo.listaCapasVisor();
                    }
                }
            }
        });
    },
});


