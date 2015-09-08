/**
 * Created by claudio on 12-05-15.
 */
var Utils = {};

(function() {
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
    
        this.validaForm = function(form_id) {
        $(".has-error").removeClass("has-error");
        var bien = true;
        var message = '';
        var campos = '';
        if($('#'+form_id).length==0)
            return false;
        
        $.each($('#'+form_id+' .required'), function (i, obj) {
        
                    var tipo = $(obj).get(0).tagName;
                    var id = $(obj).attr('id');
                    
                    
                    if(tipo=='SELECT'){
                        if($('#'+id+' :selected').length<1 || $('#'+id+' :selected').val()==0) {
                          $('#'+id).closest("div").addClass("has-error");  bien = false;
                          campos += "<i class='fa fa-caret-right'></i>";
                          campos += "&nbsp;"+$('#'+id).attr('placeholder')+"<br/>";
                        }}
                    if(tipo=='INPUT'){
                        if($('#'+id).val()=='') {
                          $('#'+id).closest("div").addClass("has-error"); bien = false; 
                          campos += "<i class='fa fa-caret-right'></i>";
                          campos += "&nbsp;"+$('#'+id).attr('placeholder')+"<br/>";
                        }}
                    if(tipo=='TEXTAREA'){
                        if($('#'+id).val()=='') {
                          $('#'+id).closest("div").addClass("has-error"); bien = false; 
                          campos += "<i class='fa fa-caret-right'></i>";
                          campos += "&nbsp;"+$('#'+id).attr('placeholder')+"<br/>";
                        }}
                    
                    
                });
                
        if (!bien) {
            message += "<span>";
            
            message += "Favor, asegúrese de llenar campos obligatorios.<br/>";
            message +=campos;
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
    
}).apply(Utils);