<div class="row">
    <form class="form-horizontal">
        <div class="col-md-12 top-spaced">
            <input id="acta" name="acta[]" class="form-control" type="file" data-show-preview="false" multiple/>
        </div>
    </form>
</div>

<div class="text-center top-spaced-doble">
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>


<?= loadCSS("assets/js/library/bootstrap-fileinput/css/fileinput.css") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput.js") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<script>
    $("#acta").fileinput({
        language: "es",
        multiple: true,
        uploadAsync: false,
        initialCaption: "Seleccione archivo",
        allowedFileExtensions : ['pdf','png','jpg'],
        uploadUrl: siteUrl + "marea_roja/subir_acta/id/<?php echo $id?>"
    });

    $('#acta').on('filebatchuploadsuccess', function(event, data) {
        if(data.response.estado == true){
            xModal.success(data.response.mensaje);
        }else{
            xModal.danger(data.response.mensaje);
        }
    });
</script>
