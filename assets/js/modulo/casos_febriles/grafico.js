$(document).ready(function () {
    
    
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: "",
        type: "post",
        url: baseUrl + getController() + "/json_grafico", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(data){
            var datos = data.estados;
                var chart = AmCharts.makeChart("pie-estados-febriles", {
                    "responsive": {
                        "enabled": true
                    },
                    "type": "pie",
                    "theme": "light",
                    "dataProvider": [{
                        "estado": "Confirmados",
                        "casos": parseInt(datos.positivo)
                    }, {
                        "estado": "Descartados",
                        "casos": parseInt(datos.negativo)
                    }, {
                        "estado": "Sospechosos",
                        "casos": parseInt(datos.sospechoso)
                    }, {
                        "estado": "No concluyentes",
                        "casos": parseInt(datos.no_concluyente)
                    }],
                    "valueField": "casos",
                    "titleField": "estado",
                    "balloon": {
                        "fixedPosition": false
                    },
                    "colors": ["#e74c3c", "#16a085", "#f39c12", "#2980b9"],
                    "export": {
                        "enabled": false
                    },
                    "labelsEnabled": false,
                    "legend": {
                        "position": "bottom",
                        "marginRight": 100,
                        "autoMargins": false
                    },
                    "creditsPosition": "top-right"
                });


                var semanas = data.semanas_labels;
                var semanas_positivo = data.semanas_positivo;
                var semanas_negativo = data.semanas_negativo;
                var semanas_no_concluyente = data.semanas_no_concluyente;
                var semanas_sospechoso = data.semanas_sospechoso;
                var totalSemanas = semanas.length;
                var dataSemanas = [];
                for (var i = 0; i < totalSemanas; i++) {
                    var sem = {
                        "semana": semanas[i] + "º",
                        "positivo": semanas_positivo[i],
                        "negativo": semanas_negativo[i],
                        "no_concluyente": semanas_no_concluyente[i],
                        "sospechoso": semanas_sospechoso[i]
                    };
                    dataSemanas.push(sem);
                }

                var chart = AmCharts.makeChart("bar-semana-estados", {
                    "responsive": {
                        "enabled": true
                    },
                    "type": "serial",
                    "theme": "light",
                    "creditsPosition": "top-right",
                    "legend": {
                        "horizontalGap": 10,
                        "maxColumns": 1,
                        "position": "bottom",
                        "useGraphSettings": true,
                        "markerSize": 10
                    },
                    "dataProvider": dataSemanas,
                    "valueAxes": [{
                        "stackType": "regular",
                        "axisAlpha": 0.3,
                        "gridAlpha": 0,
                        "title": "Nº Casos",
                        "integersOnly": true
                    }],
                    "graphs": [{
                        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                        "fillColors": ["#e74c3c"],
                        "fillAlphas": 1,
                        "labelText": "[[value]]",
                        "lineAlpha": 0.3,
                        "title": "Confirmados",
                        "type": "column",
                        "color": "#ffffff",
                        "valueField": "positivo"
                    }, {
                        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                        "fillColors": ["#16a085"],
                        "fillAlphas": 1,
                        "labelText": "[[value]]",
                        "lineAlpha": 0.3,
                        "title": "Descartados",
                        "type": "column",
                        "color": "#ffffff",
                        "valueField": "negativo"
                    }, {
                        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                        "fillColors": ["#2980b9"],
                        "fillAlphas": 1,
                        "labelText": "[[value]]",
                        "lineAlpha": 0.3,
                        "title": "No Concluyentes",
                        "type": "column",
                        "color": "#ffffff",
                        "valueField": "no_concluyente"
                    }, {
                        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                        "fillColors": ["#f39c12"],
                        "fillAlphas": 1,
                        "labelText": "[[value]]",
                        "lineAlpha": 0.3,
                        "title": "Sospechosos",
                        "type": "column",
                        "color": "#ffffff",
                        "valueField": "sospechoso"
                    }],
                    "categoryField": "semana",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": "Semanas"
                    },
                    "export": {
                        "enabled": true
                    }

                });


                var casos_masculinos = data.confirmados_masculinos;
                var casos_femeninos = data.confirmados_femeninos;
                var dataSemanas = [];
                for (var i = 0; i < totalSemanas; i++) {
                    var sem = {
                        "semana": semanas[i] + "º",
                        "masculino": parseInt(casos_masculinos[i]),
                        "femenino": parseInt(casos_femeninos[i])
                    };
                    dataSemanas.push(sem);
                }

                var chart = AmCharts.makeChart("bar-casos-confirmados-sexo", {
                    "responsive": {
                        "enabled": true
                    },
                    "creditsPosition": "top-right",
                    "type": "serial",
                    "theme": "light",
                    "dataProvider": dataSemanas,
                    "valueAxes": [{
                        "gridAlpha": 0,
                        "title": "Nº Casos",
                        "integersOnly": true
                    }],
                    "gridAboveGraphs": true,
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span></b>",
                        "fillAlphas": 0.8,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "valueField": "masculino",
                        "color": "#ffffff",
                        "fillColors": ["#00a1ff"],
                        "title" : "Masculino"
                    },
                        {
                            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                            "fillAlphas": 0.8,
                            "lineAlpha": 0.2,
                            "type": "column",
                            "valueField": "femenino",
                            "color": "#ffffff",
                            "fillColors": ["#e54b4b"],
                            "title" : "Femenino"
                        }],
                    "chartCursor": {
                        "categoryBalloonEnabled": false,
                        "cursorAlpha": 0,
                        "zoomable": false
                    }
                    ,
                    "categoryField": "semana",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": "Semanas"
                    },
                    "legend": {
                        "horizontalGap": 10,
                        "maxColumns": 1,
                        "position": "bottom",
                        "useGraphSettings": true,
                        "markerSize": 10,
                        "color" : "#000000"
                    },
                    "export": {
                        "enabled": true
                    }

                });

            }
        });
    });
    
    
        
    


