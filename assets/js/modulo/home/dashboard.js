/**
 * Dashboard front-end
 */

var Dashboard = Class({
    
    // guarda contenido de la pagina
    content: "",

    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        //se cargan dependencias
        $.getScript(baseUrl + "assets/js/modulo/emergencia/form-emergencias-cerrar.js");
        $.getScript(baseUrl + "assets/js/modulo/home/form-emergencias-cerrar-dashboard.js");
        
        this.loadDashboard();
        
        this.bindBtnEmergenciaCerrar();
        this.bindBtnEmergenciaEditar();
        
    },
    
    /**
     * Carga el contenido del dashboard
     * @returns void
     */
    loadDashboard : function(){
        this.loadGraficoEmergenciasMes();
        this.loadGraficoEmergenciasTipo();
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
     * Carga la grilla de alarmas
     * @returns void
     */
    loadGridAlarma : function(){
        var params = {"desde" : $("#fecha_desde").val(),
                      "hasta" : $("#fecha_hasta").val()};
    
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: params,
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
        var params = {"desde" : $("#fecha_desde").val(),
                      "hasta" : $("#fecha_hasta").val()};
    
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: params,
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
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            lang: "es",
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
            ]
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
    
    /**
     * carga el grafico de emergencias por tipo
     * @returns void
     */
    loadGraficoEmergenciasTipo : function(){
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "home/json_cantidad_emergencia_por_tipo", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(retorno){
                if(retorno.correcto){
                    var data = retorno.data;

                    var plotObj = $.plot($("#flot-chart-pie"), data, {
                        series: {
                            pie: {
                                    show: true
                            }
                        },
                        grid: {
                            hoverable: true 
                        },
                        tooltip: true,
                        tooltipOpts: {
                            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                            shifts: {
                                x: 20,
                                y: 0
                            },
                            defaultTheme: false
                        }
                    });  
                }
            }
        }); 
    },
    
    // boton cerrar emergencias
    bindBtnEmergenciaCerrar : function(){
        $(".emergencia-cerrar").livequery(function(){
            $(this).click(function(){
                var id = $(this).attr("data");
                var formulario = new FormEmergenciasCerrarDashboard(id);	
                formulario.mostrarFormulario();
            });
        });
    },
    
    // boton editar emergencias
    bindBtnEmergenciaEditar : function(){
        var yo = this;
        $(".emergencia-editar").livequery(function(){
            $(this).click(function(){
                var id = $(this).attr("data");
                
                yo.limpiarVista();
    
                yo.content = $("#contenedor-home").html();
                $("#contenedor-home").fadeOut(function(){
                    $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
                        $(this).load(siteUrl + 'emergencia/editar/id/' + id);
                    });
                });
            });
        });
        
        $("#btnCancelar").livequery(function(){
            $(this).click(function(){
                $("#contenedor-home").fadeOut(function(){
                    $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
                        $(this).html(yo.content);
                        yo.loadDashboard();
                    });
                });
            });
        });
    },
    
    // se limpia la vista de dashboard
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

$(document).ready(function() {
    var dashboard = new Dashboard();	
});









