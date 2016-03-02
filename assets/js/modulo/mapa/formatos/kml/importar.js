var MapaKmlImportar = Class({  
    
    /**
     * Google maps
     */
    mapa : null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function(){

    },
    
    /**
     * 
     * @returns {undefined}
     */
    popupUpload : function(){
        var yo = this;
        
        bootbox.dialog({
            message:  "<div id=\"contenido-popup\">\n"
                    + "<div class=\"row text-center\" style=\"height:200px; padding-top:50px\">"
                    + "<i class=\"fa fa-4x fa-spin fa-spinner\"></i>\n"
                    + "</div>"
                    + "</div>",
            title: "<i class=\"fa fa-arrow-right\"></i> Importar KML",
            buttons: {
                ok: {
                    label: " Cargar archivo",
                    className: "btn-success fa fa-check",
                    callback: function() {
                       /* $(".ocultar-al-subir").hide();
                        $(".mostrar-al-subir").show();
                        $(".file-input > .input-group").hide();*/
                        $("#input_kml").fileinput("upload");
                        return false;
                    }
                },
                cerrar: {
                    label: " Cerrar ventana",
                    className: "btn-white fa fa-close",
                    callback: function() {}
                }
            }
        });
        
        $(".modal-footer > .btn-success").attr("disabled",true);
        
         $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "mapa_kml/popup_importar_kml", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contenido-popup").html(html);
                $(".mostrar-al-subir").hide();
                
                $("#input_kml").fileinput({
                    language: "es",
                    multiple: false,
                    uploadAsync: false,
                    initialCaption: "",
                    showUpload : false,
                    uploadUrl: siteUrl + "mapa_kml/upload_kml",
                    uploadExtraData : function(previewId, index){
                        return {"nombre" : $("#nombre").val()}
                    }
                }).on("filebatchselected", function(event, files) {
                    $(".modal-footer > .btn-success").attr("disabled",false);
                }).on('filebatchuploadsuccess', function(event, data) {
                    
                    if(data.response.correcto){
                        bootbox.hideAll();
                        
                        $.each(data.response.elementos, function(i, elemento){
                            if(elemento["tipo"] == "PUNTO"){
                                 var marcador = new MapaKmlImportarMarcador();
                                 marcador.seteaMapa(yo.mapa);
                                 marcador.posicionarMarcador(
                                         "kml_" + data.response.hash, 
                                         null, 
                                         elemento["coordenadas"]["lat"], 
                                         elemento["coordenadas"]["lon"], 
                                         {"NOMBRE" : elemento["nombre"],
                                          "TIPO" : data.response.nombre}, 
                                         elemento["descripcion"], 
                                         baseUrl + elemento["icono"]
                                );
                            }
                            
                            if(elemento["tipo"] == "MULTIPOLIGONO"){
                                var poligono = new MapaPoligonoMulti();
                                poligono.seteaMapa(yo.mapa);
                                poligono.dibujarPoligono(
                                    "kml_" + data.response.hash,
                                    elemento["nombre"], 
                                    null,
                                    elemento["coordenadas"], 
                                    {"NOMBRE" : "TEST"},
                                    null, 
                                    "#000000");
                            }
                        });
                        
                        var kml = {};
                        kml = {
                            "id" : null,
                            "tipo" : data.response.tipo,
                            "hash" : data.response.hash,
                            "nombre" : data.response.nombre, 
                            "archivo" : data.response.archivo
                        };                        
                        lista_kml.push(kml);

                        var archivos = new MapaArchivos();
                        archivos.updateListaArchivosAgregados();
                    } else {
                        procesaErrores(data.response.errores);

                        $("#form_error").removeClass("hidden");
                        
                        $(".modal-footer > .btn-success").attr("disabled",true);
                        $('#input_kml').attr('disabled', false);
                        $('#input_kml').fileinput('refresh');
                    }
                });
            }
        });
    }
});

