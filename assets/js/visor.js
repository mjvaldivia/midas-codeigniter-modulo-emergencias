var VisorMapa = {
    map: null,
    canvas: null,
    emergencyMarker: null,
    emergencyRadius: null,
    emergencyDrawingManager: null,
    otherDrawingManager: null,
    otherControlColor: null,
    otherControlDataColor: null,
    otherControlSelected: null,
    otherStatusInfoControl: "off"
};

(function () {
    var opciones = null;

    this.init = function (opciones) {
        this.opciones = opciones;
        $.get(siteUrl + "visor/obtenerJsonEmergenciaVisor/id/" + $("#hIdEmergencia").val()).done(this.makeMap.bind(this));
    };

    this.makeMap = function (data) {
        var self = this;
        var json = JSON.parse(data);
        var bounds = new google.maps.LatLngBounds();

        for (var i = 0; i < json.coordinates.length; i++) {
            var c = json.coordinates[i];

            if (!c.com_c_xmin || !c.com_c_ymin || !c.com_c_xmax || !c.com_c_ymax)
                continue;

            var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmin), parseFloat(c.com_c_ymin), c.com_c_geozone);
            bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));

            latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmax), parseFloat(c.com_c_ymax), c.com_c_geozone);
            bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
        }


        this.canvas = $("#mapa").get(0);
        $(window).resize(this.detectHeight.bind(this));

        var opcionesMapa = {
            center: new google.maps.LatLng(-33.07, -71.6),
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
        this.constructControlIns.call(this, json.facilities);
        // this.constructControlLayer.call(this);
        this.constructControlInfo.call(this);
        this.constructControlSave.call(this);

        // definimos el comportamiento de estilo
        this.map.data.setStyle(function (feature) {
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
        this.map.data.addListener("click", function (event) {


            if (self.otherStatusInfoControl == "on")
                return crossingData.call(self, event);
            if (!event.feature.getProperty("infoWindow"))
                return;
            var infoWindow = new google.maps.InfoWindow({
                content: event.feature.getProperty("infoWindow"),
                position: event.latLng
            });
            infoWindow.open(self.map);
        });

        if (json.geojson)
            this.map.data.loadGeoJson(json.geojson, null, function (features) {
                for (var i = 0; i < features.length; i++) {
                    var feature = features[i];
                    if (feature.getProperty("type") == "LUGAR_EMERGENCIA") {
                        self.emergencyMarker = feature;
                    } else if (feature.getProperty("type") == "RADIO_EMERGENCIA")
                        self.emergencyRadius = feature;

                }
            });
    };

    var crossingData = function (event) {
        if (event.feature.getGeometry().getType() != "Polygon")
            return null;

        var features = getDataFeatures.call(this);
        var results = [];
        var feature, i;
        // truco para copiar el maps.Data.Polygon a maps.Polygon, para poder usar la librería geometry
        var target = new google.maps.Polygon({map: null});
        target.setPaths(event.feature.getGeometry().getAt(0).getArray());

        for (i = 0; i < features.length; i++) {
            feature = features[i];
            if (feature.getGeometry().getType() != "Point" || feature.getProperty("type") == "LUGAR_EMERGENCIA")
                continue;

            if (google.maps.geometry.poly.containsLocation(feature.getGeometry().get(), target))
                results.push(feature);
        }

        // rendering
        var actual = null;
        var recorridos = [];
        var jsonDT, idTablaDT, tituloDT, contador;

        for (i = 0, contador = 1; i < results.length; i++) {
            if (recorridos.indexOf(actual) != -1)
                continue;

            jsonDT = {};
            jsonDT.data = [];

            actual = results[i].getProperty("type");

            for (var j = i; j < results.length; j++) {
                feature = results[j];
                if (actual != feature.getProperty("type"))
                    continue;
                jsonDT.data.push(getFeatureProperties(feature));
                jsonDT.columns = getLayerColumns(actual, getFeatureProperties(feature));
            }
            recorridos.push(actual);

            tituloDT = "Capa " + actual;
            idTablaDT = "crossingDT_" + (contador++);

            var html = $("#moldeCruce").html();
            html = html.replace(/__titulo__/g, tituloDT);
            html = html.replace(/__id_tabla__/g, idTablaDT);

            $("#mInfoContent").html("");
            $("#mInfoContent").prepend(html);

            //console.log(JSON.stringify(jsonDT));

            $("#" + idTablaDT).DataTable({
                columns: jsonDT.columns,
                data: jsonDT.data,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                }
            });

            $("#mInfo").modal("show");
            $("#ctrlInfo").click(); // para que se apague
        }

        return null;
    };

    var getDataFeatures = function () {
        var features = [];

        this.map.data.forEach(function (feature) {
            features.push(feature);
        });
        return features;
    };

    var getFeatureProperties = function (feature) {
        var properties = {};
        feature.forEachProperty(function (value, name) {
            properties[name] = value;
        });
        return properties;
    };

    var getLayerColumns = function (layer, properties) {
        var defaultHiddenColumns = ["midas", "icon", "infoWindow", "type"];
        var columns = [];
        var obj;

        switch (layer) {
            case "INSTALACION":
                obj = {
                    mData: "id_maestro",
                    sTitle: "ID"
                };
                columns.push(obj);

                obj = {
                    mData: "razon_social",
                    sTitle: "Razón Social"
                };
                columns.push(obj);

                obj = {
                    mData: "nombre_fantasia",
                    sTitle: "Nombre Fantasía"
                };
                columns.push(obj);

                obj = {
                    mData: "direccion",
                    sTitle: "Dirección"
                };
                columns.push(obj);
                break;

            default:
                for (var name in properties) {
                    if (properties.hasOwnProperty(name)) {
                        obj = {};
                        obj.mData = name;
                        obj.sTitle = name;

                        if (defaultHiddenColumns.indexOf(name) != -1)
                            obj.bVisible = false;
                        columns.push(obj);
                    }
                }
                break;
        }
        return columns;
    };

    this.constructControlInfo = function () {
        var self = this;
        $("#ctrlInfo").click(function () {
            if ($(this).hasClass("btn-success")) {
                $(this).removeClass("btn-success").addClass("btn-primary");
                self.otherStatusInfoControl = "off";
                return;
            }

            $(this).removeClass("btn-primary").addClass("btn-success");
            self.otherStatusInfoControl = "on";
        });
    };

    this.constructControlSave = function () {
        var self = this;
        $("#ctrlSave").click(function () {
            // variable para separar
            var geojson = {
                type: "FeatureCollection",
                features: []
            };
            self.map.data.toGeoJson(function (json) {
                for (var i = 0; i < json.features.length; i++) {
                    var feature = json.features[i];
                    if (!feature.properties.midas)
                        continue;

                    geojson.features.push(feature);
                }

                var json_string = JSON.stringify(geojson);
                var params = "id=" + $("#hIdEmergencia").val() + "&geoJson=" + json_string;
                $.post(siteUrl + "visor/saveGeoJson", params).done();
            });

        });
    };
    $("#ctrlLayers").click(function () {

        $("#mCapas").modal("show");
        $('#tblCtrlCapas tfoot th').each(function () {
            var title = $('#tblCtrlCapas thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
        });
        $("#tblCtrlCapas").DataTable().destroy();
        var items = $('#selected_items').val().split(',');

        var table = $("#tblCtrlCapas").DataTable({
            ajax: {
                url: siteUrl + 'visor/obtenerCapasDT/id/' + items,
                type: 'POST',
                async: true
            },
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            order: [[1, "asc"]]

        });

        $("#tblCtrlCapas").on("init.dt", function (evt, settings, json) {
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



    });


    this.selectCapa = function (id) {
        var selections = $('#selected_items').val();

        if ($("#chk_" + id).is(":checked")) {
            if (selections == "")
                var coma = "";
            else
                var coma = ",";

            $('#selected_items').val(selections + coma + id);
        } else {
            var arr_select = selections.split(",");
            var newSelect = "";
            for (var i = 0; i < arr_select.length; i++) {
                if (arr_select[i] != id) {
                    if (newSelect == "")
                        var coma = "";
                    else
                        var coma = ",";
                    newSelect += coma + arr_select[i];
                }
            }
            $('#selected_items').val(newSelect);
        }


    };
    var self = this;
    $("#btnCargarCapas").click(function () {


        $("#mCapas").modal("hide");
        self.map.data.forEach(function (feature) {
            console.log(feature.getProperty("TYPE"));
            if ($.isNumeric(feature.getProperty("TYPE")))
            {
                self.map.data.remove(feature);
            }
        });
        if ($('#selected_items').val() !== '') {
            var arr_select = $('#selected_items').val().split(",");

            for (var i = 0; i < arr_select.length; i++) {



                $.get(siteUrl + 'visor/get_json_capa/id/' + arr_select[i], function (data) {
                    var json = JSON.parse(data);
                    var geojson = JSON.parse(json.json_str);
                    var es_punto;
                    for (var i = 0; i < geojson.features.length; i++) {
                        es_punto = 0;
                        var feature = geojson.features[i];
                        //console.log(feature);return;
                        if (feature.geometry.type == "Point")
                        {
                            es_punto++;
                            var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(feature.geometry.coordinates[0]), parseFloat(feature.geometry.coordinates[1]), json.geozone);

                            // console.log(latLon);
                            var point = new google.maps.Data.Feature({
                                geometry: new google.maps.Data.Point({lat: parseFloat(latLon[0]), lng: parseFloat(latLon[1])}),
                                properties: {
                                    TYPE: feature.properties.TYPE,
                                    icon: baseUrl + "assets/img/spotlight-poi.png"

                                }
                            });
                            self.map.data.add(point);
                        }
                        
                    }
                    if(es_punto==0)
                            self.map.data.addGeoJson(geojson);
                });
            }
        }
    });


    var clearIns = function () {
        var self = this;

        this.map.data.forEach(function (feature) {
            if (feature.getProperty("type") == "INSTALACION")
                self.map.data.remove(feature);
        });
    };

    var drawPointsIns = function (data) {
        var json = JSON.parse(data);

        clearIns.call(this);

        for (var i = 0; i < json.length; i++) {
            var instalacion = json[i];
            if (!instalacion.ins_c_latitud || !instalacion.ins_c_longitud)
                continue;

            var html = $("#moldeIns").html();

            html = html.replace(/__razon_social__/g, instalacion.ins_c_razon_social);
            html = html.replace(/__nombre_fantasia__/g, instalacion.ins_c_nombre_fantasia);
            html = html.replace(/__comuna__/g, instalacion.com_c_nombre);
            html = html.replace(/__region__/g, instalacion.reg_c_nombre);
            html = html.replace(/__direccion__/g,
                    instalacion.ins_c_nombre_direccion + ", " +
                    instalacion.ins_c_numero_direccion + " " +
                    instalacion.ins_c_resto_direccion + " "
                    );

            var point = new google.maps.Data.Feature({
                geometry: new google.maps.Data.Point({lat: parseFloat(instalacion.ins_c_latitud), lng: parseFloat(instalacion.ins_c_longitud)}),
                properties: {
                    type: "INSTALACION",
                    icon: baseUrl + "assets/img/spotlight-poi.png",
                    infoWindow: html,
                    id_maestro: instalacion.ins_ia_id,
                    razon_social: instalacion.ins_c_razon_social,
                    nombre_fantasia: instalacion.ins_c_nombre_fantasia,
                    direccion: instalacion.ins_c_nombre_direccion + ", " +
                            instalacion.ins_c_numero_direccion + " " +
                            instalacion.ins_c_resto_direccion,
                    midas: true
                }
            });

            this.map.data.add(point);
        }
    };

    this.constructControlIns = function (facilities) {
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
                    mRender: function (data, type, row) {
                        var checked = "";
                        for (var i = 0; i < facilities.length; i++) {
                            var ti = facilities[i];
                            if (row.aux_ia_id == ti.id_tipo_ins) {
                                checked = 'checked="true"';
                                break;
                            }
                        }
                        return '<input id="iTipIns' + row.aux_ia_id + '" name="iTipIns[]" value="' + row.aux_ia_id + '" type="checkbox" ' + checked + '/>';
                    }
                },
                {data: "amb_c_nombre"},
                {data: "aux_c_nombre"}
            ],
            pagingType: "simple"
        });

        $("#tblTiposIns").on("init.dt", function (evt, settings, json) {
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

            $.post(siteUrl + "visor/obtenerJsonInsSegunTipIns", params).done(drawPointsIns.bind(self));
            $("#mMaestroInstalaciones").modal("hide");
        });
    };

    this.makeEmergencyDrawManager = function () {
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

        (function (controlID, googleConstant) {
            var clickHandler = function () {
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

        $("#ctrlDrawOFF").click(function () {
            self.emergencyDrawingManager.setMap(null);
            self.otherDrawingManager.setMap(null);
            var button = $(this).parents("div").first().find("a.btn");
            button.removeClass("btn-success");
            button.addClass("btn-primary");
            $(".ctrlPowerOff").css("display", "none");
        });

        google.maps.event.addListener(this.emergencyDrawingManager, 'overlaycomplete', function (event) {
            if (event.type == google.maps.drawing.OverlayType.MARKER) {
                if (self.emergencyMarker) {
                    self.map.data.remove(self.emergencyMarker);
                    if (self.emergencyRadius)
                        self.map.data.remove(self.emergencyRadius);
                }

                var marker = event.overlay;
                marker.setMap(null);

                var point = new google.maps.Data.Feature({
                    geometry: new google.maps.Data.Point(marker.getPosition()),
                    properties: {
                        type: "LUGAR_EMERGENCIA",
                        icon: baseUrl + "assets/img/spotlight-poi.png",
                        infoWindow: "Lugar de la emergencia",
                        midas: true
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

        $("#mRadioEmergencia").on("shown.bs.modal", function (event) {
            $("#iRadioEmergencia").focus();
            $("#iRadioEmergencia").select();
        });
        $("#frmRadioEmergencia").submit(function () {
            $("#btnGuardarRadioEmergencia").click();
            return false;
        });
    };

    this.makeOthersManager = function () {
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
            {id: "ctrlOtherDrawLine", "overlay": google.maps.drawing.OverlayType.POLYLINE},
            {id: "ctrlOtherDrawPolygon", "overlay": google.maps.drawing.OverlayType.POLYGON},
            {id: "ctrlOtherDrawCircle", "overlay": google.maps.drawing.OverlayType.CIRCLE},
            {id: "ctrlOtherDrawRectangle", "overlay": google.maps.drawing.OverlayType.RECTANGLE},
            {id: "ctrlOtherDrawMarker", "overlay": google.maps.drawing.OverlayType.MARKER}
        ];

        for (var i = 0; i < controlsID.length; i++) {
            (function (context, origen) {
                var clickHandler = function () {
                    $("#mOtrosEmergencias").modal("show");
                    context.otherControlSelected = origen;
                };
                $("#" + origen.id).on("click", clickHandler);
            })(this, controlsID[i]);
        }

        google.maps.event.addListener(this.otherDrawingManager, 'overlaycomplete', function (event) {

            // capturamos el control dibujado mediante drawing manager y lo borramos para agregar
            // nuestra propia featuyre con metadata
            var componente = event.overlay;
            componente.setMap(null);
            var vertex, i, polygon, obj;

            switch (event.type) {
                case google.maps.drawing.OverlayType.POLYLINE:
                    vertex = [];
                    for (i = 0; i < componente.getPath().getLength(); i++) {
                        obj = componente.getPath().getAt(i);
                        vertex.push(obj);
                    }
                    polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.LineString(vertex),
                        properties: {
                            strokeColor: self.otherControlColor,
                            type: "POLYLINE",
                            infoWindow: self.otherControlSelected.title,
                            midas: true
                        }
                    });
                    self.map.data.add(polygon);
                    break;
                case google.maps.drawing.OverlayType.POLYGON:
                    vertex = [[]];
                    for (i = 0; i < componente.getPath().getLength(); i++) {
                        obj = componente.getPath().getAt(i);
                        vertex[0].push(obj);
                    }
                    polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "POLYGON",
                            infoWindow: self.otherControlSelected.title,
                            midas: true
                        }
                    });
                    self.map.data.add(polygon);
                    break;

                case google.maps.drawing.OverlayType.CIRCLE:
                    vertex = generateCircleVertex(componente);
                    polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "CIRCLE",
                            infoWindow: self.otherControlSelected.title,
                            midas: true
                        }
                    });
                    self.map.data.add(polygon);
                    break;
                case google.maps.drawing.OverlayType.RECTANGLE:
                    vertex = [[]];

                    var bounds = componente.getBounds();
                    vertex[0].push(bounds.getNorthEast());
                    vertex[0].push({lat: bounds.getSouthWest().lat(), lng: bounds.getNorthEast().lng()});
                    vertex[0].push(bounds.getSouthWest());
                    vertex[0].push({lat: bounds.getNorthEast().lat(), lng: bounds.getSouthWest().lng()});

                    polygon = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Polygon(vertex),
                        properties: {
                            fillColor: self.otherControlColor,
                            type: "RECTANGLE",
                            infoWindow: self.otherControlSelected.title,
                            midas: true
                        }
                    });
                    self.map.data.add(polygon);

                    break;
                case google.maps.drawing.OverlayType.MARKER:
                    //console.log(componente.getPosition());
                    var point = new google.maps.Data.Feature({
                        geometry: new google.maps.Data.Point(componente.getPosition()),
                        properties: {
                            type: "PUNTO",
                            icon: baseUrl + "assets/img/spotlight-poi-" + self.otherControlDataColor + ".png",
                            infoWindow: self.otherControlSelected.title,
                            midas: true
                        }
                    });
                    self.map.data.add(point);
                    break;
            }

            $("#ctrlDrawOFF").click();
        });

        $("#btnGuardarOtrosEmergencia").click(emergencyOtherReceiver.bind(this));

        $("#botoneraColorControl a").click(function () {
            $("#botoneraColorControl a i").removeClass("fa fa-check-circle-o");
            $(this).find("i").addClass("fa fa-check-circle-o");
            $(this).addClass("selected");
            self.otherControlColor = Utils.rgb2hex($(this).css("background-color"));
            self.otherControlDataColor = $(this).attr("data-color");
        });
    };

    this.loadKML = function (url) {
        var self = this;

        var kmlLayer = new google.maps.KmlLayer({
            url: url,
            map: this.map,
            suppressInfoWindows: true,
            preserveViewport: true
        });

        kmlLayer.addListener('click', function (event) {
            var infoWindow = new google.maps.InfoWindow({
                content: event.featureData.infoWindowHtml
            });
            infoWindow.setPosition(event.latLng);
            infoWindow.open(self.map);
        });
    };

    this.detectHeight = function () {
        $(this.canvas).css("height", $("html").height() - $("div.header").height() + "px");
    };

    this.makeSearchBox = function () {
        var input = $("#input-buscador-mapa").get(0);
        var searchBox = new google.maps.places.SearchBox(input);
        var self = this;
        var markers = [];

        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        this.map.addListener('bounds_changed', function () {
            searchBox.setBounds(self.map.getBounds());
        });

        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
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

    var emergencyRadiusReceiver = function () {
        var radio = $("#iRadioEmergencia").val();

        if (radio.trim() === "") {
            $("#iRadioEmergencia").closest("div").addClass("has-error");
            return false;
        }

        $("#iRadioEmergencia").val("0");
        $('#mRadioEmergencia').modal('hide');

        if (radio === 0)
            return true;

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
                infoWindow: "Radio de la emergencia",
                midas: true
            }
        });
        this.map.data.add(polygon);
        this.emergencyRadius = polygon;
    };

    var emergencyOtherReceiver = function () {
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

    var CIRCLE_VERTEX_NUM = 360;

    var generateCircleVertex = function (circle) {
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