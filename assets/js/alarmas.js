/**
 * Created by claudio on 14-08-15.
 */
var Alarma = {};

(function () {
    this.inicioIngreso = function () {
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function () {
                $("#iComunas").picklist();
            },
            initial_text: null
        });

        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });


    };


    this.inicioListado = function () {
        $("#iTiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        $("#iEstadoAlarma").jCombo(siteUrl + "alarma/jsonEstadosAlarmas");
        $("#btnBuscarAlarmas").click(this.eventoBtnBuscar);
        $(window).resize(function () {
            $("table").css("width", "100%");
        });
    };

    this.eventoBtnBuscar = function () {

        var url = siteUrl + "alarma/jsonAlarmasDT";

        var anio = $("#iAnio").val();
        var tipoEmergencia = $("#iTiposEmergencias").val();
        var estado = $("#iEstadoAlarma").val();

        if (parseInt(anio)) {
            url += "/anio/" + anio;
        }

        if (parseInt(tipoEmergencia)) {
            url += "/tipoEmergencia/" + tipoEmergencia;
        }

        if (parseInt(estado)) {
            url += "/estado/" + estado;
        }

        var tabla = $('#tblAlarmas').DataTable();
        tabla.destroy();
        $('#tblAlarmas').empty();

        $.get(url).done(function (retorno) {
            var json = JSON.parse(retorno);

            json.columns[0]["mRender"] = function (data, type, row) {
                var html = "";
                var clase = '';
                switch (parseInt(row.tip_ia_id)) {
                    case 1:
                    case 2:
                        clase = 'incendio';
                        break;
                    case 3:
                        clase = 'quimico';
                        break;
                    case 4:
                        clase = 'meteorologico';
                        break;
                    case 5:
                        clase = 'sismo';
                        break;
                    case 6:
                        clase = 'tsunami';
                        break;
                    case 7:
                        clase = 'volcan';
                        break;
                    case 8:
                        clase = 'sequias';
                        break;
                    case 9:
                    case 10:
                        clase = 'accidente';
                        break;
                    case 11:
                        clase = 'terrorista';
                        break;
                    case 12:
                    case 13:
                        clase = 'salud';
                        break;
                    case 15:
                        clase = 'radiologica';
                        break;
                    case 14:
                        clase = 'otro';
                        break;
                }

                var html = "";
                html += "<div class=\"col-md-12 shadow\" style=\"padding: 10px;\">";
                html += "    <div class=\"col-md-2 text-center\"><div class='" + clase + "'/></div></div>";
                html += "    <div class=\"col-md-8\">";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Fecha de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_d_fecha_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Nombre de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_nombre_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Tipo de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_tipo_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "        <div class=\"form-group col-md-12\">";
                html += "            <label for=\"\" class=\"col-md-4 control-label\">Lugar de la emergencia:</label>";
                html += "            <div class=\"col-md-8\">";
                html += "                <p>" + row.ala_c_lugar_emergencia + "</p>";
                html += "            </div>";
                html += "        </div>";
                html += "    </div>";
                html += "    <div class=\"col-md-2 text-center\">";
                html += "       <div class=\"btn-group\">";
                html += "           <a title=\"Generar emergencia\" class=\"btn btn-default\" onclick=Alarma.generaEmergencia(" + row.ala_ia_id + "); >";
                html += "               <i class=\"fa fa-exclamation-triangle\"></i>";
                html += "            </a>";
                html += "           <a title=\"Editar\" class=\"btn btn-default\">";
                html += "               <i class=\"fa fa-pencil\"></i>";
                html += "           </a>";
                html += "           <a title=\"Eliminar\" class=\"btn btn-default\">";
                html += "               <i class=\"fa fa-trash\"></i>";
                html += "           </a>";
                html += "       </div>";
                html += "    </div>";
                html += "</div>";

                return html;
            };

            $("#tblAlarmas").DataTable({
                data: json.data,
                columns: json.columns,
                language: {
                    url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                },
                order: [[0, "desc"]]
            });
            $("#pResultados").css("visibility", "visible");
            $("#pResultados").slideDown("slow");
        });
    };

    this.guardarForm = function () {
        if (!Utils.validaForm('frmIngresoAlarma'))
            return false;

        var params = $('#frmIngresoAlarma').serialize();
        $.post(siteUrl + "alarma/guardaAlarma", params, function (data) {
            var response = jQuery.parseJSON(data);
            if (response.ala_ia_id > 0) {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Se ha insertado correctamente<br>' +
                            'Estado email: ' + response.res_mail
                    ,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info",
                            callback: function () {
                                var tip_ia_id = $('#iTiposEmergencias').val();
                                if (tip_ia_id == 15) {
                                    location.href = siteUrl + 'alarma/paso2/id/' + data + '/tip_ia_id/' + tip_ia_id;
                                } else {
                                    Alarma.limpiar();
                                }
                            }
                        }
                    }
                });


            } else {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Error al insertar',
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-danger"
                        }
                    }
                });
            }
        });
    };

    this.generaEmergencia = function (ala_ia_id) {
        window.open(siteUrl + 'emergencia/generaEmergencia/id/' + ala_ia_id, '_blank');
    };

    this.limpiar = function () {
        $('#frmIngresoAlarma')[0].reset();
        $('#iComunas').picklist('destroy');
        $('#iComunas').picklist();
    };

}).apply(Alarma);

var map;
var marcador = {};
var geozone;
var marcador = [];
function initialize() {
    $.getJSON(siteUrl + 'session/getMinMaxUsr', null, function (data) {
        var defaultBounds = new google.maps.LatLngBounds();
        var mapProp = {
            center: new google.maps.LatLng(-33.07, -71.6),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map($("#map").get(0), mapProp);
        geozone = data.com_c_geozone;
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(data.com_c_xmin), parseFloat(data.com_c_ymin), geozone);
        defaultBounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
        latLon = GeoEncoder.utmToDecimalDegree(parseFloat(data.com_c_xmax), parseFloat(data.com_c_ymax), geozone);
        defaultBounds.extend(new google.maps.LatLng(latLon[0], latLon[1]));
        map.fitBounds(defaultBounds);




        new google.maps.places.Autocomplete(
                (document.getElementById('iLugarEmergencia')), {
            componentRestrictions: {country: 'cl'}
        });

        var input = $("#iLugarEmergencia").get(0);
        var searchBox = new google.maps.places.SearchBox(input,{bounds: defaultBounds});

        google.maps.event.addListener(map, 'bounds_changed', function() {
        var bounds = map.getBounds();
        searchBox.setBounds(bounds);
        });

        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            marcador.forEach(function (marker) {
                marker.setMap(null);
            });
            marcador = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {



                marcador.push(new google.maps.Marker(
                        {
                            map: map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            position: place.geometry.location
                        }));
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                
                geocodePosition(place.geometry.location);
                
            });


            google.maps.event.addListener(marcador[0], 'dragend', function ()
            {
                geocodePosition(marcador[0].getPosition());

            });
            map.fitBounds(bounds);
        });
    });

}
google.maps.event.addDomListener(window, 'load', initialize);




function geocodePosition(pos)
{
    geocoder = new google.maps.Geocoder();
    geocoder.geocode
            ({
                latLng: pos
            },
                    function (results, status)
                    {
                        if (status == google.maps.GeocoderStatus.OK) {
                            var punto = GeoEncoder.decimalDegreeToUtm(parseFloat(results[0].geometry.location.lat()), parseFloat(results[0].geometry.location.lng()));
                            //console.log(results[0].geometry.location.lat());
                            $('#ins_c_coordenada_e').val(punto[1]);
                            $('#ins_c_coordenada_n').val(punto[0]);
                        } else {
                            $('#ins_c_coordenada_e').val("");
                            $('#ins_c_coordenada_n').val("");
                            bootbox.dialog({
                                message: "No se ha encontrado sugerencia para la dirección brindada",
                                title: "Resultado de la operación",
                                buttons: {
                                    success: {
                                        label: "Cerrar",
                                        className: "btn-danger",
                                        callback: function () {}
                                    }
                                }
                            });
                        }
                        $('#ins_c_coordenada_e').keyup();
                    }
            );
}


