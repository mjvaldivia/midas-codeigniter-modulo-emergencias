/**
 * Created by claudio on 15-09-15.
 */
var Layer = {};

(function() {

    this.initList = function() {
        $("#tblCapas").DataTable({
            ajax: {
                url: siteUrl + 'capas/getCapas',
                type: 'POST',

                async: true
            },
            destroy: true,
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            }
        });
    };

    this.initSave = function() {
        $("#input-icon").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione Icono",
            allowedFileTypes: ['image'],
            uploadUrl: siteUrl + "emergencia/subir_IconTemp",
            dropZoneTitle:''
        });
        

        $("#input-capa").fileinput({
            language: "es",
            multiple: true,
            uploadAsync: true,
            initialCaption: "Seleccione una o varias capas GeoJson",
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });
        
        $('#input-icon').on('filebatchuploadsuccess', function(event, data) {
            $('#icon').val(data.response.nombre_cache_id);
            $('#img_icon').attr('src',baseUrl+''+data.response.ruta);
            
        });
        
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
           
           var properties = data.response.properties.data;
           var filename = data.response.filenames.data;
           
           
            $('#tabla_propiedades').DataTable().destroy();
            $('#tabla_comunas').DataTable().destroy();
            
            $('#tabla_propiedades').DataTable({
                data: properties,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                bPaginate : false,
                order: [[0, "desc"]],
                initComplete: function(){$('#div_properties').slideDown('slow');}
                
            }); 
            $('#tabla_comunas').DataTable({
                data: filename,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]],
                initComplete: function(){
                    $(".iComunas").jCombo(siteUrl + "session/obtenerJsonComunas");
                   
                    
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
        
        if(form.capa_edicion === undefined){
            params += "&items="+parseInt($('#tabla_comunas tr').length-1); 
        }else{
            params += "&items="+parseInt($('#tabla_comunas_editar tr').length-1); 
        }
        
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
                    message: 'Una o más capas no se han guardado',
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
                var mensaje = 'La capa a eliminar se encuentra asociada a una Emergencia. Desea eliminarla de todas formas?';
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


    this.initSaveEdicion = function() {
        $("#input-icon-editar").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione Icono",
            allowedFileTypes: ['image'],
            uploadUrl: siteUrl + "emergencia/subir_IconTemp",
            dropZoneTitle:''
        });
        

        $("#input-capa-editar").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: true,
            initialCaption: "Seleccione una o varias capas GeoJson",
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });
        
        $('#input-icon-editar').on('filebatchuploadsuccess', function(event, data) {
            $('#icon-editar').val(data.response.nombre_cache_id);
            $('#img_icon_editar').attr('src',baseUrl+''+data.response.ruta);
            
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
                initComplete: function(){$('#div_properties-editar').slideDown('slow');}
                
            }); 
            $('#tabla_comunas_editar').DataTable({
                data: filename,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]],
                initComplete: function(){
                    $(".iComunas").jCombo(siteUrl + "session/obtenerJsonComunas");
                   
                    
                    $('#div_comunas_editar').slideDown('slow');

                }
            });
            
        });
    };   


    this.cancelarEdicion = function(){
        $("#tab3").fadeOut(function(){
            $("#tab-editar").fadeOut(function(){
                $(this).removeClass('active');
                $(this).prev().addClass('active');    
                $("#tab2").addClass('active').show();
            });
        });

    } ;
    
}).apply(Layer);