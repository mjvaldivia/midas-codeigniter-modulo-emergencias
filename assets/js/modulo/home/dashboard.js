/**
 * Dashboard front-end
 */

var Dashboard = Class({
        
    // guarda contenido de la pagina
    content: "",
    mapa_calendario : null,

    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        $(window).scrollTop(0);
        this.loadDashboard();
        
        this.bindBtnEmergenciaFinalizar();
        this.bindBtnEmergenciaEditar();
        this.bindBtnEmergenciaNueva();
        this.bindBtnEmergenciaReporte();
        this.bindBtnAlarmaEliminar();
        this.bindBtnEmergenciaEliminar();
        
    },
    
    /**
     * Carga el contenido del dashboard
     * @returns void
     */
    loadDashboard : function(){
        //this.loadMapa();
        //this.loadGraficoEmergenciasMes();
        //this.loadCalendario();
        this.loadGrid();
        
    },
    
    /**
     * Carga las grillas de alarmas y emergencias
     * @returns void
     */
    loadGrid : function(){
        this.loadGridEmergencia();
        this.loadGridAlarma();
    },
    
    /**
     * Carga mapa de emergencias
     * @returns {void}
     */
    loadMapa : function(){
        var mapa = new HomeMapa("mapa-emergencias");
        
        //centra el mapa en ubicacion por defecto
        mapa.setLatitudLongitudUTM(6340442, 256029);
        
        mapa.initialize();
        
        
        this.mapa_calendario = mapa;
    },
    
    /**
     * Carga la grilla de alarmas
     * @returns void
     */
    loadGridAlarma : function(){
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "home/ajax_grilla_alarmas", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contendor-grilla-alarma").html(html);
            }
        });
    },
    
    /**
     * Carga la grilla de emergencias en curso
     * @returns void
     */
    loadGridEmergencia : function(){
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "home/ajax_grilla_emergencias", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contendor-grilla-emergencia").html(html);
            }
        });
    },
    
    /**
     * Carga el calendario
     * @returns void
     */
    loadCalendario : function(){
        
        var yo = this;

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            lang: "es",
            selectable : true,
            editable: false,
            droppable: false, 
            eventSources: [
                {
                    url: siteUrl + 'home/json_eventos_calendario_alertas',
                    type: 'POST',
                    error: function() {
                        alert('Ha ocurrido un error al cargar las alarmas al calendario!');
                    },
                    color: 'orange',  
                    textColor: 'black'
                },
                {
                    url: siteUrl + 'home/json_eventos_calendario_emergencias',
                    type: 'POST',
                    error: function() {
                        alert('Ha ocurrido un error al cargar las emergencias al calendario!');
                    },
                    color: 'red',   
                    textColor: 'white' 
                }
            ],
            eventClick: function(event, jsEvent, view) {
                var id = event.id;
                
                if(event.tipo == 2){
                    yo.mapa_calendario.selectMarkerEmergenciaById(id);
                } else {
                    yo.mapa_calendario.selectMarkerAlarmaById(id);
                }
            },
            viewRender : function(view, element){
                yo.mapa_calendario.loadMarkers(view.start, view.end);
            }
        });
    },
    
    /**
     * Carga grafico de emergencias por mes
     * @returns void
     */
    loadGraficoEmergenciasMes : function(){
        if($("#morris-chart-line").length > 0){
            $.ajax({         
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "home/json_cantidad_emergencia_mes", 
                error: function(xhr, textStatus, errorThrown){

                },
                success:function(data){
                    if(data.correcto){
                        var months = ['En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                        Morris.Line({
                            element: 'morris-chart-line',
                            data: data.data,
                            xkey: 'm',
                            hideHover: true,
                            ykeys: data.ykeys,
                            labels: data.labels,
                            xLabelFormat: function (x) {
                                return months[x.getMonth()]; 
                            },
                            smooth: false,
                            resize: false
                        });
                    }
                }
            });
        }
    },
    
    bindBtnEmergenciaReporte : function(){
        var yo = this;
        $(".emergencia-reporte").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                var reporte = new EventoReporteForm();	
                reporte.seteaEmergencia(id);
                reporte.mostrar();                
            });
        });
    },
    
    bindBtnEmergenciaEliminar : function(){
        var yo = this;
        $(".emergencia-eliminar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Eliminar elemento",
                    message: '¿Está seguro que desea eliminar esta emergencia?',
                    buttons: {
                        success: {
                            label: "<i class=\"fa fa-trash\"></i> Eliminar",
                            className: "btn-danger",
                            callback: function () {
                                var parametros = {"id" : id};
                                $.ajax({         
                                    dataType: "json",
                                    cache: false,
                                    async: true,
                                    data: parametros,
                                    type: "post",
                                    url: siteUrl + "evento/eliminar", 
                                    error: function(xhr, textStatus, errorThrown){
                                        notificacionError("Error", "Ha ocurrido un error al eliminar el evento");
                                    },
                                    success:function(data){
                                        if(data.correcto){
                                            yo.loadGridEmergencia();
                                            notificacionCorrecto("Resultado de la operacion", "Se ha eliminado el evento correctamente");
                                        } else {
                                            notificacionError("Error", "Ha ocurrido un error al eliminar el evento");
                                        }
                                    }
                                });
                                
                                
                                
                            }
                        },
                        danger: {
                            label: "<i class=\"fa fa-remove\"></i> Cancelar",
                            className: "btn-white"
                        }
                    }

                });
            });
        });
    },
    
    bindBtnAlarmaEliminar : function(){
        var yo = this;
        $(".alarma-eliminar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Eliminar elemento",
                    message: '¿Está seguro que desea eliminar esta alarma?',
                    buttons: {
                        success: {
                            label: "<i class=\"fa fa-trash\"></i> Eliminar",
                            className: "btn-danger",
                            callback: function () {
                                var parametros = {"id" : id};
                                $.ajax({         
                                    dataType: "json",
                                    cache: false,
                                    async: true,
                                    data: parametros,
                                    type: "post",
                                    url: siteUrl + "evento/eliminar", 
                                    error: function(xhr, textStatus, errorThrown){
                                        notificacionError("Error", "Ha ocurrido un error al eliminar el evento");
                                    },
                                    success:function(data){
                                        if(data.correcto){
                                            yo.loadGridAlarma();
                                            notificacionCorrecto("Resultado de la operacion", "Se ha eliminado el evento correctamente");
                                        } else {
                                            notificacionError("Error", "Ha ocurrido un error al eliminar el evento");
                                        }
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "<i class=\"fa fa-remove\"></i> Cancelar",
                            className: "btn-white"
                        }
                            }
                }); 
            });
        });
    },
    
    /**
     * Asocia el evento para desplegar formulario para finalizar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEmergenciaFinalizar : function(){
        var yo = this;
        
        $(".emergencia-cerrar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                
                var formulario = new EventoFormFinalizar({
                    "id" : id,
                    callBack : function(){
                        yo.loadGridEmergencia();
                        notificacionCorrecto("Resultado de la operacion", "Se ha finalizado el evento correctamente");
                    }
                });	
                formulario.mostrarFormulario();
            });
        });
    },
    
    /**
     * Asocia el evento para desplegar formulario para ingresar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEmergenciaNueva : function(){
        var yo = this;
        
        $(".emergencia-nueva").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Activar evento",
                    message: '¿Está seguro que desea activar la emergencia?',
                    buttons: {
                        success: {
                            label: "Activar",
                            className: "btn-success",
                            callback: function () {
                                var parametros = {"emergencia": id}
                                $.ajax({         
                                    dataType: "json",
                                    cache: false,
                                    async: false,
                                    data: parametros,
                                    type: "post",
                                    url: siteUrl + 'evento/ajax_activar_emergencia', 
                                    error: function(xhr, textStatus, errorThrown){
                                        notificacionError("Error", "Ha ocurrido un error al activar la emergencia");
                                    },
                                    success:function(data){
                                        if(data.estado == true){
                                            yo.loadGridAlarma();
                                            yo.loadGridEmergencia();
                                            notificacionCorrecto("Resultado de la operacion", "Se ha activado el evento correctamente");
                                        } else {
                                            notificacionError("Error", "Ha ocurrido un error al activar la emergencia");
                                        }
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-white"
                        }
                    }
                }); 
                
            });
        });
        
    },
    
    /**
     * Asocia el evento para desplegar formulario para editar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEmergenciaEditar : function(){
        var yo = this;
        $(".emergencia-editar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(){
                var id = $(this).attr("data");
                var formulario = new EventoFormEditar({
                    "id" : id,
                    callBackGuardar : function(){
                        yo.loadGridEmergencia();
                        notificacionCorrecto("Resultado de la operacion", "Se ha editado el evento correctamente");
                    }
                });	
                formulario.mostrarFormulario();
            });
        });
    },
    
    /**
     * Se limpia la vista
     * @returns {void}
     */
    limpiarVista : function(){
        
        var spinner = "<div class=\"col-lg-12 text-center\">"
                    + "<i class=\"fa fa-4x fa-spin fa-spinner\"></i>"
                    + "</div>";
        
        $("#calendar").html("");
        $("#morris-chart-line").html("");
        $("#contendor-grilla-alarma").html(spinner);
        $("#contendor-grilla-emergencia").html(spinner); 
    }
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var dashboard = new Dashboard();	
});









