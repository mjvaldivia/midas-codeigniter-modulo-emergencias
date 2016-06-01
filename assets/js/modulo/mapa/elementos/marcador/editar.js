var MapaMarcadorEditar = Class({  
    
    marker : null,
    
    
    
    seteaMarker : function(marker){
        this.marker = marker;
    },
    
    upload : function(){
      $('#icono').filer({
        showThumbs: true,
        limit: 1,
        extensions: ['jpg', 'jpeg', 'png', 'gif'],
        files : [{
            name: $("#icono_name").val(),
            size: $("#icono_size").val(),
            type: $("#icono_type").val(),
            file: $("#icono_file").val()
        }],
        captions: {
            button: "Buscar imagen",
            feedback: "Seleccione la imagen",
            feedback2: "documento seleccionado",
            drop: "Arrastre el archivo para subir",
            removeConfirmation: "¿Esta seguro que desea quitar este archivo?",
            errors: {
                filesLimit: "Se puede subir solo {{fi-limit}} archivo.\n Si desea cambiar el archivo, debe eliminar el archivo anterior",
                filesType: "El archivo que intenta subir no es valido.",
                filesSize: "¡{{fi-name}} es muy grande! Suba un archivo menor o igual a {{fi-maxSize}} MB.",
                filesSizeAll: "¡Los archivos son muy grandes! Suba archivos menores o iguales a {{fi-maxSize}} MB."
            }
        },
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                        <input type="hidden" id="icono_hash" class="icono_hash" name="icono_hash" value="" />\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb descargar-archivo-subido" >\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                     </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a data-rel="" class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item">\
                            <input type="hidden" id="icono_hash" class="icono_hash" name="icono_hash" value="" />\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb descargar-archivo-subido" >\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                            <span class="jFiler-item-others">{{fi-size2}}</span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a data-rel="" class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        afterShow : function(el){
          console.log(el);  
        },
        uploadFile: {
            url: siteUrl + "archivo/upload_temporal",
            data: null,
            type: 'POST',
            enctype: 'multipart/form-data',
            beforeSend: function(){},
            success: function(data, el){
                if(data.correcto){
                    
                    el.find(".icono_hash").val(data.hash);
                    el.find(".icon-jfi-trash").attr("data-rel", data.hash);
                    
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Correcto</div>").hide().appendTo(parent).fadeIn("slow");    
                    });
                } else {
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Ocurrio un error al subir: <br>" + data.errores + "</div>").hide().appendTo(parent).fadeIn("slow");    
                    });
                }
            },
            error: function(el){
                var parent = el.find(".jFiler-jProgressBar").parent();
                el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                    $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Ocurrio un error al subir: <br> <b>Error interno</b></div>").hide().appendTo(parent).fadeIn("slow");    
                });
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        }
    });   
    },
    
    clickListener : function(){
        var yo = this;
        this.marker.addListener('rightclick', function(event) {
 
            var parametros = {"id" : yo.marker.id,
                              "clave" : yo.marker.clave,
                              "html" : yo.marker.html,
                              "icono" : yo.marker.getIcon(),
                              "propiedades" : yo.marker.informacion};
            
            bootbox.dialog({
                message: "<div class=\"row\"><div id=\"contenido-popup\" class=\"col-lg-12 text-center\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Datos del marcador",
                className: "modal70",
                buttons: {
                        guardar: {
                        label: " Efectuar cambios",
                        className: "btn-success fa fa-check",
                        callback: function() {
                            
                            var marcador = jQuery.grep(lista_markers, function( a ) {
                                if(a["clave"] == $("#clave_marcador").val()){
                                    return true;
                                }
                            });
                            
                            if($("#icono_hash").val()!=""){
                                marcador[0].setIcon(baseUrl + "archivo/download_temporal/hash/" + $("#icono_hash").val());
                                marcador[0]["icono_hash"] = $("#icono_hash").val();
                            }
                            
                            if($("#texto_marcador").length > 0){
                                marcador[0]["informacion_html"] = CKEDITOR.instances.texto_marcador.getData();
                            } else {
                                var informacion = {};

                                $('input[name^="parametro_nombre"]').each(function(i, input) {
                                    informacion[$(input).val()] = $($('input[name^="parametro_valor"]').get(i)).val(); 
                                });
                                
                                marcador[0]["informacion"] = informacion;
                            }
                            
                            var elemento_marcador = new MapaMarcador();
                            elemento_marcador.seteaMapa(marcador[0].getMap());
                            elemento_marcador.informacionMarcador(marcador[0]);
                            
                            lista_markers = jQuery.grep(lista_markers, function( a ) {
                                if(a["clave"] != $("#clave_marcador").val()){
                                    return true;
                                }
                            });

                            lista_markers.push(marcador[0]);
                            
                            var elementos = new MapaElementos();
                            elementos.listaElementosVisor()
                        }
                    },
                    eliminar: {
                        label: " Eliminar marcador",
                        className: "btn-danger fa fa-remove",
                        callback: function() {
                            var marcador = new MapaMarcador();
                            marcador.removerMarcadores("clave", $("#clave_marcador").val());
                            
                            var elementos = new MapaElementos();
                            elementos.listaElementosVisor()
                        }
                    },
                    cerrar: {
                        label: " Cerrar ventana",
                        className: "btn-white fa fa-close",
                        callback: function() {
                            
                        }
                    }
                }
            });

            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "mapa/popup_marcador_editar", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup").html(data);
                    console.log($("#texto_marcador").length);
                    if($("#texto_marcador").length > 0){
                        CKEDITOR.config.scayt_autoStartup = true;
                        CKEDITOR.config.scayt_sLang = "es_ES";
                        CKEDITOR.config.extraPlugins = 'justify';
                        CKEDITOR.config.allowedContent = true;
                        CKEDITOR.config.extraAllowedContent = "td[style]";
                        CKEDITOR.replace( "texto_marcador" );
                    } else {
                        var edicion = new MapaInformacionElementoEdicion();
                        edicion.formPropiedades();
                    }
                    
                    yo.upload();
                }
            }); 
        });
    }
});


