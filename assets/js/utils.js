
/**
 * Created by claudio on 12-05-15.
 */
var Utils = {}; 

(function() { 
    
    
    var hexDigits = ["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"];

    var hex = function hex(x) {
        return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    };

    this.rgb2hex = function (rgb) {
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    };

    this.listenerCambioRapido = function () {
        $('#pCambioRapido').on('shown.bs.modal', function () {
            $("#users").jCombo(siteUrl + "session/obtenerJsonUsuariosImpersonables", {
                handlerLoad: function() {
                    $('#users').select2({
                        placeholder: "Seleccione usuario",
                        allowClear: true,
                        width: '100%',
                        dropdownAutoWidth: true
                    });
                }
            });
        });

        $("#btnCambioRapido").click(function () {
            var userID = $('#users').val();

            $.get(siteUrl + "session/impersonar/userID/" + userID)
                .done(function(data) {
                    location.href = siteUrl;
                }).fail(function(data) {
                });
        });
    };

    this.validaForm = function (form_id) {
        $(".has-error").removeClass("has-error");
        var bien = true;
        var message = '';
        var campos = '';
        if ($('#' + form_id).length == 0)
            return false;

        $.each($('#' + form_id + ' .required'), function (i, obj) {
            
            var tipo = $(obj).get(0).tagName;
            var id = $(obj).attr('id');


            if (tipo == 'SELECT') {
                if ($('#' + id + ' :selected').length < 1 || $('#' + id + ' :selected').val() == 0) {
                    $('#' + id).closest("div").addClass("has-error");
                    bien = false;
                    campos += "<i class='fa fa-caret-right'></i>";
                    campos += "&nbsp;" + $(obj).attr('placeholder') + "<br/>";
                }
            }
            if (tipo == 'INPUT') {
                if ($(obj).val() == '') {
                    $('#' + id).closest("div").addClass("has-error");
                    bien = false;
                    campos += "<i class='fa fa-caret-right'></i>";
                    campos += "&nbsp;" + $(obj).attr('placeholder') + "<br/>";
                }
            }
            if (tipo == 'TEXTAREA') {
                if ($(obj).val() == '') {
                    $('#' + id).closest("div").addClass("has-error");
                    bien = false;
                    campos += "<i class='fa fa-caret-right'></i>";
                    campos += "&nbsp;" + $(obj).attr('placeholder') + "<br/>";
                }
            }
            if (tipo == 'TABLE') {
                if ($('#' + id + ' tr').length <2) {
                    //$('#' + id).closest("div").addClass("has-error");
                    bien = false;
                    campos += "<i class='fa fa-caret-right'></i>";
                    campos += "&nbsp;" + $(obj).attr('placeholder') + "<br/>";
                }
            }


        });

        if (!bien) {
            message += "<span>";

            message += "Favor, asegúrese de llenar campos obligatorios.<br/>";
            message += campos;
            message += "</span>";

            bootbox.dialog({
                title: "Error",
                message: message,
                buttons: {
                    danger: {
                        label: "Cerrar",
                        className: "btn-danger"
                    }
                }
            });
        }
        return bien;
    };

    this.toggleNavbarMethod = function () {
        if ($(window).width() > 768) {
            $('.navbar .dropdown').on('mouseover', function(){
                $('.dropdown-toggle', this).trigger('click');
            }).on('mouseout', function(){
                $('.dropdown-toggle', this).trigger('click').blur();
            });
        }
        else {
            $('.navbar .dropdown').off('mouseover').off('mouseout');
        }
    };

    this.ajaxRequestMonitor = function() {
        $(document).ajaxComplete(function(event, xhr, opts) {
            switch (xhr.status) {
                case 401:
                    location.href = "http://asdigital.minsal.cl/acceso";
                    break;
                case 404:
                    alert('archivo no encontrado');
                    break;
                case 500:
                    alert("Ha ocurrido un error interno, contacte un administrador");
                    break;
            }
        });
    };
    
}).apply(Utils);