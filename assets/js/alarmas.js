/**
 * Created by claudio on 14-08-15.
 */
var Alarma = {};

(function () {
    this.inicioEdicion = function () {
        var ala_ia_id = $('#ala_ia_id').val();
        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");
        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY HH:mm"
        });
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function () {


                $.getJSON(siteUrl + 'alarma/getAlarma/id/' + ala_ia_id, function (data) {
                    var str_comunas = data.comunas;
                    if (str_comunas !== null) {
                        var arr_com = str_comunas.split(",");

                        $('#iComunas').picklist({
                            'value': arr_com
                        });
                    } else {
                        $('#iComunas').picklist();
                    }
                    $('#eme_ia_id').val(data.eme_ia_id);
                    $('#ala_ia_id').val(data.ala_ia_id);
                    $('#iNombreInformante').val(data.ala_c_nombre_informante);
                    $('#iTelefonoInformante').val(data.ala_c_telefono_informante);
                    $('#iNombreEmergencia').val(data.ala_c_nombre_emergencia);
                    $('#iTiposEmergencias').val(data.tip_ia_id);
                    $('#iLugarEmergencia').val(data.ala_c_lugar_emergencia);
                    $('#fechaEmergencia').val(data.ala_d_fecha_emergencia);
                    $('#usuarioRecepciona').val(data.usuario);
                    $('#fechaRecepcion').val(data.ala_d_fecha_recepcion);
                    $('#iObservacion').val(data.ala_c_observacion);
                    $('#ins_c_coordenada_n').val(data.ala_c_utm_lat);
                    $('#ins_c_coordenada_e').val(data.ala_c_utm_lng);
                    initialize();
                });
            },
            initial_text: null
        });

    }
    this.inicioIngreso = function () {




        $("#iTiposEmergencias").jCombo(siteUrl + "emergencia/jsonTiposEmergencias");
        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas", {
            handlerLoad: function () {
                $("#iComunas").picklist();
            },
            initial_text: null
        });
        $("#fechaEmergencia, #fechaRecepcion").datetimepicker({
            format: "DD-MM-YYYY HH:mm"
        });


    };

    this.inicioListado = function () {
        $("#TiposEmergencias").jCombo(siteUrl + "alarma/jsonTiposEmergencias");
        //$("#iEstadoAlarma").jCombo(siteUrl + "alarma/jsonEstadosAlarmas", {selected_value: 3});
        $("#btnBuscarAlarmas").click(this.eventoBtnBuscar);
        this.eventoBtnBuscar();
        $(window).resize(function () {
            $("table").css("width", "100%");
        });
    };

    this.eventoBtnBuscar = function () {

        var url = siteUrl + "alarma/jsonAlarmasDT";

        var anio = $("#iAnio").val();
        var tipoEmergencia = $("#TiposEmergencias").val();
        var estado = $("#iEstadoAlarma").val();

        if (parseInt(anio)) {
            url += "/anio/" + anio;
        }

        if (parseInt(tipoEmergencia)) {
            url += "/tipoEmergencia/" + tipoEmergencia;
        }

        if (parseInt(estado)) {
            url += "/estado/" + estado;
        } else if (parseInt(estado) !== 0)
        {
            url += "/estado/3";
        }


        var tabla = $('#tblAlarmas').DataTable();
        tabla.destroy();
        $('#tblAlarmas').empty();


        $.ajax({
            format: "json",
            cache: false,
            url: url,
            data: '',
            success: function (retorno) {
                var json = JSON.parse(retorno);

                json.columns[0]["mRender"] = function (data, type, row) {
                    var html = "";
                    var icon = '';
                    var disabled = '';
                    switch (parseInt(row.tip_ia_id)) {
                        case 1:
                        case 2:
                            icon = '<i class=\"glyphicon glyphicon-fire icono\"></i>';
                            break;
                        case 3:
                            icon = '<i class=\"fa fa-4x fa-flask icono\"></i>';
                            break;
                        case 4:
                            icon = '<i class=\"fa fa-4x fa-cloud icono\"></i>';
                            break;
                        case 5:
                            icon = '<i class=\"fa fa-4x fa-bullseye icono\"></i>';
                            break;
                        case 6:
                            icon = '<i class=\"fa fa-4x fa-life-ring icono\"></i>';
                            break;
                        case 7:
                            icon = '<i class=\"fa fa-4x fa-globe icono\"></i>';
                            break;
                        case 8:
                            icon = '<i class=\"glyphicon glyphicon-tint icono\"></i>';
                            break;
                        case 9:
                        case 10:
                            icon = '<i class=\"fa fa-4x fa-medkit icono\"></i>';
                            break;
                        case 11:
                            icon = '<i class=\"fa fa-4x fa-bomb icono\"></i>';
                            break;
                        case 12:
                        case 13:
                            icon = '<i class=\"fa fa-4x fa-user-md icono\"></i>';
                            break;
                        case 15:
                            icon = '<i class=\"fa fa-4x fa-bolt icono\"></i>';
                            break;
                        case 14:
                            icon = '<i class=\"fa fa-4x fa-bullhorn icono\"></i>';
                            break;
                    }

                    if (row.est_ia_id == 1 || row.est_ia_id == 2)
                        disabled = 'disabled';

                    var html = "";
                    html += "<div class=\"col-md-12 shadow\" style=\"padding: 10px;\">";
                    html += "    <div class=\"col-md-2 text-center\">" + icon + "</div>";
                    html += "    <div class=\"col-md-8\">";
                    html += "        <div class=\"form-group col-md-12\">";
                    html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Fecha:</label>";
                    html += "            <div class=\"col-md-8\">";
                    html += "                " + row.ala_d_fecha_emergencia + "";
                    html += "            </div>";
                    html += "        </div>";
                    html += "        <div class=\"form-group col-md-12\">";
                    html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Nombre:</label>";
                    html += "            <div class=\"col-md-8\">";
                    html += "                " + row.ala_c_nombre_emergencia + "";
                    html += "            </div>";
                    html += "        </div>";
                    html += "        <div class=\"form-group col-md-12\">";
                    html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Tipo:</label>";
                    html += "            <div class=\"col-md-8\">";
                    html += "               " + row.ala_c_tipo_emergencia + "";
                    html += "            </div>";
                    html += "        </div>";
                    html += "        <div class=\"form-group col-md-12\">";
                    html += "            <label class='col-md-4' style='text-align: right; margin-bottom: 0 !important;'>Lugar:</label>";
                    html += "            <div class=\"col-md-8\">";
                    html += "                " + row.ala_c_lugar_emergencia + "";
                    html += "            </div>";
                    html += "        </div>";
                    html += "    </div>";
                    html += "    <div class=\"col-md-2 text-center\">";
                    html += "       <div class=\"btn-group\">";
                    html += "           <a title=\"Generar emergencia\" class=\"btn btn-default " + disabled + "\" onclick=Alarma.generaEmergencia(" + row.ala_ia_id + "); >";
                    html += "               <i class=\"fa fa-bullhorn\"></i>";
                    html += "            </a>";
                    html += "           <a title=\"Editar\" class=\"btn btn-default " + disabled + "\" onclick=Alarma.editarAlarma(" + row.ala_ia_id + ")>";
                    html += "               <i class=\"fa fa-pencil\"></i>";
                    html += "           </a>";
                    html += "           <a title=\"Eliminar\" class=\"btn btn-default\" onclick=Alarma.eliminarAlarma(" + row.ala_ia_id + ")>";
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
            }
        });

    };

    this.guardarForm = function (modo) {
        if (!Utils.validaForm('frmIngresoAlarma'))
            return false;

        var params = $('#frmIngresoAlarma').serialize();
        $.post(siteUrl + "alarma/guardaAlarma", params, function (data) {
            var response = jQuery.parseJSON(data);
            var msg;

            if ($('#ala_ia_id').val()=='') //insertar
                msg = 'Se ha insertado correctamente<br>' +
                        'Estado email: ' + response.res_mail;
            else
                msg = 'Se ha editado correctamente<br>';
            if (response.ala_ia_id > 0) {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: msg
                    ,
                    buttons: {
                        danger: {
                            label: "Cerrar",
                            className: "btn-info",
                            callback: function () {
                                var tip_ia_id = $('#iTiposEmergencias').val();
                                if (tip_ia_id == 15 && false) { // por ahora no aplica el paso 2
                                    location.href = siteUrl + 'alarma/paso2/id/' + response.ala_ia_id + '/tip_ia_id/' + tip_ia_id;
                                } else {
                                    if ($("#pResultados").length) {
                                        if (modo == 1)
                                            location.href = siteUrl + 'emergencia/generaEmergencia/id/' + response.ala_ia_id;
                                        else
                                        {
                                            Alarma.eventoBtnBuscar();
                                            Alarma.limpiar();
                                        }
                                    } else { // es edicion
                                        window.close();
                                    }
                                }
                            }
                        }
                    }
                });


            } else {
                bootbox.dialog({
                    title: "Resultado de la operacion",
                    message: 'Error al insertar/editar',
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

    this.eliminarAlarma = function (id) {
        bootbox.dialog({
            title: "Eliminar elemento",
            message: '¿Está seguro que desea eliminar esta alarma?',
            buttons: {
                success: {
                    label: "Aceptar",
                    className: "btn-primary",
                    callback: function () {
                        $.get(siteUrl + 'alarma/eliminarAlarma/id/' + id).done(function (retorno) {
                            if (retorno == 0) { // sin error
                                bootbox.dialog({
                                    title: "Resultado de la operacion",
                                    message: 'Se eliminó correctamente',
                                    buttons: {
                                        danger: {
                                            label: "Cerrar",
                                            className: "btn-info",
                                            callback: function () {
                                                Alarma.eventoBtnBuscar();
                                            }
                                        }
                                    }
                                });
                            } else {
                                bootbox.dialog({
                                    title: "Resultado de la operacion",
                                    message: 'Error al eliminar',
                                    buttons: {
                                        danger: {
                                            label: "Cerrar",
                                            className: "btn-danger"
                                        }
                                    }
                                });
                            }




                        });

                    }
                },
                danger: {
                    label: "Cancelar",
                    className: "btn-default"
                }
            }

        });
    };
    this.editarAlarma = function (ala_ia_id) {
        window.open(siteUrl + 'alarma/editar/id/' + ala_ia_id, '_blank');
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

var map = null;
var marcador = {};
var geozone;
var marcador = [];
var ac;
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

        
        console.log(defaultBounds);
        
        $('#geozone').val(geozone);

        set_marker_by_inputs();


        if (marcador.length == 0)
            map.fitBounds(defaultBounds);


        ac = new google.maps.places.Autocomplete(
                (document.getElementById('iLugarEmergencia')), {
            componentRestrictions: {country: 'cl'}
        });

//        var input = $("#iLugarEmergencia").get(0);
//        var searchBox = new google.maps.places.SearchBox(input, {bounds: defaultBounds});


        ac.addListener('place_changed', function () {
            var place = ac.getPlace();
            if (place.length === 0) {
                return;
            }
            set_marker(place.geometry.location);
            setInputs(place.geometry.location);
        });

    });
}
//google.maps.event.addDomListener(window, 'load', initialize);

function set_marker(position) {

    marcador.forEach(function (marker) {
        marker.setMap(null);
    });
    marcador = [];
    marcador.push(new google.maps.Marker(
            {
                map: map,
                draggable: true,
                //animation: google.maps.Animation.DROP,
                position: position,
                icon: baseUrl + 'assets/img/referencia.png'
            }));






    google.maps.event.addListener(marcador[0], 'dragend', function ()
    {
        setInputs(marcador[0].getPosition());

    });

    map.setCenter(marcador[0].getPosition());
    map.setZoom(15);

}


function setInputs(pos)
{
    var punto = GeoEncoder.decimalDegreeToUtm(parseFloat(pos.lng()), parseFloat(pos.lat()));
    //console.log(results[0].geometry.location.lat());
    $('#ins_c_coordenada_e').val(punto[0]);
    $('#ins_c_coordenada_n').val(punto[1]);

}

function set_marker_by_inputs() {
    if ($('#ins_c_coordenada_e').val() > 0 && $('#ins_c_coordenada_n').val() > 0) {
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat($('#ins_c_coordenada_e').val()), parseFloat($('#ins_c_coordenada_n').val()), geozone);
        var punto = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        set_marker(punto);
    }
}
;


