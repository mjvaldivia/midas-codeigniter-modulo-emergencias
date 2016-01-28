var FormTipoEmergenciaGeneral = Class({
    
    iniciarUpload : function () {
        var yo = this;
        
        var ala_ia_id = $('#ala_id').val();
        $("#iDocMaterial").fileinput({
            language: "es",
            uploadUrl: siteUrl + "archivo/subir/tipo/5/id/" + ala_ia_id,
            uploadAsync: true,
            multiple: true,
            initialCaption: "Seleccione archivos y luego presione subir",
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object']
        });
        
        $('#iDocMaterial').on('filebatchuploadcomplete', function () {
            yo.dibujaTablaDocs();
        });
    },
    
    dibujaTablaDocs : function () {

        var ala_ia_id = $('#ala_id').val();
        $("#tabla_doc").dataTable().fnDestroy();
        $('#tabla_doc').dataTable({
            ajax: {
                url: siteUrl + 'archivo/getDocs/id/' + ala_ia_id + '/tipo/5',
                type: 'POST',
                async: true
            },
            language: {
                url: baseUrl + "assets/js/library/DataTables-1.10.8/Spanish.json"
            },
             "aoColumns": [
                null,
                null,
                null,
                {"sClass": "text-center"}
            ]
        });
        $("#tabla_doc").wrap("<div class='col-sm-12' style='padding-left:0px !important;'></div>");
    }
});

