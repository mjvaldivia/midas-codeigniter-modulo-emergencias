/**
 * Created by claudio on 15-09-15.
 */
var Layer = {};

(function() {
    this.initList = function() {
        $("#tblCapas").DataTable({
            dom: "B<'separator'><'row'<'col-md-6'l><'col-md-6 text-right'f>>rtip",
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
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object'],
            uploadUrl: siteUrl + "archivo/subir/"
        });
        

        $("#input-capa").fileinput({
            language: "es",
            multiple: true,
            uploadAsync: true,
            initialCaption: "Seleccione una o varias capas GeoJson",
            uploadUrl: siteUrl + "emergencia/subir_CapaTemp"
        });
        
        
        
        $('#input-capa').on('filebatchuploadsuccess', function(event, data) {
           
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
    
        
    
}).apply(Layer);