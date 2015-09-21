var VisorMapa = {
    map: null,
    canvas: null,
    
    emergencyDrawingManager: null,
    emergencyMarker: null,
    emergencyRadius: null,

    otherDrawingManager: null,
    otherControlColor: null,
    otherControlSelected: null,
    otherFeatures: {
        circles: [],
        rectangles: [],
        polylines: [],
        polygons: [],
        markers: []
    },
    otherInfoListener: null,
    iteracionTemporal: 1
};

(function() {
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
        this.makeEmergencyDrawManager.call(this);
        this.makeOthersManager.call(this);
        this.constructControlIns.call(this);
        this.constructControlLayer.call(this);
        this.constructControlInfo.call(this);
    };

    this.constructControlInfo = function() {
        var self = this;
        $("#ctrlInfo").click(function() {
            var btn = this;
            if ($(this).hasClass("btn-success")) return;

            $(this).removeClass("btn-primary").addClass("btn-success");

            // por ahora hardcodeado a los poligonos
            for (var i = 0; i < self.otherFeatures.polygons.length; i++) {
                var polygon = self.otherFeatures.polygons[i];
                (function(context, btn, polygon) {
                    var clickHandler = function() {
                        $("#mInfo").modal("show");
                        google.maps.event.removeListener(context.otherInfoListener);
                        $(btn).removeClass("btn-success").addClass("btn-primary");
                    };
                    var listener = polygon.addListener("click", clickHandler);
                    context.otherInfoListener = listener;
                })(self, btn, polygon);
            }
        });
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
                {
                    sType: "string"
                }
            ],
            pagingType: "simple",
            order: [[1, "asc"]]
        });

        $("#ctrlLayers").click(function () {
            $("#mCapas").modal("show");
        });

        $("#btnCargarCapas").click(function () {
            if (self.iteracionTemporal == 1) {
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=bodegas_quimico");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=quimicas");
            } else if (self.iteracionTemporal == 2) {
                //self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=manzanas");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=hospitales");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=atencion_primaria");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=centros_salud");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=servicentros");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=jardines");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=instalaciones_quimicas");
                self.loadKML("http://ssrv.cl/emergencias_test/kml.php?name=liceos_colegios");
            }
            self.iteracionTemporal++;
            $("#mCapas").modal("hide");
        });
    };

    var drawPointsIns = function() {

    };

    this.constructControlIns = function() {
        var self = this;

        $('#tblTiposIns tfoot th').each(function () {
            var title = $('#tblTiposIns thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
        });

        var table = $("#tblTiposIns").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            ajax: {
                url: siteUrl + "instalacion/obtenerJsonDtTipos",
                type: "GET",
                async: true
            },
            columns: [
                {
                    mRender: function(data, type, row) {
                        return '<input id="iTipIns' + row.aux_ia_id + '" name="iTipIns[]" value="' + row.aux_ia_id + '" type="checkbox"/>';
                    }
                },
                { data: "amb_c_nombre" },
                { data: "aux_c_nombre" }
            ],
            pagingType: "simple"
        });

        $("#tblTiposIns").on("init.dt", function(evt, settings, json) {
            table.columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });

        $("#ctrlIns").click(function () {
            $("#mMaestroInstalaciones").modal("show");
        });

        $("#btnCargarIns").click(function () {
            var params = {};
            params.idEmergencia = $("#hIdEmergencia").val();
            params.tiposIns = [];

            var checkboxs = $("input[type='checkbox'][name='iTipIns[]']:checked");
            for (var i = 0; i < checkboxs.length; i++) {
                params.tiposIns.push(checkboxs[i].value);
            }

            $.post(siteUrl + "instalacion/obtenerJsonCoordsTipIns", params).done(drawPointsIns.bind(this));
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

        $("#btnGuardarRadioEmergencia").click(emergencyRadiusReceiver.bind(this));

        $("#mRadioEmergencia").on("shown.bs.modal", function(event) {
            $("#iRadioEmergencia").focus();
            $("#iRadioEmergencia").select();
        });
        $("#frmRadioEmergencia").submit(function() {
            $("#btnGuardarRadioEmergencia").click();
            return false;
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

            switch(event.type) {
                case google.maps.drawing.OverlayType.POLYGON:
                    self.otherFeatures.polygons.push(componente);
                    break;
                case google.maps.drawing.OverlayType.CIRCLE:
                    self.otherFeatures.circles.push(componente);
                    break;
                case google.maps.drawing.OverlayType.POLYLINE:
                    self.otherFeatures.polylines.push(componente);
                    break;
                case google.maps.drawing.OverlayType.RECTANGLE:
                    self.otherFeatures.rectangles.push(componente);
                    break;
                case google.maps.drawing.OverlayType.MARKER:
                    self.otherFeatures.markers.push(componente);
                    break;
            }

            $("#ctrlDrawOFF").click();
        });

        $("#btnGuardarOtrosEmergencia").click(emergencyOtherReceiver.bind(this));

        $("#botoneraColorControl a").click(function() {
            $("#botoneraColorControl a i").removeClass("fa fa-check-circle-o");
            $(this).find("i").addClass("fa fa-check-circle-o");
            $(this).addClass("selected");
            self.otherControlColor = Utils.rgb2hex($(this).css("background-color"));
        });
    };

    this.loadKML = function(url) {
        var self = this;

        var kmlLayer = new google.maps.KmlLayer({
            url: url,
            map: this.map,
            suppressInfoWindows: true,
            preserveViewport: true
        });

        kmlLayer.addListener('click', function(event) {
            var infoWindow = new google.maps.InfoWindow({
                content: event.featureData.infoWindowHtml
            });
            infoWindow.setPosition(event.latLng);
            infoWindow.open(self.map);
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
            center: this.emergencyMarker.getPosition()
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
}).apply(VisorMapa);