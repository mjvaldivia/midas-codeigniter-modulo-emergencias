var VisorMapa = {
    map: null,
    canvas: null,

    emergencyMarker: null,
    emergencyRadius: null,
    
    emergencyDrawingManager: null,
    otherDrawingManager: null,

    otherControlColor: null,
    otherControlSelected: null,
    otherInfoListener: null
};

(function() {
    var opciones = null;

    this.init = function(opciones) {
        this.opciones = opciones;
        $.get(siteUrl + "emergencia/obtenerJsonLimitesVisor/id/" + $("#hIdEmergencia").val()).done(this.makeMap.bind(this));
    };

    this.makeMap = function(data) {
        var self = this;
        var json = JSON.parse(data);
        var bounds = new google.maps.LatLngBounds();

        for (var i = 0; i < json.length; i++) {
            var c = json[i];

            if (!c.com_c_xmin || !c.com_c_ymin || !c.com_c_xmax || !c.com_c_ymax ) continue;

            var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmin), parseFloat(c.com_c_ymin), c.com_c_geozone);
            bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));

            latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmax), parseFloat(c.com_c_ymax), c.com_c_geozone);
            bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
        }


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
        this.map.fitBounds(bounds);

        this.makeSearchBox.call(this);
        this.makeEmergencyDrawManager.call(this);
        this.makeOthersManager.call(this);
        this.constructControlIns.call(this);
        this.constructControlLayer.call(this);
        this.constructControlInfo.call(this);

        // definimos el comportamiento de estilo
        this.map.data.setStyle(function(feature){
            var color = null;
            var retorno = {};

            if (feature.getProperty("fillColor")) {
                color = feature.getProperty("color");
                retorno.fillOpacity = 0.3;
                retorno.fillColor = feature.getProperty("fillColor");
            }

            if (feature.getProperty("strokeColor")) {
                retorno.strokeColor = feature.getProperty("strokeColor");
            }

            if (feature.getProperty("icon")) {
                retorno.icon = feature.getProperty("icon");
            }

            return retorno;
        });
        this.map.data.addListener("click", function(event) {
            var infoWindow = new google.maps.InfoWindow({
                content: event.feature.getProperty("infoWindow"),
                position: event.latLng
            });

            if (!event.feature.getProperty("infoWindow")) return;
            infoWindow.open(self.map) ;
        });
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

    var drawPointsIns = function(data) {
        var json = JSON.parse(data);
        for (var i = 0; i < json.length; i++) {
            var instalacion = json[i];
            if (!instalacion.ins_c_latitud || !instalacion.ins_c_longitud) continue;

            var point = new google.maps.Data.Feature({
                geometry: new google.maps.Data.Point({ lat: parseFloat(instalacion.ins_c_latitud), lng: parseFloat(instalacion.ins_c_longitud) }),
                properties: {
                    type: "INSTALACION",
                    icon: "https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png",
                    infoWindow: instalacion.ins_c_razon_social + " - " + instalacion.ins_c_nombre_fantasia
                }
            });

            this.map.data.add(point);
        }
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

            $.post(siteUrl + "instalacion/obtenerJsonInsSegunTipIns", params).done(drawPointsIns.bind(self));
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
            if(event.type == google.maps.drawing.OverlayType.MARKER) {
                if (self.emergencyMarker) {
                    self.map.data.remove(self.emergencyMarker);
                    if (self.emergencyRadius) self.map.data.remove(self.emergencyRadius);
                }

                var marker = event.overlay;
                marker.setMap(null);

                var point = new google.maps.Data.Feature({
                    geometry: new google.maps.Data.Point(marker.getPosition()),
                    properties: {
                        type: "LUGAR_EMERGENCIA",
                        icon: "https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png",
                        infoWindow: "Lugar de la emergencia"
                    }
                });

                self.map.data.add(point);
                self.emergencyMarker = point;

                $("#mRadioEmergencia").modal("show");
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

            // capturamos el control dibujado mediante drawing manager y lo borramos para agregar
            // nuestra propia featuyre con metadata
            var componente = event.overlay;
            componente.setMap(null);

            switch(event.type) {
                case google.maps.drawing.OverlayType.POLYLINE:
                    var vertex = [];
                    for (var i = 0; i < componente.getPath().getLength(); i++) {
                        var obj = componente.getPath().getAt(i);
                        vertex.push(obj);
                    }
                    var polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.LineString(vertex),
                        properties: {
                            strokeColor: self.otherControlColor,
                            type: "POLYLINE",
                            infoWindow: self.otherControlSelected.title
                        }
                    });
                    self.map.data.add(polygon);
                    break;
                case google.maps.drawing.OverlayType.POLYGON:
                    var vertex = [[]];
                    for (var i = 0; i < componente.getPath().getLength(); i++) {
                        var obj = componente.getPath().getAt(i);
                        vertex[0].push(obj);
                    }
                    var polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "POLYGON",
                            infoWindow: self.otherControlSelected.title
                        }
                    });
                    self.map.data.add(polygon);
                    break;

                case google.maps.drawing.OverlayType.CIRCLE:
                    var vertex = generateCircleVertex(componente);
                    var polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "CIRCLE",
                            infoWindow: self.otherControlSelected.title
                        }
                    });
                    self.map.data.add(polygon);
                    break;
                case google.maps.drawing.OverlayType.RECTANGLE:
                    var vertex = [];
                    vertex.push([]);

                    var bounds = componente.getBounds();
                    vertex[0].push(bounds.getNorthEast());
                    vertex[0].push({lat: bounds.getSouthWest().lat(), lng: bounds.getNorthEast().lng()});
                    vertex[0].push(bounds.getSouthWest());
                    vertex[0].push({lat: bounds.getNorthEast().lat(), lng: bounds.getSouthWest().lng()});

                    var polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "RECTANGLE",
                            infoWindow: self.otherControlSelected.title
                        }
                    });
                    self.map.data.add(polygon);

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

        var tmpCircle = new google.maps.Circle({
            map: null,
            radius: parseInt(radio),
            fillColor: "#FF0000",
            center: this.emergencyMarker.getGeometry().get()
        });

        var vertex = generateCircleVertex(tmpCircle);
        var polygon = new google.maps.Data.Feature({
            geometry: new google.maps.Data.Polygon(vertex),
            properties: {
                fillColor: "#FF0000",
                type: "RADIO_EMERGENCIA",
                infoWindow: "Radio de la emergencia"
            }
        });
        this.map.data.add(polygon);
        this.emergencyRadius = polygon;
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

    var CIRCLE_VERTEX_NUM = 1800;

    var generateCircleVertex = function(circle) {
        var vertex = [[]];
        var degreeStep = 360 / CIRCLE_VERTEX_NUM;
        var latLng = null;

        for (var i = 0; i < CIRCLE_VERTEX_NUM; i++) {
            latLng = google.maps.geometry.spherical.computeOffset(circle.getCenter(), circle.getRadius(), degreeStep * i);
            vertex[0].push(latLng);
        }
        return vertex;
    }
}).apply(VisorMapa);

