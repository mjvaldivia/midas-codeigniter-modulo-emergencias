var ExportMap = {
    map: null,
    mapOptions: null,
    referenciaMarker: null,
    centro: null,
    funciones: []
};
(function () {
    var self = this;
    this.mapOptions = {
        // center: new google.maps.LatLng(-33.07, -71.6),
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        streetViewControl: false,
        mapTypeControl: false
    };
    this.LoadMap = function () {
        window.parent.Emergencia.cargando();
        this.map = new google.maps.Map(document.getElementById("dvMap"), this.mapOptions);



        $.get(siteUrl + "visor/obtenerJsonEmergenciaVisor/id/" + $("#eme_ia_id").val()).done(
                self.loadObjects.bind(this)
                );
        google.maps.event.addListenerOnce(self.map, 'tilesloaded', function () {

            setTimeout(function () {
                self.renderImage();
            }, 500);

        });

    };




    this.loadObjects = function (data) {

        var json = JSON.parse(data);
        //var bounds = new google.maps.LatLngBounds();



        self.map.data.setStyle(function (feature) {
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

        var referencia = JSON.parse(json.referencia);

        if (referencia.ref_lat && referencia.ref_lng && referencia.geozone)
        {
            self.drawReferencia(referencia.ref_lat, referencia.ref_lng, referencia.geozone);
            self.centro = self.referenciaMarker.getGeometry().get();

        }

        if (json.geojson)
        {
            self.loadJson(json.geojson);
        }

        if (json.capas)
        {
            self.cargarCapas(json.capas);
        }

        if ((json.geojson == 0 || !json.geojson) && !json.capas)
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
            }
            //console.log(latLon[0], latLon[1]);
            self.map.fitBounds(bounds);
        } else {
            self.map.setCenter(self.centro);
        }
        self.map.setZoom(16);

    };

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
        self.map.data.add(point);
        self.referenciaMarker = point;

    };
    this.cargarCapas = function (capas) {

        if (capas !== '') {
            var arr_select = capas.split(",");
            for (var m = 0; m < arr_select.length; m++) {

                var cargada = 0;
                self.map.data.forEach(function (feature) {
                    // console.log(feature.getProperty("TYPE"));
                    if (feature.getProperty("TYPE") == arr_select[m])
                    {
                        cargada++;
                    }

                });
                if (cargada > 0) {
                    continue;
                }

                $.get(siteUrl + 'visor/get_json_capa/id/' + arr_select[m], function (data) {
                    var json = JSON.parse(data);
                    var geojson = JSON.parse(json.json_str);
                    //console.log(geojson);
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
                                json_props['fillColor'] = '#999999';
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
                                json_props['fillColor'] = '#999999';
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
                                json_props['strokeColor'] = '#0000FF';
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

    this.microtime = function () {
        var now = new Date()
                .getTime();
        var s = parseInt(now, 10);

        return (Math.round((now - s) * 1000) / 1000) + s;
    };
    this.renderImage = function () {
        html2canvas($('#dvMap'), {
            useCORS: true,
            onrendered: function (canvas) {
                var dataUrl = canvas.toDataURL("image/jpg");
                dataUrl = dataUrl.replace(/^data:image\/(png|jpg);base64,/, "");

                var d = {str: dataUrl, eme_ia_id: $('#eme_ia_id').val(), m: self.microtime()};


                $.ajax({
                    url: siteUrl + 'visor/getMapImage',
                    dataType: 'json',
                    data: d,
                    type: 'POST',
                    success: function (data) {
                        if (data.k !== 0)
                        {
                            window.parent.Emergencia.cargando();
                             window.open(siteUrl + 'visor/getReporte/id/' + $('#eme_ia_id').val() + '/k/' + data.k, "_blank");
                             window.parent.Emergencia.closeIframe($('#eme_ia_id').val());
                        }
                    }
                });

            }

        });

    };

}).apply(ExportMap);