var VisorMapa = {
    map: null,
    canvas: null,
    emergencyDrawingManager: null,
    emergencyMarker: null,
    emergencyRadius: null,
    otherDrawingManager: null,
};

(function() {
    var emergencyRadiusReceiver = function() {
        var radio = $("#iRadioEmergencia").val();

        $("#iRadioEmergencia").val("0");

        $('#mRadioEmergencia').modal('hide');

        this.emergencyRadius = new google.maps.Circle({
            map: this.map,
            radius: parseInt(radio),
            fillColor: "#FF0000",
            center: { lat: this.emergencyMarker.position.G , lng: this.emergencyMarker.position.K }
        });

    };

    this.init = function(opciones) {
        this.canvas = $("#mapa").get(0);
        $(window).resize(this.detectHeight.bind(this));

        var opcionesMapa = {
            center: new google.maps.LatLng(-33.0507081,-71.6110485),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 8
        }

        var opcionesFinales = $.extend(opcionesMapa, opciones);
        this.detectHeight.call(this);

        this.map = new google.maps.Map(this.canvas, opcionesFinales);
        this.makeSearchBox.call(this);

        this.map.addListener("click", function (event) {
            console.log(event);
        });
        // this.loadKML.call(this);
        this.makeDrawManager.call(this);
        $("#btnGuardarRadioEmergencia").click(emergencyRadiusReceiver.bind(this));
    };

    this.makeDrawManager = function() {
        var self = this;

        this.emergencyDrawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                ]
            },
            // polygonOptions: {
            //     fillColor: "#FF0000"
            // },
            // circleOptions: {
            //     fillColor: "#FF0000"
            // },
            // polylineOptions: {
            //     strokeColor: "#FF0000"
            // },
            // rectangleOptions: {
            //     fillColor: "#FF0000"
            // },
            clickable: false,
            editable: true,
            zIndex: 1
        });
        this.emergencyDrawingManager.setMap(null);

        (function(controlID, googleConstant) {
            var clickHandler = function(){
                self.emergencyDrawingManager.setDrawingMode(googleConstant);
                self.emergencyDrawingManager.setMap(self.map);

                var button = $(this).parents("div").first().find("a.btn");
                button.removeClass("btn-primary");
                button.addClass("btn-success");
                $(".ctrlPowerOff").css("display", "block");
                event.preventDefault();
                event.stopPropagation();
            };

            $("#" + controlID).on("click", clickHandler);
        })("ctrlDrawMarker", google.maps.drawing.OverlayType.MARKER);

        $("#ctrlDrawOFF").click(function() {
            self.emergencyDrawingManager.setMap(null);
            var button = $(this).parents("div").first().find("a.btn");
            button.removeClass("btn-success");
            button.addClass("btn-primary");
            $(".ctrlPowerOff").css("display", "none");
        });

        google.maps.event.addListener(this.emergencyDrawingManager, 'overlaycomplete', function(event) {
            if (self.emergencyMarker) {
                self.emergencyMarker.setMap(null);
                if (self.emergencyRadius) self.emergencyRadius.setMap(null);
            }

            if(event.type == google.maps.drawing.OverlayType.MARKER) {
                var marker = event.overlay;
                // marker["userData"] = {
                //     emergencyArea: true
                // };

                self.emergencyMarker = marker;

                $('#mRadioEmergencia').modal('show');
            }
            $("#ctrlDrawOFF").click();
        });
    };

    this.loadKML = function() {
        var kmlLayer = new google.maps.KmlLayer({
            url: 'http://ssrv.cl/sipresa_test/kml.php',
            map: this.map,
            suppressInfoWindows: true,
            preserveViewport: false
        });

        kmlLayer.addListener('click', function(event) {
            console.log(event);
            var content = event.featureData.infoWindowHtml;
            var testimonial = document.getElementById('capture');
            testimonial.innerHTML = content;
        });
    };

    this.detectHeight = function() {
        $(this.telon).css("height", $("html").height() - $("div.header").height()+"px");
    };

    this.makeSearchBox = function() {
        var input = $("#input-buscador-mapa").get(0);
        var searchBox = new google.maps.places.SearchBox(input);
        var self = this;
        var markers = [];

        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        this.map.addListener('bounds_changed', function() {
            searchBox.setBounds(self.map.getBounds());
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
                    map: self.map,
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
            self.map.fitBounds(bounds);
        });
    };
}).apply(VisorMapa);