var FormAlarma = Class({
    
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

            /* obtener correos destinatarios */
            var tipo_emergencia = $(this).val();

            if(tipo_emergencia == "15"){
                $("#caja_correos_evento").hide();
                var comunas_seleccionadas = [];
                $("#comunas_seleccionados option").each(function(){
                    comunas_seleccionadas.push($(this).val());
                });
                /*if(comunas_seleccionadas.length > 0 && tipo_emergencia > 0){
                    $.post(siteUrl + 'alarma/obtenerListadoCorreosAlarma',{tipo_emergencia:tipo_emergencia, comunas_seleccionadas:comunas_seleccionadas},function(response){
                        if(response.correos != ""){
                            $("#correos_alarma").html("Además se dará aviso a los siguientes correos: " + response.correos);
                        }else{
                            $("#correos_alarma").html("");
                        }
                    },'json');
                }else{
                    $("#correos_alarma").html("");
                }*/

                var parametros = {"id_tipo" : $(this).val(),
                                  "id" : $("#ala_id").val()}
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
                        $("#estado_emergencia").val(2);
                        if(data.form){
                            $("#div-pasos").show();
                        } else {
                            $("#div-pasos").hide();
                        }
                        yo.btnPaso1();
                    }
                });
            }else{

                var estado_emergencia = $("#estado_emergencia").val();
                if(estado_emergencia > 1){
                    $("#caja_correos_evento").hide();
                    var comunas_seleccionadas = [];
                    $("#comunas_seleccionados option").each(function(){
                        comunas_seleccionadas.push($(this).val());
                    });
                    /*if(comunas_seleccionadas.length > 0 && tipo_emergencia > 0){
                        $.post(siteUrl + 'alarma/obtenerListadoCorreosAlarma',{tipo_emergencia:tipo_emergencia, comunas_seleccionadas:comunas_seleccionadas},function(response){
                            if(response.correos != ""){
                                $("#correos_alarma").html("Además se dará aviso a los siguientes correos: " + response.correos);
                            }else{
                                $("#correos_alarma").html("");
                            }
                        },'json');
                    }else{
                        $("#correos_alarma").html("");
                    }*/

                    var parametros = {"id_tipo" : $(this).val(),
                        "id" : $("#ala_id").val()}
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
                                $("#div-pasos").show();
                                if(estado_emergencia > 1){
                                    yo.btnPaso1();
                                }
                            } else {
                                $("#div-pasos").hide();
                            }

                        }
                    });
                }else{
                    $("#div-pasos").hide();
                    yo.btnPaso2();
                    if(estado_emergencia == 1){
                        $("#caja_correos_evento").show();
                    }else{
                        $("#caja_correos_evento").hide();
                    }
                }
            }
        }).change();        
    },


    estadoEventoChange : function(){
        var yo = this;
        $("body").on('change','#estado_emergencia',function(){
            var estado = $("#estado_emergencia").val();
            var tipo_emergencia = $("#tipo_emergencia").val();

            if(estado > 1){
                $("#div-pasos").show();
                yo.btnPaso1();
            }else{
                if(tipo_emergencia == 15){
                    xModal.warning('Evento Radiológico debe estar en estado Activo o Finalizado');
                }else{
                    $("#div-pasos").hide();
                    yo.btnPaso2();
                }
            }
        }).change();

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
        $("#comunas").picklist();
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
    
    /**
     * Parche para datos seleccionados del picklist
     * @param {string} form
     * @returns {Array}
     */
    getParametrosFix : function(form){
        var parametros = $("#" + form).serializeArray();
      
        //parche para el picklist
        parametros = jQuery.grep(parametros, function( a ) {
            if(a["name"] != "comunas[]"){
                return true;
            }
        });
        
        $("#comunas_seleccionados > option").each(function(i, opcion){
            parametros.push({"name" : "comunas[]",
                             "value" : $(opcion).attr("value")});
        });
        //************************
        
        return parametros;
    },
    
    getParametros : function(form){
        var parametros = this.getParametrosFix(form);

        
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
        
        var parametros = this.getParametrosFix("form_nueva");

        if($("#correos_evento") !== undefined){
            parametros.push({"name" : "correos_evento",
                "value" : $("#correos_evento").val()});
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
            url: siteUrl + "alarma/form_nueva/" , 
            error: function(xhr, textStatus, errorThrown){

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



$(document).ready(function(){

    $("body").on('click','#picklist-btn-comunas-a, #picklist-btn-comunas-at, #picklist-btn-comunas-q, #picklist-btn-comunas-qt',function(){
        var tipo_emergencia = $("#tipo_emergencia").val();
        var comunas_seleccionadas = [];
        $("#comunas_seleccionados option").each(function(){
            comunas_seleccionadas.push($(this).val());
        });
        if(comunas_seleccionadas.length > 0 && tipo_emergencia > 0){
            $.post(siteUrl + 'alarma/obtenerListadoCorreosAlarma',{tipo_emergencia:tipo_emergencia, comunas_seleccionadas:comunas_seleccionadas},function(response){
                if(response.correos != ""){
                    $("#correos_alarma").html("Además se dará aviso a los siguientes correos: " + response.correos);
                }else{
                    $("#correos_alarma").html("");
                }
            },'json');
        }else{
            $("#correos_alarma").html("");
        }


    })
});

