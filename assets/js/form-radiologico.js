var FormRadiologico = {};

(function() {
    this.inicio = function() {
        $("#iDocMaterial").fileinput({
            language: "es",
            uploadUrl: siteUrl + "visor/subirKML",
            uploadAsync: true,
            multiple: true,
            initialCaption: "Seleccione archivos y luego presione subir",
            allowedFileExtensions: ["doc", "docx", "xls", "xlsx", "pdf"]
        });

        this.iniciaHandlers();
    };

    this.iniciaHandlers = function() {
        $("#iViaPublica").click(function() {
            if ($(this).is(":checked")) {
                $("div.viaPublica").slideDown("slow");
                if ($("#iPropiedadPrivada").is(":checked")) {
                    $("#iPropiedadPrivada").click();
                    $("div.propiedadPrivada").find("input[type='checkbox']:checked").prop("checked", false);
                }
            } else {
                $("div.viaPublica").slideUp("slow");
            }
        });
        $("#iPropiedadPrivada").click(function() {
            if ($(this).is(":checked")) {
                $("div.propiedadPrivada").slideDown("slow");
                if ($("#iViaPublica").is(":checked")) {
                    $("#iViaPublica").click();
                    $("div.viaPublica").find("input[type='checkbox']:checked").prop("checked", false);
                }
            } else {
                $("div.propiedadPrivada").slideUp("slow");
            }
        });
    };
}).apply(FormRadiologico);