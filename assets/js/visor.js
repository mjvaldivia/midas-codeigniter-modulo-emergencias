var check_instalaciones = [];


var VisorMapa = {
    map: null,
    canvas: null,
    emergencyMarker: null,
    emergencyRadius: null,
    emergencyDrawingManager: null,
    referenciaMarker: null,
    otherDrawingManager: null,
    otherControlColor: null,
    otherControlDataColor: null,
    otherControlSelected: null,
    otherStatusInfoControl: "off",
    centro : null,
    checkInstalacion : null
};

(function () {
    var opciones = null;
    var gInfowindow;
    this.init = function (opciones) {
        this.opciones = opciones;
        $.get(siteUrl + "visor/obtenerJsonEmergenciaVisor/id/" + $("#hIdEmergencia").val()).done(this.makeMap.bind(this));
    };
    google.maps.Map.prototype.clearMarkers = function () {
        if (gInfowindow) {
            gInfowindow.close();
        }
    };
    this.makeMap = function (data) {
        var emergencia= false; 
        var ref= false;
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
            if (gInfowindow)
                gInfowindow.close();
            gInfowindow = new google.maps.InfoWindow({
                content: event.feature.getProperty("infoWindow"),
                position: event.latLng
            });

            gInfowindow.open(self.map);
        });
        this.map.addListener("zoom_changed", function (event) {
            $('.contextmenu').remove();
        });
        this.map.addListener("rightclick", function (event) {
            $('.contextmenu').remove();
        });
        this.map.addListener("click", function (event) {
            $('.contextmenu').remove();
        });
        this.map.addListener("dblclick", function (event) {
            $('.contextmenu').remove();
        });
        this.map.data.addListener("rightclick", function (event) {

            if (event.feature.getProperty('microtime'))
            {

                self.showContextMenu(event.latLng, event.feature);
            }


        });
        //dibujo el marcador de referencia que se guarda en la alarma
        var referencia = JSON.parse(json.referencia);

        if (referencia.ref_lat && referencia.ref_lng && referencia.geozone)
        {
            ref = true;
            self.drawReferencia(referencia.ref_lat, referencia.ref_lng, referencia.geozone);
            this.centro = self.referenciaMarker.getGeometry().get();

        }

        if (json.geojson)
        {
            emergencia = true;
            self.loadJson(json.geojson);
        }

        if (json.capas)
        {
            self.cargarCapas(json.capas);
        }

        if (!emergencia && !ref)
        {

            var bounds = new google.maps.LatLngBounds();

            for (var i = 0; i < json.coordinates.length; i++) {
                var c = json.coordinates[i];

                if (!c.com_c_xmin || !c.com_c_ymin || !c.com_c_xmax || !c.com_c_ymax)
                    continue;

                var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmin), parseFloat(c.com_c_ymin), c.com_c_geozone);
                bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
                latLon = GeoEncoder.utmToDecimalDegree(parseFloat(c.com_c_xmax), parseFloat(c.com_c_ymax), c.com_c_geozone);
                bounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
                this.map.fitBounds(bounds);
            }
            //console.log(latLon[0], latLon[1]);


        } 
    };
    var self = this;
    this.loadJson = function (geojson) {
        self.map.data.loadGeoJson(geojson, null, function (features) {
            for (var i = 0; i < features.length; i++) {
                
                var feature = features[i];
                if (feature.getProperty("type") == "LUGAR_EMERGENCIA") {
                    self.map.data.remove(self.referenciaMarker);
                    self.emergencyMarker = feature;
                    var gooLatLng = new google.maps.LatLng(parseFloat(feature.j.j.lat()), parseFloat(feature.j.j.lng()));
                    
                    self.centro = gooLatLng;
                   
                    
                } else if (feature.getProperty("type") == "RADIO_EMERGENCIA")
                    self.emergencyRadius = feature;

            }
            self.map.setCenter(self.centro);
            self.map.setZoom(15);
        });
    };
    this.drawReferencia = function (ref_lat, ref_lng, geozone) {
        var LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(ref_lng), parseFloat(ref_lat), geozone);

        var gooLatLng = new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1]));
        var point = new google.maps.Data.Feature({
            geometry: new google.maps.Data.Point(gooLatLng),
            properties: {
                type: "REFERENCIA",
                icon: baseUrl + "assets/img/referencia.png",
                infoWindow: 'Lugar de referencia alarma',
                nombre: 'Lugar de referencia alarma'
            }
        });
        this.map.data.add(point);
        this.referenciaMarker = point;

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
            {
                //console.log(feature);
                results.push(feature);
            }
        }
        if (results.length == 0)
            return null;
        // rendering
        var actual = null;

        var jsonDT, idTablaDT, contador;
        // tabla
        var capas = {}; //diferentes capas encontradas en el cruce
        var obj;
        var existe;
        var defaultHiddenColumns = ["midas", "icon", "infoWindow", "type", "TYPE", "LAYERNAME", 'microtime'];
        var feature;
        var type;
        var active;
        var div_tablas = $("#mInfoContent");
        var layername;
        capas.tipo = [];
        capas.layername = [];
        capas.cols = [];
        var columns;
        for (i = 0; i < results.length; i++) {

            feature = results[i];
            existe = 0;
            var actual = feature;

            $.each(capas.tipo, function (key, value) {
                if (actual.getProperty("type") == value || actual.getProperty("TYPE") == value)
                {
                    existe++;
                }

            });


            if (existe == 0)
            {
                columns = [];
                if (actual.getProperty("TYPE") != null)
                {
                    capas.tipo.push(actual.getProperty("TYPE"));
                    capas.layername.push(actual.getProperty("LAYERNAME"));

                    $.each(getFeatureProperties(actual), function (k) {

                        if (!capas.cols.hasOwnProperty(k)) {
                            obj = {};
                            obj.mData = k;
                            obj.sTitle = k;

                            if (defaultHiddenColumns.indexOf(k) != -1)
                                obj.bVisible = false;
                            columns.push(obj);
                        }
                    });

                    capas.cols.push(columns);
                } else
                if (actual.getProperty("type") != null)
                {
                    capas.tipo.push(actual.getProperty("type"));
                    capas.layername.push(actual.getProperty("type"));
                    $.each(getFeatureProperties(actual), function (j) {
                        if (!capas.cols.hasOwnProperty(j)) {
                            obj = {};
                            obj.mData = j;
                            obj.sTitle = j;

                            if (defaultHiddenColumns.indexOf(j) != -1)
                                obj.bVisible = false;
                            columns.push(obj);
                        }
                    });
                    capas.cols.push(columns);
                }

            }

        }
        div_tablas.html('');
        div_tablas.append('<ul id="ul-tabs" class="nav nav-tabs"></ul>');
        $('#ul-tabs').after('<div id="tab-content" class="tab-content"></div>');
        $.each(capas.tipo, function (key, value) {
            //console.log(capas);
            type = capas.tipo[key];
            layername = capas.layername[key];
            jsonDT = {};
            jsonDT.data = [];
            for (var k = 0; k < results.length; k++) { // por cada feature 

                feature = results[k];
                if (feature.getProperty("type") == type || feature.getProperty("TYPE") == type) // clasifico segun el tipo actual
                {
                    jsonDT.data.push(getFeatureProperties(feature));
                }
            }

            active = (key == 0) ? 'active' : '';

            $('#ul-tabs').append('<li class=' + active + '><a href="#tab' + key + '" data-toggle="tab">' + layername + '</a></li>');
            $('#tab-content').append("<div class='tab-pane " + active + "' id='tab" + key + "' style='overflow:hidden;'><div id='div_tab_" + key + "' class='col-xs-12 table-responsive'></div></div>");
            $('#div_tab_' + key).append('<table id=table_' + key + ' class="table table-bordered table-striped"><thead></thead><tbody></tbody><tfoot></tfoot></table>');
            $("#table_" + key).DataTable({
                columns: capas.cols[key],
                data: jsonDT.data,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                }
            });

        });


        $("#mInfo").appendTo('body').modal("show");
        $("#ctrlInfo").click(); // para que se apague


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
                    mData: "tipo_instalacion",
                    sTitle: "Tipo instalación"
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
    var self = this;
    this.constructControlSave = function () {

        $("#ctrlSave").click(function () {

            var geojson = {
                type: "FeatureCollection",
                features: []
            };

            //reviso las capas 
            var arr = [];
            var lista = '';
            var params = '';
            self.map.data.forEach(function (feature) {
                var existe = 0;
                if (!feature.getProperty("midas") && feature.getProperty("type")!=='REFERENCIA')
                {
                    $.each(arr, function (k, v) {
                        if (parseInt(arr[k]) == parseInt(feature.getProperty("TYPE"))) {
                            existe++;
                        }
                    });
                    if (existe == 0)
                        arr.push(feature.getProperty("TYPE"));
                }

            });
            if (arr.length > 0)
            {
                lista = arr.join(',');
                params = 'lista=' + lista;
            }
            self.map.data.toGeoJson(function (json) {
                for (var i = 0; i < json.features.length; i++) {

                    var feature = json.features[i];
                    if (!feature.properties.midas)
                        continue;

                    geojson.features.push(feature);
                }

                var json_string = JSON.stringify(geojson);
                if (params !== '')
                    params += '&';

                params += "id=" + $("#hIdEmergencia").val() + "&geoJson=" + json_string;

            });
            $.post(siteUrl + "visor/saveGeoJson", params, function (data) {
                if (data == 0) {
                    bootbox.dialog({
                        title: "Resultado de la operacion",
                        message: 'Se ha guardado correctamente',
                        buttons: {
                            danger: {
                                label: "Cerrar",
                                className: "btn-info"

                            }
                        }

                    });
                } else {
                    bootbox.dialog({
                        title: "Resultado de la operacion",
                        message: 'Error al guardar',
                        buttons: {
                            danger: {
                                label: "Cerrar",
                                className: "btn-danger"
                            }
                        }
                    });
                }
            });
        });
    };



    $("#ctrlLayers").click(function () {

       
        
        var items = $('#selected_items').val().split(',');
        
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "",
            type: "post",
            url: siteUrl + "visor/obtenerCapasDT/eme_ia_id/" + $('#hIdEmergencia').val() + "/id/" + items, 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    $("#wrapper").toggleClass("toggled");
                    $('#sortable').html(data.html);
                } else {
                    bootbox.dialog({
                        title: "Resultado de la operacion",
                        message: 'no hay capas de las comunas de la emergencia',
                        buttons: {
                            danger: {
                                label: "Cerrar",
                                className: "btn-danger"
                            }
                        }
                    });
                }
            }
        }); 
        
        /*$.get(siteUrl + 'visor/obtenerCapasDT/eme_ia_id/'+ $('#hIdEmergencia').val()+'/id/' + items, function (data) {
            
            var html = '';
            var json = JSON.parse(data);
            if(json.length==0)
            {
                bootbox.dialog({
                        title: "Resultado de la operacion",
                        message: 'no hay capas de las comunas de la emergencia',
                        buttons: {
                            danger: {
                                label: "Cerrar",
                                className: "btn-danger"
                            }
                        }
                    });
                    return false;
            } 
            $("#wrapper").toggleClass("toggled");
            
            $.each(json, function (k, v) {
                html += '<li id=' + v.cap_ia_id + ' class="ui-state-default">\n'
                        + '<div class=checkbox>\n'
                        + '<i class="fa fa-sort"></i><label>&nbsp;&nbsp;&nbsp;' + v.chkbox + '&nbsp;<img src="' + baseUrl + v.arch_c_nombre + '" height="24">&nbsp;' + v.cap_c_nombre + '</label></div></li>';
            });
            $('#sortable').html(html);
        });*/
    });

    $("#sortable").sortable({
        change: function (event, ui) {}
    });
    $("#sortable").on("sortchange", function (event, ui) {
        var arr = $("#sortable").sortable("toArray");
        //console.log(arr);
    });


    var self = this;
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
            
            self.map.data.forEach(function (feature) {
                console.log(feature.getProperty("TYPE"));
                if (feature.getProperty("TYPE") == id)
                {
                    self.map.data.remove(feature);
                }
            });
            
        }

        self.cargarCapas();
    };

    this.quitarFeature = function (microtime) {
        self.map.data.forEach(function (feature) {

            if (feature.getProperty("microtime") == microtime)
            {
                if (feature.getProperty("type") == 'LUGAR_EMERGENCIA' || feature.getProperty("type") == 'RADIO_EMERGENCIA')
                {
                    self.map.data.remove(self.emergencyRadius);
                    self.map.data.remove(self.emergencyMarker);
                    self.map.data.add(self.referenciaMarker);
                } else {
                    self.map.data.remove(feature);
                }
                $('.contextmenu').remove();
            }
        });

    };
    this.microtime = function () {
        var now = new Date()
                .getTime();
        var s = parseInt(now, 10);

        return (Math.round((now - s) * 1000) / 1000) + s;
    };
    this.showContextMenu = function (actualLatLng, feature) {
        var projection;
        var contextmenuDir;
        projection = self.map.getProjection();
        $('.contextmenu').remove();

        contextmenuDir = document.createElement("div");
        contextmenuDir.className = 'contextmenu';
        contextmenuDir.innerHTML = '<a id="menu1" onclick="VisorMapa.quitarFeature(' + feature.getProperty('microtime') + ')"><div class="context"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Quitar ' + feature.getProperty('nombre') + '</div></a>';

        $(self.map.getDiv()).append(contextmenuDir);

        self.setMenuXY(actualLatLng);

        contextmenuDir.style.visibility = "visible";
    };

    this.getCanvasXY = function (actualLatLng) {
        var scale = Math.pow(2, self.map.getZoom());
        var nw = new google.maps.LatLng(
                self.map.getBounds().getNorthEast().lat(),
                self.map.getBounds().getSouthWest().lng()
                );
        var worldCoordinateNW = self.map.getProjection().fromLatLngToPoint(nw);
        var worldCoordinate = self.map.getProjection().fromLatLngToPoint(actualLatLng);
        var actualLatLngLatLngOffset = new google.maps.Point(
                Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
                Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
                );
        return actualLatLngLatLngOffset;
    };

    this.setMenuXY = function (actualLatLng) {
        var mapWidth = $('#mapa').width();
        var mapHeight = $('#mapa').height();
        var menuWidth = $('.contextmenu').width();
        var menuHeight = $('.contextmenu').height();
        var clickedPosition = self.getCanvasXY(actualLatLng);
        var x = clickedPosition.x - 10;
        var y = clickedPosition.y - 15;

        if ((mapWidth - x) < menuWidth)//if to close to the map border, decrease x position
            x = x - menuWidth;
        if ((mapHeight - y) < menuHeight)//if to close to the map border, decrease y position
            y = y - menuHeight;

        $('.contextmenu').css('left', x);
        $('.contextmenu').css('top', y);
    };

    this.cargarCapas = function () {

        if ($('#selected_items').val() !== '') {
            var arr_select = $('#selected_items').val().split(",");

            for (var i = 0; i < arr_select.length; i++) {
                var cargada = 0;
                self.map.data.forEach(function (feature) {
                    // console.log(feature.getProperty("TYPE"));
                    if (feature.getProperty("TYPE") == arr_select[i])
                    {
                        cargada++;
                    }

                });
                
                if (cargada > 0) {
                    continue;
                }

                $.get(siteUrl + 'visor/get_json_capa/id/' + arr_select[i], function (data) {
                    var json = JSON.parse(data);
                    var geojson = JSON.parse(json.json_str);

                    var feature;
                    var arr_prop_on = json.propiedades.split(',');

                    for (var i = 0; i < geojson.features.length; i++) {

                        feature = geojson.features[i];
                        var otros = '';
                        var html = '';
                        var comuna = "";
                        var nombre = "";
                        var habilitada = 0;
                        var json_props = {};
                        $.each(feature.properties, function (key, value) {
                            for (var m = 0; m < arr_prop_on.length; m++)
                            {
                                if (key.toLowerCase() == arr_prop_on[m].toLowerCase()) {
                                    habilitada++; // solo imprimo las propiedades hablilitadas para mostrarse (administrador de capas)
                                }
                            }
                            if (habilitada > 0) {
                                if (key.toLowerCase() !== 'type') {
                                    if (key.toLowerCase() == 'comuna' && value !== null) {
                                        comuna = '<tr><td style="width:40%;">' + key + '</td><td><span style="padding-left:10px;">' + value + '</span></td><tr>';
                                    } else
                                    if ((key.toLowerCase() == 'nombre' || key.toLowerCase() == 'name') && value !== null) {

                                        nombre = value.toUpperCase();
                                    } else {
                                        otros += '<tr><td style="width:40%;">' + key + '</td><td><span style="padding-left:10px;">' + value + '</span></td><tr>';
                                    }
                                    json_props[key] = value;
                                }
                            }
                        });






                        if (nombre == '')
                        {
                            nombre = json.nombre.toUpperCase();
                        }
                        html = "<div class='infoWindow'>";
                        html += '<h4>' + nombre + '</h4><br>';
                        html += "<div class='well'>";
                        html += "<table>";
                        html += otros;
                        html += comuna;
                        html += "</table>";
                        html += "</div>";
                        html += "</div>";

                        json_props['TYPE'] = feature.properties.TYPE;
                        json_props['infoWindow'] = html;
                        json_props['LAYERNAME'] = json.nombre.toUpperCase();

                        switch (feature.geometry.type) {
                            case "Point":
                                json_props['icon'] = json.icono;

                                var LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(feature.geometry.coordinates[0]), parseFloat(feature.geometry.coordinates[1]), json.geozone);
                                var point = new google.maps.Data.Feature({
                                    geometry: new google.maps.Data.Point({lat: parseFloat(LatLng[0]), lng: parseFloat(LatLng[1])}),
                                    properties: json_props
                                });
                                self.map.data.add(point);
                                break;
                            case 'Polygon':
                                json_props['fillColor'] = json.color;
                                var arr = [[]];
                                var LatLng;

                                for (var j = 0; j < feature.geometry.coordinates[0].length; j++)
                                {
                                    LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(feature.geometry.coordinates[0][j][0]), parseFloat(feature.geometry.coordinates[0][j][1]), json.geozone);
                                    var obj = new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1]));
                                    arr[0].push(obj);
                                }
                                var polygon = new google.maps.Data.Feature({
                                    geometry: new google.maps.Data.Polygon(arr),
                                    properties: json_props
                                });
                                self.map.data.add(polygon);
                                break;
                            case 'MultiPolygon':
                                json_props['fillColor'] = json.color;
                                var LatLng;
                                for (var m = 0; m < feature.geometry.coordinates.length; m++)
                                {
                                    for (var j = 0; j < feature.geometry.coordinates[m].length; j++) {
                                        for (var j = 0; j < feature.geometry.coordinates[m].length; j++)
                                        {

                                            var arr = [[]];
                                            for (var k = 0; k < feature.geometry.coordinates[m][j].length; k++)
                                            {
                                                LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(feature.geometry.coordinates[m][j][k][0]), parseFloat(feature.geometry.coordinates[m][j][k][1]), json.geozone);
                                                var obj = new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1]));
                                                arr[0].push(obj);
                                            }
                                            var Polygon = new google.maps.Data.Feature({
                                                geometry: new google.maps.Data.Polygon(arr),
                                                properties: json_props
                                            });
                                            self.map.data.add(Polygon);
                                        }
                                    }
                                }
                                break;
                            case 'LineString':
                                json_props['strokeColor'] = json.color;
                                var arr = [];
                                var LatLng;
                                //console.log(feature.geometry.coordinates.length);return;
                                for (var p = 0; p < feature.geometry.coordinates.length; p++)
                                {
                                    LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(feature.geometry.coordinates[p][0]), parseFloat(feature.geometry.coordinates[p][1]), json.geozone);
                                    //var obj = new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1]));
                                    arr.push({lat: parseFloat(LatLng[0]), lng: parseFloat(LatLng[1])});
                                }

                                var LineString = new google.maps.Data.Feature({
                                    geometry: new google.maps.Data.LineString(arr),
                                    properties: json_props
                                });
                                self.map.data.add(LineString);
                                break;


                        }

                    }

                });
            }
        }
    };


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
            html = html.replace(/__tipo_instalacion__/g, instalacion.tipo_instalacion);
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
                    tipo_instalacion: instalacion.tipo_instalacion,
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
                cache: false,
                async: true
            },
            columns: [
                {
                    mRender: function (data, type, row) {
                        var checked = "";
                        var aux = "0";
                        /*for (var i = 0; i < facilities.length; i++) {
                            var ti = facilities[i];

                            if (row.aux_ia_id == ti.id_tipo_ins) {
                                checked = 'checked="checked"';

                                break;
                            }
                        }
                        if(checked != ''){
                            var total_check = check_instalaciones.length;
                            if(total_check == 0){
                                check_instalaciones.push(row.aux_ia_id);
                            }else{
                                for(var i=0; i<total_check; i++){
                                    var instalacion = check_instalaciones[i];

                                    if(row.aux_ia_id != instalacion){
                                        check_instalaciones.push(row.aux_ia_id);
                                    }
                                }
                            }


                        }*/
                        console.log(check_instalaciones);
                        return '<input id="iTipIns' + row.aux_ia_id + '" name="iTipIns[]" value="' + row.aux_ia_id + '" type="checkbox" ' + checked + ' class="check_instalaciones check_instalacion_'+row.aux_ia_id+'" onclick="VisorMapa.checkInstalacion(this);" />';
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

            $("#mMaestroInstalaciones").appendTo('body').modal("show");


            var total_check = check_instalaciones.length;
            for(var i=0; i<total_check; i++){
                var instalacion = check_instalaciones[i];
                $('.check_instalacion_'+instalacion).attr('checked',true);
            }
        });


        /*$('body').on('click','.check_instalaciones',function(){
            if($(this).attr('checked') === "checked"){
                check_instalaciones.push($(this).val());
            }else{
                var total_check = check_instalaciones.length;
                for(var i=0; i<total_check; i++){
                    if(check_instalaciones[i] == $(this).val()){
                        check_instalaciones.splice(i,1);
                    }
                }
            }

        })*/

        $("#btnCargarIns").click(function () {

            if(check_instalaciones.length == 0){
                bootbox.dialog({
                    title: "Atención",
                    message: 'Debe seleccionar mínimo una tipo de instalación',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info"

                        }
                    }

                });
            }else{
                var params = {};
                params.idEmergencia = $("#hIdEmergencia").val();
                params.tiposIns = check_instalaciones;
                console.log(params.tiposIns);

                $.post(siteUrl + "visor/obtenerJsonInsSegunTipIns", params).done(drawPointsIns.bind(self));
                $("#mMaestroInstalaciones").modal("hide");
            }

        });
    };


    this.checkInstalacion = function (item) {
        if($(item).is(':checked')){
            check_instalaciones.push($(item).val());
        }else{
            var total_check = check_instalaciones.length;
            for(var i=0; i<total_check; i++){
                if(check_instalaciones[i] == $(item).val()){
                    check_instalaciones.splice(i,1);
                }
            }
        }

        console.log(check_instalaciones);
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
                microtime = self.microtime();
                var point = new google.maps.Data.Feature({
                    geometry: new google.maps.Data.Point(marker.getPosition()),
                    properties: {
                        type: "LUGAR_EMERGENCIA",
                        icon: baseUrl + "assets/img/emergencia.png",
                        infoWindow: "Lugar de la emergencia",
                        midas: true,
                        microtime: microtime,
                        nombre: 'Lugar de la Emergencia'
                    }
                });

                self.map.data.add(point);
                self.emergencyMarker = point;
                self.map.setCenter(self.emergencyMarker.getGeometry().get());
                $("#mRadioEmergencia").appendTo('body').modal({backdrop: 'static',keyboard:false});
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
                    $("#mOtrosEmergencias").appendTo('body').modal("show");
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
            var microtime = self.microtime();
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
                            nombre: self.otherControlSelected.title,
                            microtime: microtime,
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
                            nombre: self.otherControlSelected.title,
                            microtime: microtime,
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
                            nombre: self.otherControlSelected.title,
                            microtime: microtime,
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
                            nombre: self.otherControlSelected.title,
                            microtime: microtime,
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
                            nombre: self.otherControlSelected.title,
                            microtime: microtime,
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
            console.log(searchBox.getPlaces());
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
        var microtime = self.microtime();
        var polygon = new google.maps.Data.Feature({
            geometry: new google.maps.Data.Polygon(vertex),
            properties: {
                fillColor: "#FF0000",
                type: "RADIO_EMERGENCIA",
                infoWindow: "Radio de la emergencia",
                midas: true,
                microtime : microtime,
                nombre: 'Lugar de la Emergencia'
            }
        });
        this.map.data.add(polygon);
        this.emergencyRadius = polygon;
        this.map.data.remove(this.referenciaMarker);
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