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
            markerOptions: {icon: 'images/beachflag.png'},
            circleOptions: {
                custom : true,
                tipo : "CIRCULO",
                identificador:null,
                capa : null,
                informacion: {"NOMBRE" : "Circulo agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            polygonOptions: {
                custom : true,
                tipo : "POLIGONO",
                identificador:null,
                capa : null,
                informacion: {"NOMBRE" : "Poligono agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            rectangleOptions: {
                custom : true,
                tipo : "RECTANGULO",
                identificador:null,
                capa : null,
                informacion: {"NOMBRE" : "Rectangulo agregado"},
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
            var rectanguloClickListener = new  MapaRectanguloClickListener();
            rectanguloClickListener.addClickListener(rectangle);
            lista_poligonos.push(rectangle);
        });
        
         google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            yo.class_poligono.addClickListener(polygon);
            lista_poligonos.push(polygon);
        });
        
        google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
            var circuloClickListener = new MapaCirculoClickListener();
            circuloClickListener.addClickListener(circle);
            lista_poligonos.push(circle);
        });

    }
    
});


