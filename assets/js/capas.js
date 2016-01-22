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
        

        $("#input-capa").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione una o varias capas GeoJson",
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });
        
       /* $('#input-icon').on('filebatchuploadsuccess', function(event, data) {
            $('#icon').val(data.response.nombre_cache_id);
            $('#img_icon').attr('src',baseUrl+''+data.response.ruta);
            
        });*/
        
         $("#iCategoria").jCombo(siteUrl + "visor/obtenerJsonCatCoberturas");
        
        $('#input-capa').on('filebatchuploadsuccess', function(event, data) {

           if(data.response.uploaded==0)//error
           {
               var error_filenames = 'El (los) siguiente(s) archivos no son válidos:<br>';
               $.each(data.response.error_filenames,function(k,v){
                  error_filenames += '-'+v+'<br>'; 
               });

                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: error_filenames,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
           }
           if(data.response.filenames.length==0) return; // no se subio ningun archivo valido

            $("#tmp_file").val(data.response.nombre_cache_id);
           var properties = data.response.properties.data;
           var filename = data.response.filenames.data;
           var geometry = data.response.geometry.data;

            $('#tabla_propiedades').DataTable().destroy();
            $('#tabla_comunas').DataTable().destroy();
            $('#tabla_colores').DataTable().destroy();
            
            $('#tabla_colores').DataTable({
                data: geometry,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                bPaginate : false,
                order: [[0, "desc"]],
                initComplete: function(){
                    $('#div_color').removeClass("hidden");
                }
                
            }); 
            
            
            $('#tabla_propiedades').DataTable({
                data: properties,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                bPaginate : false,
                order: [[0, "desc"]],
                initComplete: function(){
                    $("#cargando_geojson").fadeOut();
                    $('#div_properties').slideDown('slow');
                }
                
            }); 
            
            $('#tabla_comunas').DataTable({
                data: filename,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]],
                bPaginate: false,
                initComplete: function(){
                    $(".iComunas").jCombo(siteUrl + "comuna/json_comunas_usuario");
                   
                    
                    $('#div_comunas').slideDown('slow');

                }
            }); 
            
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
                bootbox.dialog({
                    title: "Error",
                    message: message,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
                $(btn).attr('disabled',false).html(btnText);
                return;
            }
            
        }
        
        var params = $(form).serialize();
        
        /*if(form.capa_edicion === undefined){
            params += "&items="+parseInt($('#tabla_comunas tr').length-1); 
        }else{
            params += "&items="+parseInt($('#tabla_comunas_editar tr').length-1); 
        }*/
        
        $.post(siteUrl+"visor/guardarCapa", params, function (data) {
            if(data==1)//bien
            {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha guardado con éxito.',
                    buttons: {
                        danger: {
                            label: "Aceptar",
                            className: "btn-info",
                            callback: function(){
                                if(form.capa_edicion === undefined){
                                    $(btn).attr('disabled',false);
                                    location.reload();    
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
                });
                
                
            }else{
                bootbox.dialog({
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
                
                
            }
            
        }).fail(function(){
            $(btn).attr('disabled',false).html(btnText);
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





    this.eliminarSubCapa = function(id_capa){
        $.post(siteUrl + 'capas/validarSubCapaEmergencia',{capa:id_capa},function(response){
            if(response.estado == true){
                var mensaje = 'La subcapa a eliminar se encuentra asociada a una Emergencia. Desea eliminarla de todas formas?';
            }else{
                var mensaje = 'Desea eliminar esta subcapa?';
            }
            bootbox.confirm(mensaje, function(result) {
                if(result){
                    /* eliminar capa */
                    $.post(siteUrl + 'capas/eliminarSubCapa',{subcapa:id_capa},function(response){
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


    this.eliminarItemSubcapa = function(id_item){
        bootbox.confirm('Desea eliminar este item?',function(result){
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
        });
    }

    this.editarCapa = function(id_capa){
        $("#tab-editar").fadeIn(function(){
            $("#ul-tabs").find('li.active').removeClass('active');
            $("#tab-content").find('div.tab-pane.active').removeClass('active');
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarCapa',{capa:id_capa},function(response){
                $("#div_tab_3").html(response);
                $("#tab3").addClass('active').show();
            },'html');
        });
    };

    this.editarSubCapa = function(id_subcapa){
        $("#tab-editar").fadeIn(function(){
            $("#ul-tabs").find('li.active').removeClass('active');
            $("#tab-content").find('div.tab-pane.active').removeClass('active');
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarSubCapa',{capa:id_subcapa},function(response){
                $("#div_tab_3").html(response);
                $("#tab3").addClass('active').show();
            },'html');
        });
    };


    this.editarItemSubcapa = function(item){
        $("#tab-items-editar").fadeIn(function(){
            $("#tab-items-subcapa").removeClass('active').addClass('disabled');
            $("#tab4").removeClass('active').fadeOut();
            $(this).addClass('active');
            $.post(siteUrl + 'capas/editarItemSubCapa',{item:item},function(response){
                $("#div_tab_5").html(response);
                $("#tab5").addClass('active').fadeIn();
            },'html');
        });
    };


    this.listarItemsSubCapa = function(id_subcapa){
        $("#tab-items-subcapa").fadeIn(function(){
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

        });
    };


    this.guardarItemSubcapa = function(form,btn,item){
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        var params = $(form).serialize();
        $.post(siteUrl + 'capas/guardarItemSubcapa/item/'+item,params,function(response){
            if(response.estado == true){
                bootbox.alert("Operación Exitosa: "+response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                    var subcapa = $("#id_subcapa").val();
                    Layer.cancelarEdicionItem(subcapa)
                });
            }else{
                bootbox.alert("Error en la operación: "+response.mensaje,function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            }
        },'json').fail(function(){
            bootbox.alert("Error en sistema. Intente nuevamente o comuníquese con Soporte",function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        });
    };




    this.cancelarEdicionItem = function(subcapa){
        $("#tab5").fadeOut(function(){
            $("#tab-items-editar").fadeOut(function(){
                $(this).removeClass('active');
                Layer.listarItemsSubCapa(subcapa);
                /*$(this).prev().addClass('active');
                $("#tab4").addClass('active').show(function(){
                    Layer.listarItemsSubCapa(subcapa);
                });*/
            });
        });
    }

    this.initSaveEdicion = function() {

        $("#input-capa-editar").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione una capa GeoJson",
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });

        $('#input-capa-editar').on('filebatchuploadsuccess', function(event, data) {
           
           if(data.response.uploaded==0)//error
           {
               var error_filenames = 'El (los) siguiente(s) archivos no son válidos:<br>';
               $.each(data.response.error_filenames,function(k,v){
                  error_filenames += '-'+v+'<br>'; 
               });

                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: error_filenames,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
           }


           if(data.response.filenames.length==0) return; // no se subio ningun archivo valido

            $("#tmp_file_editar").val(data.response.nombre_cache_id);
           var properties = data.response.properties.data;
           var filename = data.response.filenames.data;
           $("#nombre_geojson").html('');
           
            $('#tabla_propiedades-editar').DataTable().destroy();
            $('#tabla_comunas_editar').DataTable().destroy();
            
            $('#tabla_propiedades-editar').DataTable({
                data: properties,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                bPaginate : false,
                order: [[0, "desc"]],
                initComplete: function(){
                    $("#cargando_geojson_edicion").fadeOut();
                    $('#div_properties-editar').slideDown('slow');
                }
                
            }); 
            $('#tabla_comunas_editar').DataTable({
                data: filename,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]],
                initComplete: function(){
                    $(".iComunas").jCombo(siteUrl + "comuna/json_comunas_usuario");
                   
                    
                    $('#div_comunas_editar').slideDown('slow');

                }
            });
            
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
        $("#tab2 > #div_tab_2").fadeOut(function(){
            $.ajax({
                dataType: "html",
                cache: false,
                async: true,
                data: {id_capa:id_capa},
                type: "post",
                url: siteUrl + "capas/ajax_grilla_capas",
                error: function(xhr, textStatus, errorThrown){

                },
                success:function(html){
                    $("#contenedor-grilla-capas").html(html);
                    $("#resultados_capa").html(' para capa <strong>'+nombre_capa+'</strong>  <button type="button" class="btn btn-sm btn-square btn-success" title="Volver a Listado de Capas" onclick="Layer.volverListadoCapas();"><i class="fa fa-arrow-left"></i></button>');
                    $("#tab2 > #div_tab_2").fadeIn(function(){

                    });
                }
            });
        });
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
                    bootbox.alert(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                        Layer.cancelarEdicion();
                    });
                }else{
                    bootbox.alert(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            },'json').fail(function(){
                bootbox.alert("Error en el sistema. Intente nuevamente",function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
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
    }
    
}).apply(Layer);