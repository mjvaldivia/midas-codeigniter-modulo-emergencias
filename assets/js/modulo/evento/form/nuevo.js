var EventoFormNuevo = Class({
    
    /**
     * Identificador emergencia radiologica
     */
    tipo_emergencia_radiologica : 15,
    
    /**
     * Identificador estado de emergencia activada
     */
    estado_emergencia_activada : 2,
    
    /**
     * Identificador de la alarma
     */
    id_alarma : null,
    
    /**
     * Mapa de google
     */
    mapa : null,
    
    /**
     * si se envio o no correctamente el email
     */
    bo_email_enviado : false,
    
    /**
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){},
    
    /**
     * 
     * @param int value identificador de alarma
     * @returns void
     */
    __construct : function(options) {
        this.id_alarma = options.id;
        this.callBackGuardar = options.callBackGuardar;
    },
    
    bindUpload : function (){
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
                        + "<div id=\"archivo-" + data.response.hash + "\">"
                        + "<input type=\"hidden\" name=\"archivos[]\" value=\"\" />"
                        + "<input type=\"hidden\" name=\"archivos_hash[]\" value=\""+data.response.hash+"\" />"
                        + "<hr/>"
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
                        + "<button class=\"btn btn-xs btn-danger quitar-archivo\"> <i class=\"fa fa-remove\"></i> </button>"
                        + "</div>" 
                        + "</div>"
                        + "</div>"
                );
                
                
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
                $(this).parent().parent().remove();
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

    /**
     * Formulario de tipo de emergencia
     * @returns {void}
     */
    bindSelectEmergenciaTipo : function(){
        var yo = this;
        
        $("#tipo_emergencia").on('change', function() {
           
            var tipo_emergencia = $(this).val();
            
            if(tipo_emergencia == yo.tipo_emergencia_radiologica){
                $("#estado_emergencia").val(yo.estado_emergencia_activada);
                $("#estado_emergencia").trigger("change");
            }
            
            var parametros = {"id_tipo" : $(this).val(),
                              "id" : $("#eme_id").val()}
            $.ajax({
                dataType: "json",
                cache: false,
                async: false,
                data: parametros,
                type: "post",
                url: siteUrl + "evento/form_tipo_emergencia",
                error: function(xhr, textStatus, errorThrown){},
                success:function(data){

                    $("#form-tipo-emergencia").html(data.html);

                    if(data.form){
                        if($("#estado_emergencia").val()>1){
                            $("#div-pasos").show();
                        }
                    } else {
                        $("#div-pasos").hide();
                    }
                    yo.btnPaso1();
                    yo.bindUpload();
                }
            });
        });      
    },

    /**
     * 
     * @returns {undefined}
     */
    estadoEventoChange : function(){
        var yo = this;
        $("body").on('change','#estado_emergencia',function(){
            var estado = $("#estado_emergencia").val();
            var tipo_emergencia = $("#tipo_emergencia").val();
            $("#caja_correos_evento").hide();
            if(estado > 1){
                $("#div-pasos").show();
                yo.btnPaso1();
            }else{
                if(tipo_emergencia == yo.tipo_emergencia_radiologica){
                    xModal.warning('Evento Radiológico debe estar en estado Activo o Finalizado');
                }else{
                    $("#div-pasos").hide();
                    yo.btnPaso2();
                    $("#caja_correos_evento").show();
                }
            }
        });
    },
    
    /**
     * Activa los botones presentes en el paso 2
     * @returns {undefined}
     */
    btnPaso2 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        $(path_buttons + "button[data-bb-handler='guardar']").show();
        $(path_buttons + "button[data-bb-handler='paso2']").hide();
    },
    
    /**
     * Activa los botones presentes en paso 1
     * @returns {undefined}
     */
    btnPaso1 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        
        if($("#tipo_emergencia").val() != ""){
            $(path_buttons + "button[data-bb-handler='guardar']").hide();
            $(path_buttons + "button[data-bb-handler='paso2']").show();
        } else {
            $(path_buttons + "button[data-bb-handler='guardar']").show();
            $(path_buttons + "button[data-bb-handler='paso2']").hide();
        }
    },
        
    /**
     * Configura los steps
     * @returns {void}
     */
    configSteps : function(){
        var yo = this;
        var navListItems = $('ul.setup-panel li a'),
            allWells = $('.setup-content');

        allWells.hide();

        navListItems.click(function(e)
        {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this).closest('li');

            if (!$item.hasClass('disabled')) {
                navListItems.closest('li').removeClass('active');
                $item.addClass('active');
                allWells.hide();
                $target.show();
                
                yo.controlBackSteps(this);
                
                                           
            }
        });

        $('ul.setup-panel li.active a').trigger('click');
        $('ul.setup-panel li').click(function(){
            $(this).nextAll("li").each(function(){
                $(this).addClass("disabled");
            });
        });
    },
    
    /**
     * Control de click al retornar
     * @param {object} navItem
     * @returns {undefined}
     */
    controlBackSteps : function(navItem){
        var yo = this;
        if($(navItem).attr("href") == "#step-1"){
            yo.btnPaso1();
        }
    },
        
    /**
     * Se recarga lista con resultados de busqueda
     * @returns void
     */
    recargaGrilla : function(){
        $("#btnBuscarAlarmas").trigger("click");
    },
        
    /**
     * 
     * @returns {undefined}
     */
    bindMapa : function(){
        var mapa = new MapaFormulario("mapa");
        mapa.seteaPlaceInput("nombre_lugar");
        
        if($("#longitud").val() != "" && $("#latitud").val() != ""){
            mapa.setLongitud($("#longitud").val());
            mapa.setLatitud($("#latitud").val());
            
            /*if($("#geozone").val() == ""){
                $.ajax({         
                    dataType: "json",
                    cache: false,
                    async: false,
                    data: "",
                    type: "post",
                    url: siteUrl + "session/getMinMaxUsr", 
                    error: function(xhr, textStatus, errorThrown){

                    },
                    success:function(data){
                        $("#geozone").val(data.com_c_geozone);
                    }
                }); 
            } 
            
            mapa.setGeozone($("#geozone").val());*/
        }

        mapa.inicio();
        mapa.cargaMapa(); 
    } ,
    

    /**
     * Retorna parametros del formulario
     * @param {type} form
     * @returns {Array}
     */
    getParametros : function(form){
        //var parametros = this.getParametrosFix(form);
        var parametros = $("#" + form).serializeArray();
        
        $("#form-tipos-emergencia").find("input , .form-control , input[type='radio'], input[type='checkbox']").each(function(){
            if($(this).attr("type") == "radio" || $(this).attr("type") == "checkbox"){
                if($(this).is(':checked')){
                    parametros.push({
                        "name"  : $(this).attr("name"),             
                        "value" : $(this).val()
                    });
                }
            } else {
                parametros.push({
                    "name"  : $(this).attr("name"),
                    "value" : $(this).val()
                });
            }            
        });
        
        return parametros;
    },
    
    /**
     * 
     * @returns {Boolean}
     */
    guardar : function(){
        var yo = this;
        
        var parametros = this.getParametros("form_nueva");

        if($("#correos_evento") !== undefined){
            parametros.push({
                "name" : "correos_evento",
                "value" : $("#correos_evento").val()
            });
        }

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "evento/guardar", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.bo_email_enviado = data.res_mail;
                    yo.callBackGuardar(yo.bo_email_enviado);
                    salida = true;
                } else {
                    console.log("Se muestran errores");
                    $("#form_nueva_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    /**
     * Se llama al mostrar formulario
     * @returns {undefined}
     */
    callOnShow : function(){
        this.configSteps();
        this.bindSelectEmergenciaTipo();
        this.estadoEventoChange();
    },
    
    /**
     * Carga el paso 2 del formulario
     * @param {type} form
     * @returns {undefined}
     */
    showPaso2 : function(form){
        var yo = this;
        
        var parametros = $("#" + form).serializeArray();
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "evento/ajax_validar_datos_generales", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    $('ul.setup-panel li:eq(1)').removeClass('disabled');
                    $('ul.setup-panel li a[href="#step-2"]').trigger('click');
                    yo.btnPaso2();
                } else {
                    $("#" + form + "_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        });   
    },
    
    /**
     * Muestra formulario para ingresar nueva emergencia
     * @returns void
     */
    mostrarFormulario : function(){
        
        var yo = this;

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "evento/nueva/" , 
            error: function(xhr, textStatus, errorThrown){
                console.error(errorThrown);
            },
            success:function(html){
                bootbox.dialog({
                    message: html,
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Nuevo Evento",
                    buttons: {
                        guardar: {
                            label: " Guardar Evento",
                            className: "btn-success fa fa-check",
                            callback: function() {
                                return yo.guardar();
                            }
                        },
                        paso2: {
                            label: " Ir al paso 2",
                            className: "btn-primary fa fa-arrow-right",
                            callback: function() {
                                yo.showPaso2("form_nueva");
                                return false;
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
                yo.bindMapa();
                yo.callOnShow();
            }
        }); 
    }
});

