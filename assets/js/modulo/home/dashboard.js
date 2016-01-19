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
        this.loadMapa();
        this.loadGraficoEmergenciasMes();
        this.loadCalendario();
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
    },
    
    bindBtnEmergenciaReporte : function(){
        var yo = this;
        $(".emergencia-reporte").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: "",
                    type: "post",
                    url: siteUrl + "emergencia_reporte/index/id/" + id, 
                    error: function(xhr, textStatus, errorThrown){

                    },
                    success:function(html){
                        bootbox.dialog({
                            title: "Reporte de emergencia",
                            className: "modal90",
                            message: html,
                            buttons: {
                                correo: {
                                    label: "<i class=\"fa fa-envelope-o\"></i> Enviar correo",
                                    className: "btn-success",
                                    callback: function () {

                                    }
                                },
                                reporte: {
                                    label: "<i class=\"fa fa-envelope-o\"></i> Ver reporte",
                                    className: "btn-warning",
                                    callback: function () {

html2canvas($('#mapa'),
{
  proxy : "/emergencias/html2canvas.proxy.php",
  useCORS: true,
  onrendered: function(canvas)
  {
    var img = canvas.toDataURL()
    window.open(img);
  }
});
                                    }
                                },
                                danger: {
                                    label: "<i class=\"fa fa-close\"></i> Cerrar",
                                    className: "btn-white"
                                }
                            }

                        });
                    }
                });
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
                            label: "Aceptar",
                            className: "btn-primary",
                            callback: function () {
                                $.get(siteUrl + 'emergencia/eliminarEmergencia/id/' + id).done(function (retorno) {
                                    if (retorno == 0) { // sin error
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Se eliminó correctamente',
                                            buttons: {
                                                danger: {
                                                    label: "Cerrar",
                                                    className: "btn-info",
                                                    callback: function () {
                                                        yo.loadGridEmergencia();
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Error al eliminar',
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
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-default"
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
                            label: "Aceptar",
                            className: "btn-primary",
                            callback: function () {
                                $.get(siteUrl + 'alarma/eliminarAlarma/id/' + id).done(function (retorno) {
                                    if (retorno == 0) { // sin error
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Se eliminó correctamente',
                                            buttons: {
                                                danger: {
                                                    label: "Cerrar",
                                                    className: "btn-info",
                                                    callback: function () {
                                                        yo.loadGridAlarma();
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Error al eliminar',
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
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-default"
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
                var formulario = new FormEmergenciasCerrarDashboard(id, yo);	
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
                var formulario = new FormEmergenciasNuevaDashboard(id, yo);	
                formulario.mostrarFormulario();
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
                var formulario = new FormEmergenciasEditarDashboard(id, yo);	
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









