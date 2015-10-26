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
    
    this.guardar = function (){
        if(!Utils.validaForm('form_capas'))
            return;
        var params = $('#form_capas').serialize();
        
        params += "&items="+parseInt($('#tabla_comunas tr').length-1); 
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
                                location.reload();
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
                            className: "btn-danger"
                           
                        }
                    }
                });
                
                
            }
            
        });
        
        
        
        
    }    
    
}).apply(Layer);