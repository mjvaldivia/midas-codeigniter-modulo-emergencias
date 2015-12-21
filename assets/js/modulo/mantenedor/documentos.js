var MantendorDocumentos = Class({
    
    drop_zone : null,
    
    /**
     * 
     * @param int value identificador de alarma
     * @returns void
     */
    __construct : function(value) {
        this.loadGridArchivos();
        this.bindDropzone();
        this.bindArchivos();
        
    },
    
    bindArchivos : function(){
        
        var yo = this;
        
        $(".seleccion-archivo").livequery(function(){
           $(this).unbind("click");
           $(this).click(function(){
               
                var checked = 0;
                if($(this).is(":checked")){
                    checked = 1;
                }
               
                $.ajax({         
                    dataType: "json",
                    cache: false,
                    async: false,
                    data: "id=" + $(this).val() + "&seleccionado=" + checked,
                    type: "post",
                    url: siteUrl + "mantenedor_documentos/selecciona_archivo", 
                    error: function(xhr, textStatus, errorThrown){},
                    success:function(data){
                        if(data.cantidad > 0){
                            $("#seleccionadas-cantidad").html(data.cantidad);
                            $("#div-archivos-seleccionados").removeClass("hidden");
                        } else {
                            $("#seleccionadas-cantidad").html("0");
                            $("#div-archivos-seleccionados").addClass("hidden");
                        }
                    }
                }); 
           });
        });
        
        $("#delete-all").click(function(){
            bootbox.dialog({
                message: "¿Realmente desea eliminar los archivos seleccionados?",
                title: "Eliminar archivos",
                buttons: {
                    guardar: {
                        label: " Eliminar",
                        className: "btn-success fa fa-check",
                        callback: function() {
                            return yo.eliminarArchivos();
                        }
                    },
                    cerrar: {
                        label: " Cancelar",
                        className: "btn-white fa fa-close",
                        callback: function() {

                        }
                    }
                }
            });
        });
        
        $("#clear-all").click(function(){
            $.ajax({         
                dataType: "json",
                cache: false,
                async: false,
                data: "",
                type: "post",
                url: siteUrl + "mantenedor_documentos/limpiar_seleccion", 
                error: function(xhr, textStatus, errorThrown){},
                success:function(data){
                    $("#seleccionadas-cantidad").html("0");
                    $("#div-archivos-seleccionados").addClass("hidden");
                    $(".seleccion-archivo").prop( "checked", false );
                }
            }); 
        });
    },
    
    /**
     * Elimina los archivos seleccionados
     * @returns {undefined}
     */
    eliminarArchivos : function(){
        
        var yo = this;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "",
            type: "post",
            url: siteUrl + "mantenedor_documentos/eliminar_seleccion", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                $("#seleccionadas-cantidad").html("0");
                $("#div-archivos-seleccionados").addClass("hidden");
                $(".seleccion-archivo").prop( "checked", false );
                yo.loadGridArchivos();
            }
        });   
    },
    
    /**
     * Carga el plugin para el upload
     * @returns {undefined}
     */
    bindDropzone : function(){
        var yo = this;
        
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#my-awesome-dropzone", {
            dictDefaultMessage : "Mueva los archivos aquí o haga click para subir",
            previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <i class=\"fa fa-check\"></i>\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <i class\"fa fa-remove\"></i>\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>"
        });

        myDropzone.on("complete", function() {
            yo.loadGridArchivos();
        });

        $("#clear-files").click(function() {
            var files = myDropzone.getAcceptedFiles();
            $.each(files, function( index, value ) {
                myDropzone.removeFile(value);
            });
        });
    },
    
    /**
     * Carga la grilla de emergencias en curso
     * @returns void
     */
    loadGridArchivos : function(){
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "mantenedor_documentos/ajax_grilla_documentos", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(html){
                $("#div-grilla-documentos").html(html);
            }
        });
    }
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var upload = new MantendorDocumentos();	
});

