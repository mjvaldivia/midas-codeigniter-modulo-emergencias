/**
 * Created by claudio on 15-09-15.
 */
var Layer = {};

(function() {
    this.initList = function() {
        $("#tblCapas").DataTable({
            dom: "B<'separator'><'row'<'col-md-6'l><'col-md-6 text-right'f>>rtip",
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            }
        });
    };

    this.initSave = function() {
        $("#input-icon").fileinput({
            language: "es",
            uploadUrl: siteUrl + "capas/subirCapa",
            uploadAsync: true,
            initialCaption: "Seleccione icono",
            previewSettings: {
                image: {
                    width: "auto", height: "160px"
                }
            },
            showClose: false,
            previewClass: "small"
        });

        $("#iComunas").jCombo(siteUrl + "session/obtenerJsonComunas");
    };
}).apply(Layer);