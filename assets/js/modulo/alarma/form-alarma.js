var FormAlarma = Class({
    
    tipo_emergencia_radiologica : 15,
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
     * 
     * @param int value identificador de alarma
     * @returns void
     */
    __construct : function(value) {
        this.id_alarma = value;
        
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
                url: siteUrl + "alarma/form_tipo_emergencia",
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
                }
            });
        });      
    },


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
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){
       this.recargaGrilla();
        
        var agregar = "";
        if(this.bo_email_enviado){
            agregar = "<br/> Estado email: Enviado correctamente";
        } else {
            notificacionError("Estado del envío de email", "Ha ocurrido un error al enviar el email")
        }
        
        notificacionCorrecto("Resultado de la operacion", "Se ha insertado correctamente" + agregar);
    },
    
    /**
     * Se recarga lista con resultados de busqueda
     * @returns void
     */
    recargaGrilla : function(){
        $("#btnBuscarAlarmas").trigger("click");
    },
        
    /**
     * Se asigna plugin picklist a combo de comunas
     * @returns void
     */
    bindComunasPicklist : function(){
        //$("#comunas").picklist();
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindMapa : function(){
        var mapa = new AlarmaMapa("mapa");
       
        if($("#longitud").val() != "" && $("#latitud").val() != ""){
            mapa.setLongitud($("#longitud").val());
            mapa.setLatitud($("#latitud").val());
            
            if($("#geozone").val() == ""){
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
            
            mapa.setGeozone($("#geozone").val());
        }

        mapa.inicio();
        mapa.cargaMapa(); 
    } ,
    

    
    getParametros : function(form){
        //var parametros = this.getParametrosFix(form);
        var parametros = $("#" + form).serializeArray();
        
        $("#form-tipos-emergencia").find(".form-control , input[type='radio'], input[type='checkbox']").each(function(){
            
            if($(this).attr("type") == "radio" || $(this).attr("type") == "checkbox"){
                if($(this).is(':checked')){
                    parametros.push({"name"  : $(this).attr("name"),
                                     "value" : $(this).val()});
                }
            } else {
            parametros.push({"name"  : $(this).attr("name"),
                             "value" : $(this).val()});
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

        if($("#estado_emergencia").val() > 1){
            var parametros_emergencia = this.getParametrosFix("form-tipos-emergencia");
            for(var i=0; i<parametros_emergencia.length; i++){
                parametros.push(parametros_emergencia[i]);
            }
        }

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "alarma/guardaAlarma", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.bo_email_enviado = data.res_mail;
                    yo.callBackGuardar();
                    salida = true;
                } else {
                    $("#form_nueva_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    callOnShow : function(){
        this.configSteps();
        this.bindComunasPicklist();
        this.bindSelectEmergenciaTipo();
        this.estadoEventoChange();
    },
    
    showPaso2 : function(form){
        var yo = this;
        
        var parametros = $("#" + form).serializeArray();
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "alarma/ajax_validar_datos_generales", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    $('ul.setup-panel li:eq(1)').removeClass('disabled');
                    $('ul.setup-panel li a[href="#step-2"]').trigger('click');
                    yo.btnPaso2();
                } else {
                    $("#" + form + "_error").addClass("hidden");
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