var FormEmergenciasEditar = Class({ extends : FormAlarma}, {
    
    /**
     * Identificador de la emergencia
     */
    id_emergencia : null,
    
    /**
     * 
     * @param int value identificador de la emergencia
     * @returns void
     */
    __construct : function(value) {
        this.id_emergencia = value;
    },
    
    /**
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){
       Emergencia.eventoBtnBuscar();
       notificacionCorrecto("Resultado de la operacion", "Se ha insertado correctamente");
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
        
        if($(navItem).attr("href") == "#step-2"){
            yo.btnPaso2();
        }
    },
    
    /**
     * Activa los botones presentes en paso 1
     * @returns {undefined}
     */
    btnPaso1 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        $(path_buttons + "button[data-bb-handler='guardar']").hide();
        $(path_buttons + "button[data-bb-handler='paso3']").hide();
        $(path_buttons + "button[data-bb-handler='paso2']").show();
    },
    
    /**
     * Activa los botones presentes en paso 1
     * @returns {undefined}
     */
    btnPaso2 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        
        if($("#tipo_emergencia").val()== 15){
            $(path_buttons + "button[data-bb-handler='guardar']").hide();
            $(path_buttons + "button[data-bb-handler='paso3']").show();
            $(path_buttons + "button[data-bb-handler='paso2']").hide();
        } else {
            $(path_buttons + "button[data-bb-handler='guardar']").show();
            $(path_buttons + "button[data-bb-handler='paso3']").hide();
            $(path_buttons + "button[data-bb-handler='paso2']").hide();
        }
        
    },
    
    /**
     * Activa los botones presentes en paso 3
     * @returns {undefined}
     */
    btnPaso3 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        $(path_buttons + "button[data-bb-handler='guardar']").show();
        $(path_buttons + "button[data-bb-handler='paso3']").hide();
        $(path_buttons + "button[data-bb-handler='paso2']").hide();
    },
    
    /**
     * Formulario de tipo de emergencia
     * @returns {void}
     */
    bindSelectEmergenciaTipo : function(){
        var yo = this;
        
        $("#tipo_emergencia").on('change', function() {
            var parametros = {"id_tipo" : $(this).val(),
                              "id" : $("#id").val()}
            $.ajax({         
                dataType: "json",
                cache: false,
                async: false,
                data: parametros,
                type: "post",
                url: siteUrl + "emergencia/form_tipo_emergencia", 
                error: function(xhr, textStatus, errorThrown){},
                success:function(data){
                    $("#form-tipo-emergencia").html(data.html);
                    if(data.form){
                        $("#step3-header").show();
                    } else {
                        $("#step3-header").hide();
                    }
                    yo.btnPaso1();
                }
            }); 
        }).change();  
    },
    
    /**
     * 
     * @param {string} form
     * @returns {undefined}
     */
    showPaso3 : function(form){
        var yo = this;
        var parametros = $("#" + form).serializeArray();
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/ajax_validar_informacion_emergencia", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    $('ul.setup-panel li:eq(2)').removeClass('disabled');
                    $('ul.setup-panel li a[href="#step-3"]').trigger('click');
                    yo.btnPaso3();
                } else {
                    $("#" + form + "_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        });   
    },
    
    /**
     * 
     * @returns {Boolean}
     */
    guardar : function(){
        var yo = this;
        
        var parametros = this.getParametros("form_editar_emergencia");

        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/json_guarda_emergencia", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
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
    
    getParametros : function(form){
        var parametros = $.merge(this.super("getParametros", form), $("#form-informacion-emergencia").serializeArray());
        return parametros;
    },
        
    /**
     * Muestra formulario para ingresar nueva emergencia
     * @returns void
     */
    mostrarFormulario : function(id_emergencia){
        
        var yo = this;

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "emergencia/form_editar/id/" + this.id_emergencia , 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                bootbox.dialog({
                    message: html,
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Editar emergencia",
                    buttons: {
                        guardar: {
                            label: " Guardar",
                            className: "btn-success fa fa-check",
                            callback: function() {
                                return yo.guardar();
                            }
                        },  
                        paso2: {
                            label: " Ir al paso 2",
                            className: "btn-primary fa fa-arrow-right",
                            callback: function() {
                                yo.showPaso2("form_editar_emergencia");
                                return false;
                            }
                        },
                        paso3: {
                            label: " Ir al paso 3",
                            className: "btn-primary fa fa-arrow-right",
                            callback: function() {
                                yo.showPaso3("form-informacion-emergencia");
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
                yo.btnPaso1();
                yo.bindMapa();
                yo.callOnShow();
                yo.iniciarUpload();
                yo.dibujaTablaDocs();
            }
        }); 
    },
    
    iniciarUpload : function () {
        var yo = this;
        
        var ala_ia_id = $('#ala_id').val();
        $("#iDocMaterial").fileinput({
            language: "es",
            uploadUrl: siteUrl + "archivo/subir/tipo/5/id/" + ala_ia_id,
            uploadAsync: true,
            multiple: true,
            initialCaption: "Seleccione archivos y luego presione subir",
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object']
        });
        
        $('#iDocMaterial').on('filebatchuploadcomplete', function () {
            yo.dibujaTablaDocs();
        });
    },
    
    dibujaTablaDocs : function () {

        var ala_ia_id = $('#ala_id').val();
        $("#tabla_doc").dataTable().fnDestroy();
        $('#tabla_doc').dataTable({
            ajax: {
                url: siteUrl + 'archivo/getDocs/id/' + ala_ia_id + '/tipo/5',
                type: 'POST',
                async: true
            },
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
             "aoColumns": [
                null,
                null,
                null,
                {"sClass": "text-center"}
            ]
        });
        $("#tabla_doc").wrap("<div class='col-sm-12' style='padding-left:0px !important;'></div>");
    }
    
});


