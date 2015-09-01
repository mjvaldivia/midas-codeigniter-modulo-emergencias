var VisorMapa = {
    mapa: null,
    telon: null,
    drawingManager: null,

    init: function(opciones) {
        this.telon = $("#mapa").get(0);
        $(window).resize(this.detectHeight.bind(this));

        var opcionesMapa = {
            center: new google.maps.LatLng(-33.0507081,-71.6110485),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 8
        }

        var opcionesFinales = $.extend(opcionesMapa, opciones);
        this.detectHeight.call(this);

        this.mapa = new google.maps.Map(this.telon, opcionesFinales);
        this.makeSearchBox.call(this);
        this.loadKML.call(this);
        this.makeDrawManager.call(this);
    },

    makeDrawManager: function() {
        var self = this;

        this.drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER,
                    google.maps.drawing.OverlayType.CIRCLE,
                    google.maps.drawing.OverlayType.POLYGON,
                    google.maps.drawing.OverlayType.POLYLINE,
                    google.maps.drawing.OverlayType.RECTANGLE
                ]
            },
            clickable: false,
            editable: true,
            zIndex: 1
        });
        this.drawingManager.setMap(null);

        var controlsID = {
            "ctrlDrawCircle": google.maps.drawing.OverlayType.CIRCLE,
            "ctrlDrawLine": google.maps.drawing.OverlayType.POLYLINE,
            "ctrlDrawRectangle": google.maps.drawing.OverlayType.RECTANGLE,
            "ctrlDrawPolygon": google.maps.drawing.OverlayType.POLYGON,
            "ctrlDrawMarker": google.maps.drawing.OverlayType.MARKER
        };

        for (var llave in controlsID) {
            (function(controlID, googleConstant) {
                var clickHandler = function(){
                    self.drawingManager.setDrawingMode(googleConstant);
                    self.drawingManager.setMap(self.mapa);

                    var button = $(this).parents("div").first().find("button");
                    button.removeClass("btn-primary");
                    button.addClass("btn-success");
                    $(".ctrlPowerOff").css("display", "block");
                };

                $("#" + controlID).on("click", clickHandler);
            })(llave, controlsID[llave]);
        };

        $("#ctrlDrawOFF").click(function() {
            self.drawingManager.setMap(null);
            var button = $(this).parents("div").first().find("button");
            button.removeClass("btn-success");
            button.addClass("btn-primary");
            $(".ctrlPowerOff").css("display", "none");
        });
    },

    loadKML: function() {
        var kmlLayer = new google.maps.KmlLayer({
            url: 'http://ssrv.cl/sipresa_test/kml.php',
            map: this.mapa,
            suppressInfoWindows: true,
            preserveViewport: false
        });

        kmlLayer.addListener('click', function(event) {
            console.log(event);
            var content = event.featureData.infoWindowHtml;
            var testimonial = document.getElementById('capture');
            testimonial.innerHTML = content;
        });
    },

    detectHeight: function() {
        $(this.telon).css("height", $("html").height() - $("div.header").height()+"px");
    },

    makeSearchBox: function() {
        var input = $("#input-buscador-mapa").get(0);
        var searchBox = new google.maps.places.SearchBox(input);
        var self = this;
        var markers = [];

        this.mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        this.mapa.addListener('bounds_changed', function() {
            searchBox.setBounds(self.mapa.getBounds());
        });

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: self.mapa,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            self.mapa.fitBounds(bounds);
        });
    }
};