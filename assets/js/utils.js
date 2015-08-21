/**
 * Created by claudio on 12-05-15.
 */
var Utils = {
    listenerCambioRapido: function () {
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
    }
}