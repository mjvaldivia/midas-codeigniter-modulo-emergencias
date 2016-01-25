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
    
    cargarKmlTemporal : function(hash, tipo, nombre){
        var kmzLayer = new google.maps.KmlLayer( siteUrl + 'mapa/kml_temporal/hash/' + hash + "/file." + tipo);
        
        kmzLayer.setMap(this.mapa);
        kmzLayer.id = null;
        kmzLayer.hash = hash;
        kmzLayer.nombre = nombre;
       
        lista_kml.push(kmzLayer);
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
            url: siteUrl + "mapa/popup_importar_kml", 
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
                    uploadUrl: siteUrl + "mapa/upload_kml",
                    uploadExtraData : function(previewId, index){
                        return {"nombre" : $("#nombre").val()}
                    }
                }).on("filebatchselected", function(event, files) {
                    $(".modal-footer > .btn-success").attr("disabled",false);
                }).on('filebatchuploadsuccess', function(event, data) {
                    
                    if(data.response.correcto){
                        bootbox.hideAll();
                        yo.cargarKmlTemporal(data.response.hash, data.response.tipo, data.response.nombre);
                    } else {
                        procesaErrores(data.response.errores);
                       /* $(".file-input > .input-group").show();
                        $(".mostrar-al-subir").hide();
                        $(".ocultar-al-subir").show();*/
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

