var VisorMapa = {
    map: null,
    canvas: null,
    
    emergencyDrawingManager: null,
    emergencyMarker: null,
    emergencyRadius: null,

    otherDrawingManager: null,
    otherControlColor: null,
    otherControlSelected: null
};

(function() {
    var emergencyRadiusReceiver = function() {
        var radio = $("#iRadioEmergencia").val();

        if (radio.trim() === "") {
            $("#iRadioEmergencia").closest("div").addClass("has-error");
            return false;
        }

        $("#iRadioEmergencia").val("0");
        $('#mRadioEmergencia').modal('hide');

        if (radio === 0) return true;

        this.emergencyRadius = new google.maps.Circle({
            map: this.map,
            radius: parseInt(radio),
            fillColor: "#FF0000",
            center: { lat: this.emergencyMarker.position.G , lng: this.emergencyMarker.position.K }
        });

        var infoWindow = new google.maps.InfoWindow({
            content: "Radio de la emergencia"
        });

        this.emergencyRadius.addListener("click", function(event) {
            infoWindow.setPosition(event.latLng);
            infoWindow.open(this.map);
        });
    };

    var emergencyOtherReceiver = function() {
        if (!$("#botoneraColorControl a.selected").length) {
            $("#botoneraColorControl").closest("div").addClass("has-error");
            return false;
        }

        if (!$("#iTituloComponente").val()) {
            $("#iTituloComponente").closest("div").addClass("has-error");
            return false;
        }

        $("#ctrlDraw").addClass("btn-success").removeClass("btn-primary");

        this.otherDrawingManager.setDrawingMode(this.otherControlSelected.overlay);
        this.otherDrawingManager.setMap(this.map);
        this.otherControlSelected.title = $("#iTituloComponente").val();

        var poligonos = ["polygonOptions", "circleOptions", "rectangleOptions"];
        for (var i = 0; i < poligonos.length; i++) {
            this.otherDrawingManager.set(poligonos[i], {
                fillColor: this.otherControlColor
            });
        }

        this.otherDrawingManager.set("polylineOptions", {
            strokeColor: this.otherControlColor
        });
        
        $("#mOtrosEmergencias").modal("hide");
    };

    this.init = function(opciones) {
        var self = this;

        this.canvas = $("#mapa").get(0);
        $(window).resize(this.detectHeight.bind(this));

        var opcionesMapa = {
            center: new google.maps.LatLng(-33.07,-71.6),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 12
        };

        var opcionesFinales = $.extend(opcionesMapa, opciones);
        this.detectHeight.call(this);

        this.map = new google.maps.Map(this.canvas, opcionesFinales);
        this.makeSearchBox.call(this);

        // this.loadKML.call(this);
        this.makeEmergencyDrawManager.call(this);
        this.makeOthersManager.call(this);

        $("#btnGuardarRadioEmergencia").click(emergencyRadiusReceiver.bind(this));
        $("#btnGuardarOtrosEmergencia").click(emergencyOtherReceiver.bind(this));

        $("#mRadioEmergencia").on("shown.bs.modal", function(event) {
            $("#iRadioEmergencia").focus();
            $("#iRadioEmergencia").select();
        });
        $("#frmRadioEmergencia").submit(function() {
            $("#btnGuardarRadioEmergencia").click();
            return false;
        });

        $("#botoneraColorControl a").click(function() {
            $("#botoneraColorControl a i").removeClass("fa fa-check-circle-o");
            $(this).find("i").addClass("fa fa-check-circle-o");
            $(this).addClass("selected");
            self.otherControlColor = Utils.rgb2hex($(this).css("background-color"));
        });

        this.constructControlIns.call(this);
        this.constructControlLayer.call(this);
    };


    this.constructControlLayer = function() {
        var self = this;

        var table = $("#tblCtrlCapas").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            columns: [
                {
                    mRender: function(data, type, row) {
                        return '<input id="iCtrlLayers' + data + '" name="iCtrlLayers[]" type="checkbox"/>';
                    },
                    sWidth: "30px"
                },
                {}
            ],
            pagingType: "simple"
        });

        $("#ctrlLayers").click(function () {
            $("#mCapas").modal("show");
        });

        $("#btnCargarCapas").click(function () {
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=quimicas");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=manzanas");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=carabineros");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=hospitales");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=atencion_primaria");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=centros_salud");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=bodegas_quimico");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=cta");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=servicentros");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=jardines");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=establecimientos_educacion");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=instalaciones_quimicas");
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=liceos_colegios");
            $("#mCapas").modal("hide");
        });
    };

    this.constructControlIns = function() {
        var self = this;

        var table = $("#tblTiposIns").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            ajax: {
                url: siteUrl + "instalacion/obtenerJsonTipos",
                type: "GET",
                async: true
            },
            columns: [
                {
                    mRender: function(data, type, row) {
                        return '<input id="iTipIns' + row.aux_ia_id + '" name="iTipIns[]" type="checkbox"/>';
                    }
                },
                { data: "amb_c_nombre" },
                { data: "aux_c_nombre" }
            ],
            pagingType: "simple"
        });

        $("#ctrlIns").click(function () {
            $("#mMaestroInstalaciones").modal("show");
        });

        $("#btnCargarIns").click(function () {
            self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=eleam");
            $("#mMaestroInstalaciones").modal("hide");
        });
    };

    this.makeEmergencyDrawManager = function() {
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
            self.otherDrawingManager.setMap(null);
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

            var infoWindow = new google.maps.InfoWindow({
                content: "Lugar de la emergencia"
            });

            if(event.type == google.maps.drawing.OverlayType.MARKER) {
                var marker = event.overlay;

                self.emergencyMarker = marker;
                self.emergencyMarker.addListener("click", function(event) {
                    infoWindow.open(self.map, self.emergencyMarker);
                });

                $('#mRadioEmergencia').modal('show');
                $("#iRadioEmergencia").closest("div").removeClass("has-error");
            }
            $("#ctrlDrawOFF").click();
        });
    };

    this.makeOthersManager = function() {
        var self = this;

        this.otherDrawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER,
                    google.maps.drawing.OverlayType.CIRCLE,
                    google.maps.drawing.OverlayType.RECTANGLE,
                    google.maps.drawing.OverlayType.POLYLINE,
                    google.maps.drawing.OverlayType.POLYGON,
                ]
            },
            clickable: false,
            editable: true,
            zIndex: 1
        });
        this.otherDrawingManager.setMap(null);

        var controlsID = [
            { id: "ctrlOtherDrawLine", "overlay": google.maps.drawing.OverlayType.POLYLINE },
            { id: "ctrlOtherDrawPolygon", "overlay": google.maps.drawing.OverlayType.POLYGON },
            { id: "ctrlOtherDrawCircle", "overlay": google.maps.drawing.OverlayType.CIRCLE },
            { id: "ctrlOtherDrawRectangle", "overlay": google.maps.drawing.OverlayType.RECTANGLE },
            { id: "ctrlOtherDrawMarker", "overlay": google.maps.drawing.OverlayType.MARKER }
        ];

        for (var i = 0; i < controlsID.length; i++) {
            (function (context, origen) {
                var clickHandler = function() {
                    $("#mOtrosEmergencias").modal("show");
                    context.otherControlSelected = origen;
                };
                $("#" + origen.id).on("click", clickHandler);
            })(this, controlsID[i]);
        }

        google.maps.event.addListener(this.otherDrawingManager, 'overlaycomplete', function(event) {
            var componente = event.overlay;

            var infoWindow = new google.maps.InfoWindow({
                content: self.otherControlSelected.title
            });

            var poligonos = [
                google.maps.drawing.OverlayType.POLYGON, 
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.RECTANGLE
            ];

            if(poligonos.indexOf(event.type) != -1) {
                componente.addListener("click", function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(self.map);
                });
            }

            $("#ctrlDrawOFF").click();
        });
    };

    this.loadKML = function(url) {
        var kmlLayer = new google.maps.KmlLayer({
            url: url,
            map: this.map,
            suppressInfoWindows: true,
            preserveViewport: false
        });

        kmlLayer.addListener('click', function(event) {
            var content = event.featureData.infoWindowHtml;
            var testimonial = document.getElementById('capture');
            testimonial.innerHTML = content;
        });
    };

    this.detectHeight = function() {
        $(this.canvas).css("height", $("html").height() - $("div.header").height()+"px");
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

            if (places.length === 0) {
                return;
            }

            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                markers.push(new google.maps.Marker({
                    map: self.map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            self.map.fitBounds(bounds);
        });
    };
}).apply(VisorMapa);