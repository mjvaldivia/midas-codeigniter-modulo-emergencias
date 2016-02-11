var ruler_marker_start = null;
var ruler_marker_end   = null;
var ruler_drawing_manager = null;
var ruler_linea = null;
var ruler_label1 = null;
var ruler_label2 = null;

var GoogleMapsRuler = Class({    
    
    mapa: null,
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(mapa) {
        this.mapa = mapa;
    },
    
    /**
     * Carga boton de regla
     * @returns {undefined}
     */
    button : function(){
        var customControlDiv = document.createElement('div');
        var customControl = new rulerControl(customControlDiv, this.mapa);
        customControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(customControlDiv);
    },
    
    /**
     * Click en boton de regla
     * @returns {undefined}
     */
    click : function(){
        this.primerMarcador();
    },
    
    /**
     * Elimina regla
     * @returns {undefined}
     */
    borrarRegla : function(){
        if(ruler_marker_start != null){
            ruler_marker_start.setMap(null);
        }
        
        if(ruler_marker_end != null){
            ruler_marker_end.setMap(null);
        }
        
        if(ruler_drawing_manager != null){
            ruler_drawing_manager.setMap(null);
        }
        
        if(ruler_linea != null){
            ruler_linea.setMap(null);
        }
        
        if(ruler_label1 != null){
            ruler_label1.setMap(null);
        }
        
        if(ruler_label2 != null){
            ruler_label2.setMap(null);
        }
    },
    
    /**
     * Crea primer marcador
     * @returns {undefined}
     */
    primerMarcador : function(){
        
        this.borrarRegla();
        
        var yo = this;
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                ]
            },
            markerOptions: {
                draggable: true,
                icon: baseUrl + "assets/img/ruler_marker.png"
            }
        });
        drawingManager.setMap(this.mapa);
        
        google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
            drawingManager.setMap(null);
            delete drawingManager;
            ruler_marker_start = marker;
            yo.segundoMarcador();
        });
        
        ruler_drawing_manager = drawingManager;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    segundoMarcador : function(){
        var yo = this;
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                ]
            },
            markerOptions: {
                draggable: true,
                icon: baseUrl + "assets/img/ruler_marker.png"
            }
        });
        drawingManager.setMap(this.mapa);
        
        google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
            drawingManager.setMap(null);
            delete drawingManager;
            ruler_marker_end = marker;

            var ruler1label = new Label({ map: yo.mapa });
            var ruler2label = new Label({ map: yo.mapa });
            ruler1label.bindTo('position', ruler_marker_start, 'position');
            ruler2label.bindTo('position', ruler_marker_end, 'position');

            var rulerpoly = new google.maps.Polyline({
                path: [ruler_marker_start.position, ruler_marker_end.position] ,
                strokeColor: "#FFFF00",
                strokeOpacity: .7,
                strokeWeight: 8
            });
            rulerpoly.setMap(yo.mapa);

            ruler1label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));
            ruler2label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));

            google.maps.event.addListener(ruler_marker_start, 'drag', function() {
                rulerpoly.setPath([ruler_marker_start.getPosition(), ruler_marker_end.getPosition()]);
                ruler1label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));
                ruler2label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));
            });
            
            google.maps.event.addListener(ruler_marker_start, 'rightclick', function() {
                yo.borrarRegla();
            });

            google.maps.event.addListener(ruler_marker_end, 'drag', function() {
                rulerpoly.setPath([ruler_marker_start.getPosition(), ruler_marker_end.getPosition()]);
                ruler1label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));
                ruler2label.set('text',distance( ruler_marker_start.getPosition().lat(), ruler_marker_start.getPosition().lng(), ruler_marker_end.getPosition().lat(), ruler_marker_end.getPosition().lng()));
            });
            
            google.maps.event.addListener(ruler_marker_end, 'rightclick', function() {
                yo.borrarRegla();
            });
            
            ruler_label1 = ruler1label;
            ruler_label2 = ruler2label;
            ruler_linea = rulerpoly;
        });
        
        ruler_drawing_manager = drawingManager;
    }
    
});

/**
 * 
 * @param {type} controlDiv
 * @param {type} map
 * @returns {undefined}
 */
function rulerControl(controlDiv, map){
    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#FFF';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.style.borderColor = '#ccc';
    controlUI.style.height = '26px';
    controlUI.style.marginBottom = '4px';
    controlUI.style.marginLeft = '-6px';
    controlUI.style.paddingTop = '1px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Regla';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Arial,sans-serif';
    controlText.style.fontSize = '10px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.style.marginTop = '2px';
    controlText.innerHTML = '<img src="' + baseUrl + 'assets/img/ruler.png">';
    controlUI.appendChild(controlText);

    // Setup the click event listeners
    google.maps.event.addDomListener(controlUI, 'click', function () {
        var ruler = new GoogleMapsRuler(map);
        ruler.click();
    });
}

function distance(lat1,lon1,lat2,lon2) {
    var R = 6371; 
    var dLat = (lat2-lat1) * Math.PI / 180;
    var dLon = (lon2-lon1) * Math.PI / 180; 
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) * 
        Math.sin(dLon/2) * Math.sin(dLon/2); 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c;
    if (d>1) return Math.round(d)+"km";
    else if (d<=1) return Math.round(d*1000)+"m";
    return d;
}