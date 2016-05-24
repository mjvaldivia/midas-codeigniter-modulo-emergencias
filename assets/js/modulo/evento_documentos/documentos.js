var EventoDocumentos = Class({ extends : MantendorDocumentos}, {
    
    bindDropzone : function(){
      //void  
      this.bindUpload();
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindUpload : function (){
        var $this = this;
        $("#upload-adjunto").fileinput({
            language: "es",
            allowedFileTypes : ['image', 'html', 'text', 'video', 'audio', 'flash'],
            multiple: false,
            uploadAsync: false,
            initialCaption: "Seleccione archivo",
            showUpload : false,
            showRemove: false,
            uploadUrl: siteUrl + "archivo/upload_temporal",
            uploadExtraData : function(previewId, index){
                return {"descripcion" : $("#file_descripcion").val(),
                        "tipo" : $("#archivo_tipo").val()}
            }
        }).on("filebatchselected", function(event, files) {
            $("#upload-adjunto-error").parent().parent().addClass("hidden");
        }).on('filebatchuploadsuccess', function(event, data) {
            $(".modal-footer > .btn-success").attr("disabled", false);
            if(data.response.correcto){
                $("#upload-adjunto-error").parent().parent().addClass("hidden");
                $("#file_descripcion").val("");
                $("#archivo_tipo").val("");
                
                $("#upload-adjunto-lista").append(
                        "<div id=\"archivo-" + data.response.hash + "\">"
                            + "<input type=\"hidden\" name=\"archivos[]\" value=\"\" />"
                            + "<input type=\"hidden\" name=\"archivos_hash[]\" value=\""+data.response.hash+"\" />"
                            
                            + "<div class=\"row\">"
                                + "<div class=\"col-md-3\">"
                                    + "<input type=\"hidden\" name=\"archivos_descripcion[]\" value=\"" + data.response.descripcion + "\" />"
                                    + data.response.descripcion
                                + "</div>"
                                + "<div class=\"col-md-3\">"
                                    + "<input type=\"hidden\" name=\"archivos_tipo[]\" value=\"" + data.response.tipo + "\" />"
                                    + data.response.nombre_tipo
                                + "</div>"
                                + "<div class=\"col-md-4\">"
                                    + "<a href=\"" + siteUrl + "archivo/download_temporal/hash/" + data.response.hash + "\" target=\"_blank\" >"
                                    + data.response.archivo
                                    + "</a>"
                                + "</div>"
                                + "<div class=\"col-md-2 text-center\">"
                                    + "<!--<button class=\"btn btn-xs btn-danger quitar-archivo\"> <i class=\"fa fa-remove\"></i> </button>-->"
                                + "</div>" 
                            + "</div>"
                            + "<hr/>"
                        + "</div>"
                );
                
                var parametros = {"id" : $("#id").val(),
                                  "archivos_hash" : data.response.hash,
                                  "archivos_descripcion" : data.response.descripcion,
                                  "archivos_tipo" : data.response.tipo};
                
                $.ajax({         
                    dataType: "json",
                    cache: false,
                    async: true,
                    data: parametros,
                    type: "post",
                    url: siteUrl + "evento_documentos/guardar_archivo", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(data){
                       $this.loadGridArchivos();
                    }
                });
                
            } else {
                $("#upload-adjunto-error").parent().parent().removeClass("hidden");
                $("#upload-adjunto-error").html("<strong>Ocurrio un error al subir el archivo</strong><br/>" + data.response.errores);
            }
            
            $('#upload-adjunto').fileinput('reset');
            $('#upload-adjunto').fileinput('clear');
            $('#upload-adjunto').fileinput('cancel');    
            
        }).on('filebatchuploaderror', function(event, data, msg) {
            $(".modal-footer > .btn-success").attr("disabled", false);
            $("#upload-adjunto-error").parent().parent().removeClass("hidden");
            $("#upload-adjunto-error").html("Ocurrio un error al subir el archivo.");

            $('#upload-adjunto').fileinput('reset');
            $('#upload-adjunto').fileinput('clear');
            $('#upload-adjunto').fileinput('cancel');    

        });  
        
        $(".quitar-archivo").livequery(function(){
            $(this).click(function(e){
                e.preventDefault();
                $(this).parent().parent().parent().remove();
                
                
            });
        });
        
        $("#upload-adjunto-start").click(function(e){
            e.preventDefault();
            var descripcion = $("#file_descripcion").val();
            var id_tipo = $("#archivo_tipo").val();
            if(descripcion.trim == "" || id_tipo == ""){
                $("#upload-adjunto-error").parent().parent().removeClass("hidden");
                $("#upload-adjunto-error").html("<strong>Ocurrio un error al subir el archivo</strong><br/> Debe ingresar la descripción y tipo de archivo");
            } else {
                $("#upload-adjunto").fileinput("upload");
                $(".modal-footer > .btn-success").attr("disabled", true);
            }
        });
    },
    
    _ajaxLoadArchivos : function(){
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: {"id" : $("#id").val(), "search" : $("#search").val()},
            type: "post",
            url: siteUrl + "evento_documentos/ajax_grilla_documentos", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(html){
                $("#div-grilla-documentos").html(html);
            }
        });
    }
});


