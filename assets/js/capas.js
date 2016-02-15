/**
 * Created by claudio on 15-09-15.
 */
var Layer = {};

(function() {

    this.initList = function() {
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "capas/ajax_grilla_capas_unicas",
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contenedor-grilla-capas").html(html);
            }
        });
        
        
    };

    this.initSave = function() {
        /*$("#input-icon").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione Icono",
            allowedFileTypes: ['image'],
            uploadUrl: siteUrl + "emergencia/subir_IconTemp",
            dropZoneTitle:''
        });*/
        

        $("#input-capa-geojson").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: false,
            maxFileCount: 1,
            initialCaption: "Seleccione una capa GeoJson",
            allowedFileExtensions : ['geojson'],
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });

        $("#input-capa-shape").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: false,
            maxFileCount: 1,
            msgFilesTooMany: 'Sólo se permite cargar 2 archivos',
            initialCaption: "Seleccione archivos Shape .shp y .dbf",
            showUpload: true,
            allowedFileExtensions : ['shp','dbf'],
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });


        
       /* $('#input-icon').on('filebatchuploadsuccess', function(event, data) {
            $('#icon').val(data.response.nombre_cache_id);
            $('#img_icon').attr('src',baseUrl+''+data.response.ruta);
            
        });*/
        
         $("#iCategoria").jCombo(siteUrl + "capas/obtenerJsonCatCoberturas");
        
        $('#input-capa-geojson, #input-capa-shape').on('filebatchuploadsuccess', function(event, data) {

           if(data.response.uploaded==0)//error
           {
               var error_mensaje = data.response.error_mensaje;
               //var error_filenames = 'El (los) siguiente(s) archivos no son válidos:<br>';
               /*$.each(data.response.error_filenames,function(k,v){
                  error_filenames += '-'+v+'<br>';
               });*/

                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: error_mensaje,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
                $("#cargando_geojson").fadeOut();
           }else{
               if(data.response.filenames.length==0){
                   $("#cargando_geojson").fadeOut();
                   return; // no se subio ningun archivo valido
               }

               $("#tmp_file").val(data.response.nombre_cache_id);
               var properties = data.response.properties.data;
               var filename = data.response.filenames.data;
               var geometry = data.response.geometry.data;

               $('#tabla_propiedades').DataTable().destroy();
               /*$('#tabla_comunas').DataTable().destroy();*/
               $('#tabla_colores').DataTable().destroy();

               $('#tabla_colores').DataTable({
                   data: geometry,
                   language: {
                       url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
                   },
                   bFilter: true,
                   bPaginate : false,
                   paging:   false,
                   ordering: false,
                   info:     false,
                   sDom: 't',
                   initComplete: function(){
                       $('#div_color').removeClass("hidden");
                   }

               });


               $('#tabla_propiedades').DataTable({
                   data: properties,
                   language: {
                       url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
                   },
                   bPaginate : false,
                   paging:   false,
                   ordering: false,
                   info:     false,
                   bSearchBox: false,
                   sDom: 't',
                   initComplete: function(){
                       $("#cargando_geojson").fadeOut(function(){
                           $("#btn-guardar-capa").attr('disabled',false);
                       });
                       $('#div_properties').slideDown('slow');
                   }

               });

           }

            
        });
    };
    
    this.guardar = function (form,btn){
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');
        if(form.capa_edicion === undefined){
            if(!Utils.validaForm($(form).attr('id'))){
                $(btn).attr('disabled',false).html(btnText);
                return;
            }    
        }else{
            var message = '';
            if(form.nombre_editar.value == ""){
                message += '- Nombre de capa no puede quedar vacío<br/>';
            }
            if(form.iCategoria_editar.value == ""){
                message += '- Debe seleccionar categoría de la capa<br/>';
            }
            if($(".propiedades:checked").length == 0){
                message += '- Debe seleccionar por lo menos una propiedad de la capa<br/>';
            }
            if(message != ""){
                xModal.danger(message,function(){
                    $(btn).attr('disabled',false).html(btnText);
                });
                return;

            }
            
        }
        
        var params = $(form).serialize();
        
        /*if(form.capa_edicion === undefined){
            params += "&items="+parseInt($('#tabla_comunas tr').length-1); 
        }else{
            params += "&items="+parseInt($('#tabla_comunas_editar tr').length-1); 
        }*/
        
        $.post(siteUrl+"capas/guardarCapa", params, function (data) {
            if(data==1)//bien
            {
                xModal.success('Se han guardado con éxito los datos',function(){
                    Layer.initList();
                    xModal.closeAll();
                });
                /*bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha guardado con éxito.',
                    buttons: {
                        danger: {
                            label: "Aceptar",
                            className: "btn-info",
                            callback: function(){
                                if(form.capa_edicion === undefined){
                                    $(btn).attr('disabled',false);
                                    Layer.initList();
                                    xModal.closeAll();
                                }else{
                                    $("#tab3").fadeOut(function(){
                                        $("#tab-editar").fadeOut(function(){
                                            $(this).removeClass('active');
                                            $(this).prev().addClass('active');    
                                            $("#tab2").addClass('active').show();
                                            Layer.initList();
                                        });
                                    });
                                }
                                
                            }
                        }
                    }
                });*/
                
                
            }else{
                xModal.danger('Problemas al guardar los datos <br/> Error: '+data,function(){
                    $(btn).attr('disabled',false).html(btnText);
                });
                /*bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Una o más capas no se han guardado <br/> Error: '+data,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger",
                            callback : function(){
                            $(btn).attr('disabled',false).html(btnText);
                           }
                        }
                    }
                });
                */
                
            }
            
        }).fail(function(){
            xModal.danger("Error en el sistema. Intente nuevamente o comuníquese con Soporte",function(){
                $(btn).attr('disabled',false).html(btnText);
            });

        });
        
        
        
        
    };



    this.eliminarCapa = function(id_capa){

        $.post(siteUrl + 'capas/validarCapaEmergencia',{capa:id_capa},function(response){
            if(response.estado == true){
                var mensaje = 'La capa a eliminar posee subcapas asociadas a una Emergencia. Desea eliminarla de todas formas?';
            }else{
                var mensaje = 'Desea eliminar esta capa?';
            }
            bootbox.confirm(mensaje, function(result) {
                if(result){
                    /* eliminar capa */
                    $.post(siteUrl + 'capas/eliminarCapa',{capa:id_capa},function(response){
                        if(response.estado == true){
                            bootbox.alert(response.mensaje,function(){
                                Layer.initList();
                            });
                        }else{
                            bootbox.dialog({title:'Error', message:response.mensaje});
                        }
                    },'json').fail(function(){
                        bootbox.dialog({title:'Error en sistema', message:'Intente nuevamente o comuníquese con Administrador'});
                    });
                }

            });
        },'json').fail(function(){
            bootbox.dialog({title:'Error en sistema', message:'Intente nuevamente o comuníquese con Administrador'});
        });

    };


    this.cargarDetalleCapa = function(id_capa){
        $.ajax({
            dataType: "html",
            cache: false,
            async: false,
            data: {id_capa:id_capa},
            type: "post",
            url: siteUrl + "capas/ajax_grilla_capas",
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contenedor-grilla-detalle-capa").html(html);
            }
        });
    };


    this.eliminarSubCapa = function(id_subcapa, id_capa){
        $.post(siteUrl + 'capas/validarSubCapaEmergencia',{capa:id_subcapa},function(response){
            if(response.estado == true){
                var mensaje = 'La subcapa a eliminar se encuentra asociada a una Emergencia. Desea eliminarla de todas formas?';
            }else{
                var mensaje = 'Desea eliminar esta subcapa?';
            }
            bootbox.confirm(mensaje, function(result) {
                if(result){
                    /* eliminar capa */
                    $.post(siteUrl + 'capas/eliminarSubCapa',{subcapa:id_subcapa},function(response){
                        if(response.estado == true){
                            bootbox.alert(response.mensaje,function(){
                                Layer.cargarDetalleCapa(id_capa);
                            });                
                        }else{
                            bootbox.dialog({title:'Error', message:response.mensaje});                
                        }
                    },'json').fail(function(){
                        bootbox.dialog({title:'Error en sistema', message:'Intente nuevamente o comuníquese con Administrador'});            
                    });    
                }
                
            });
        },'json').fail(function(){
            bootbox.dialog({title:'Error en sistema', message:'Intente nuevamente o comuníquese con Administrador'});
        });
        
    };


    this.eliminarItemSubcapa = function(id_item,subcapa){
        xModal.confirm('Desea eliminar este item?',function(){
            $.post(siteUrl + 'capas/eliminarItemSubcapa',{item:id_item},function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje,function(){
                        Layer.listarItemsSubCapa(subcapa);
                    });
                }else{
                    xModal.danger(response.mensaje);
                }
            },'json').fail(function(){
                xModal.danger('Intente nuevamente o comuníquese con Administrador');
            });
        });
        /*bootbox.confirm('Desea eliminar este item?',function(result){
            if(result){
                $.post(siteUrl + 'capas/eliminarItemSubcapa',{item:id_item},function(response){
                    if(response.estado == true){
                        bootbox.alert(response.mensaje,function(){
                            Layer.initList();
                        });
                    }else{
                        bootbox.dialog({title:'Error', message:response.mensaje});
                    }
                },'json').fail(function(){
                    bootbox.dialog({title:'Error en sistema', message:'Intente nuevamente o comuníquese con Administrador'});
                });
            }
        });*/
    }

    this.editarCapa = function(id_capa){
        xModal.open(siteUrl + 'capas/editarCapa/capa/'+id_capa,'Editar capa','lg');
        /*$("#tab-editar").fadeIn(function(){
            $("#ul-tabs").find('li.active').removeClass('active');
            $("#tab-content").find('div.tab-pane.active').removeClass('active');
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarCapa',{capa:id_capa},function(response){
                $("#div_tab_3").html(response);
                $("#tab3").addClass('active').show();
            },'html');
        });*/
    };

    this.editarSubCapa = function(id_subcapa){
        xModal.open(siteUrl + 'capas/editarSubCapa/subcapa/'+id_subcapa,'Editar Sub Capa', 'lg');
        /*$("#tab-editar").fadeIn(function(){
            $("#ul-tabs").find('li.active').removeClass('active');
            $("#tab-content").find('div.tab-pane.active').removeClass('active');
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarSubCapa',{capa:id_subcapa},function(response){
                $("#div_tab_3").html(response);
                $("#tab3").addClass('active').show();
            },'html');
        });*/
    };


    this.editarItemSubcapa = function(item){
        $("#contenedor-items-subcapa").fadeOut(function(){
            $.post(siteUrl + 'capas/editarItemSubCapa',{item:item},function(response){
                $("#contenedor-editar-item").html(response);
                $("#contenedor-editar-item").fadeIn();
            },'html');
        })
        /*$("#tab-items-editar").fadeIn(function(){
            $("#tab-items-subcapa").removeClass('active').addClass('disabled');
            $("#tab4").removeClass('active').fadeOut();
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarItemSubCapa',{item:item},function(response){
                $("#div_tab_5").html(response);
                $("#tab5").addClass('active').fadeIn();
            },'html');
        });*/
    };


    this.listarItemsSubCapa = function(id_subcapa){
        $.post(siteUrl + 'capas/ajax_grilla_items_subcapas',{subcapa:id_subcapa},function(response){
            $("#contenedor-items-subcapa").html(response);
        },'html');
        /*$("#tab-items-subcapa").fadeIn(function(){
            $("#ul-tabs").find('li.active').removeClass('active');
            $("#tab-content").find('div.tab-pane.active').removeClass('active');
            $(this).addClass('active');
            $("#tab4").addClass('active').fadeIn(function(){
                $.post(siteUrl + 'capas/ajax_grilla_items_subcapas',{subcapa:id_subcapa},function(response){
                    $("#tab4-cargando").fadeOut(function(){
                        $("#div_tab_4").html(response);
                        
                        $("#tab4-contenido").fadeIn(function(){

                        });
                        
                    });
                },'html');
            });

        });*/
    };


    this.guardarItemSubcapa = function(form,btn,item){
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        var params = $(form).serialize();
        $.post(siteUrl + 'capas/guardarItemSubcapa/item/'+item,params,function(response){
            if(response.estado == true){
                xModal.success(response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                    var subcapa = $("#id_subcapa").val();
                    $("#contenedor-editar-item").fadeOut(function(){
                        $("#contenedor-items-subcapa").fadeIn();
                        Layer.listarItemsSubCapa(subcapa);
                    });


                });
                /*bootbox.alert("Operación Exitosa: "+response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                    var subcapa = $("#id_subcapa").val();
                    Layer.cancelarEdicionItem(subcapa)
                });*/
            }else{
                xModal.danger("Error en la operación: "+response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
                /*bootbox.alert("Error en la operación: "+response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                });*/
            }
        },'json').fail(function(){
            xModal.danger("Error en sistema. Intente nuevamente o comuníquese con Soporte",function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        });
    };




    this.cancelarEdicionItem = function(subcapa){
        $("#contenedor-editar-item").fadeOut(function(){
            $(this).html();
            $("#contenedor-items-subcapa").fadeIn();
        });

        /*$("#tab5").fadeOut(function(){
            $("#tab-items-editar").fadeOut(function(){
                $(this).removeClass('active');
                Layer.listarItemsSubCapa(subcapa);
                /!*$(this).prev().addClass('active');
                $("#tab4").addClass('active').show(function(){
                    Layer.listarItemsSubCapa(subcapa);
                });*!/
            });
        });*/
    }

    this.initSaveEdicion = function() {

        $("#input-capa-geojson").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: false,
            maxFileCount: 1,
            initialCaption: "Seleccione una capa GeoJson",
            allowedFileExtensions : ['geojson'],
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });

        $("#input-capa-shape").fileinput({
            language: "es",
            multiple: true,
            uploadAsync: false,
            maxFileCount: 2,
            msgFilesTooMany: 'Sólo se permite cargar 2 archivos',
            initialCaption: "Seleccione archivos Shape .shp y .dbf",
            showUpload: true,
            allowedFileExtensions : ['shp','dbf'],
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });



        /* $('#input-icon').on('filebatchuploadsuccess', function(event, data) {
         $('#icon').val(data.response.nombre_cache_id);
         $('#img_icon').attr('src',baseUrl+''+data.response.ruta);

         });*/

        $("#iCategoria").jCombo(siteUrl + "capas/obtenerJsonCatCoberturas");

        $('#input-capa-geojson, #input-capa-shape').on('filebatchuploadsuccess', function(event, data) {

            if(data.response.uploaded==0)//error
            {
                var error_mensaje = data.response.error_mensaje;
                //var error_filenames = 'El (los) siguiente(s) archivos no son válidos:<br>';
                /*$.each(data.response.error_filenames,function(k,v){
                 error_filenames += '-'+v+'<br>';
                 });*/

                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: error_mensaje,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
                $("#cargando_geojson").fadeOut();
            }else{
                if(data.response.filenames.length==0){
                    $("#cargando_geojson").fadeOut();
                    return; // no se subio ningun archivo valido
                }

                $("#tmp_file").val(data.response.nombre_cache_id);
                var properties = data.response.properties.data;
                var filename = data.response.filenames.data;
                var geometry = data.response.geometry.data;

                $('#tabla_propiedades').DataTable().destroy();
                /*$('#tabla_comunas').DataTable().destroy();*/
                $('#tabla_colores').DataTable().destroy();

                $('#tabla_colores').DataTable({
                    data: geometry,
                    language: {
                        url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
                    },
                    bFilter: true,
                    bPaginate : false,
                    paging:   false,
                    ordering: false,
                    info:     false,
                    sDom: 't',
                    initComplete: function(){
                        $('#div_color').removeClass("hidden");
                    }

                });


                $('#tabla_propiedades').DataTable({
                    data: properties,
                    language: {
                        url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
                    },
                    bPaginate : false,
                    paging:   false,
                    ordering: false,
                    info:     false,
                    bSearchBox: false,
                    sDom: 't',
                    initComplete: function(){
                        $("#cargando_geojson").fadeOut(function(){
                            $("#btn-guardar-capa").attr('disabled',false);
                        });
                        $('#div_properties').slideDown('slow');
                    }

                });

            }


        });
    };   


    this.cancelarEdicion = function(){
        $("#tab3,#tab4").fadeOut(function(){
            $("#tab-editar,#tab-items-subcapa").fadeOut(function(){
                $(this).removeClass('active');
                $(this).prev().addClass('active');    
                $("#tab2").addClass('active').show();
            });
        });

    } ;


    this.listarCapasDetalle = function(id_capa,nombre_capa){
        xModal.open(siteUrl + 'capas/verDetalleCapa/capa/'+id_capa,nombre_capa + ' :: Subcapas', 'lg');
        console.log($("#contenedor-grilla-detalle-capa").length);

    } ;


    this.volverListadoCapas = function(){
        $("#tab2 > #div_tab_2").fadeOut(function(){
            $.ajax({
                dataType: "html",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "capas/ajax_grilla_capas_unicas",
                error: function(xhr, textStatus, errorThrown){

                },
                success:function(html){
                    $("#contenedor-grilla-capas").html(html);
                    $("#resultados_capa").html('');
                    $("#tab2 > #div_tab_2").fadeIn(function(){

                    });
                }
            });
        });
    };


    this.volverTabListado = function(){
        $("#tab-items-subcapa,#tab4").fadeOut(function(){
            $("#tab4-contenido").fadeOut(function(){
                $("#tab4-cargando").show();
            })
            $(this).removeClass('active');
            $("#tab-listado, #tab2").addClass('active').fadeIn(function(){

            });

        });
    }

    this.guardarSubCapa = function(form, btn){
        btn.disabled = true;
        var btnText = $(btn).html();
        $(btn).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        var error = "";
        if(form.nombre_subcapa.value == ""){
            error = "- Debe ingresar nombre de la subcapa";
        }

        if(error != ""){
            bootbox.alert(error,function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var params = $(form).serialize();
            $.post(siteUrl + 'capas/guardarSubCapa',params,function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje,function(){
                        Layer.cargarDetalleCapa(form.id_capa.value);
                        $(btn).html(btnText).attr('disabled',false);
                    });
                    /*bootbox.alert(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                        Layer.cancelarEdicion();
                    });*/
                }else{
                    xModal.danger(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                    /*bootbox.alert(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });*/
                }
            },'json').fail(function(){
                xModal.danger("Error en el sistema. Intente nuevamente",function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
                /*bootbox.alert("Error en el sistema. Intente nuevamente",function(){
                    $(btn).html(btnText).attr('disabled',false);
                });*/
            });
        }
    };


    this.revisarErrores = function(capa){
        xModal.open(siteUrl + 'capas/mostrarErroresCargaCapas/capa/'+capa,'Errores con Comunas','lg');
    };

    this.eliminarInformacionComunas = function(capa,btn){
        $(btn).attr('disabled',true);
        var btnText = $(btn).html();
        $(btn).html('Eliminando... <i class="fa fa-spin fa-spinner"></i>');
        $.post(siteUrl + 'capas/eliminarErroresCargaCapas',{capa:capa},function(response){
            if(response.estado == true){
                xModal.success(response.mensaje,function(){
                    xModal.closeAll();
                    Layer.initList();
                });
            }else{
                xModal.danger(response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);    
                });
            }
        },'json').fail(function(){
            xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte',function(response){
                $(btn).html(btnText).attr('disabled',false);
            });
        });
    };


    this.mostrarContenedorCapa = function(contenedor){
        if(contenedor == 1){
            $('#contenedor_tipo_shape').fadeOut(function(){
                $("#contenedor_tipo_geojson").fadeIn();
            });
        }else if(contenedor == 2){
            $('#contenedor_tipo_geojson').fadeOut(function() {
                $("#contenedor_tipo_shape").fadeIn();
            });
        }

    };
    
}).apply(Layer);