var MapaEditor = Class({    
    
    mapa : null,
    class_poligono : null,
    class_marcador : null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.class_marcador = new MapaMarcador();
        this.class_poligono = new MapaPoligono();
    },
    
    iniciarEditor : function (mapa){
        var yo = this;
        this.mapa = mapa;
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: true,
            drawingControlOptions: {
              position: google.maps.ControlPosition.TOP_CENTER,
              drawingModes: [
                google.maps.drawing.OverlayType.MARKER,
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
               // google.maps.drawing.OverlayType.POLYLINE,
                google.maps.drawing.OverlayType.RECTANGLE
              ]
            },
            markerOptions: {icon: baseUrl + 'assets/img/markers/spotlight-poi-black.png'},
            circleOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            polygonOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            rectangleOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            }
        });
        drawingManager.setMap(mapa);
        
        google.maps.event.addListener(drawingManager, 'rectanglecomplete', function(rectangle) {
            rectangle.setOptions({
                id : null,
                custom : true,
                tipo : "RECTANGULO",
                identificador:null,
                capa : null,
                clave : yo.uniqID(20),
                informacion: {"NOMBRE" : "Rectangulo agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            });
            
            var rectanguloClickListener = new  MapaRectanguloClickListener();
            rectanguloClickListener.addClickListener(rectangle, mapa);
            lista_poligonos.push(rectangle);
        });
        
        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            polygon.setOptions({
                id : null,
                custom : true,
                tipo : "POLIGONO",
                identificador:null,
                clave : yo.uniqID(20),
                capa : null,
                informacion: {"NOMBRE" : "Poligono agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            });
            yo.class_poligono.addClickListener(polygon, mapa);
            lista_poligonos.push(polygon);
        });
        
        google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
            circle.setOptions({
                id : null,
                custom : true,
                tipo : "CIRCULO",
                identificador:null,
                clave : yo.uniqID(20),
                capa : null,
                informacion: {"NOMBRE" : "Circulo agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            })
            var circuloClickListener = new MapaCirculoClickListener();
            circuloClickListener.addClickListener(circle, mapa);
            lista_poligonos.push(circle);
        });

    },
    
        
    uniqID : function (len, charSet) {
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz,randomPoz+1);
        }
        
        var elementos = jQuery.grep(lista_poligonos, function( a ) {
            if(a.clave == randomString){
                return true;
            }
        });
        
        if(elementos.length > 0){
            return this.uniqID(20);
        } else {
            return randomString;
        }
    },
    
});


