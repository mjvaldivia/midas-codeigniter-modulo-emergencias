<div class="">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group clearfix ocultar-al-subir">
                <label for="nombre" class="control-label">Descripción (*):</label>
                <input value="" class="form-control" name="file_descripcion" id="file_descripcion">
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group clearfix ocultar-al-subir">
                <label for="nombre" class="control-label">Tipo (*):</label>
                <?php echo formElementSelectArchivoTipo("archivo_tipo", "", array("class" => "form-control")); ?>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="upload-adjunto" class="control-label ocultar-al-subir">Seleccionar archivo:</label>
                <input id="upload-adjunto" name="upload-adjunto" class="form-control ocultar-al-subir"  type="file" data-show-preview="false">
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group clearfix top-spaced">
                <button id="upload-adjunto-start" class="btn btn-success"> <i class="fa fa-plus"></i> Agregar </button>
            </div>
        </div>
    </div>
    
    <div class="row hidden">
        <div class="col-xs-12">
            <div id="upload-adjunto-error" class="alert alert-danger"></div>
        </div>
    </div>
 
    <div id="upload-adjunto-lista">
    <?php 
        if(count($lista_archivos)>0){
            foreach($lista_archivos as $archivo){
    ?>
        <div id="archivo-<?php echo $archivo["id"]; ?>" class="archivo-agregado">
            <input type="hidden" name="archivos[]" value="<?php echo $archivo["id"]; ?>" />
            <input type="hidden" name="archivos_hash[]" value="<?php echo $archivo["hash"]; ?>" />
            <hr/>
            <div class="row">
            <div class="col-md-3">
                <input type="hidden" name="archivos_descripcion[]" value="<?php echo $archivo["descripcion"]; ?>" />
                <?php echo $archivo["descripcion"]; ?>
            </div>  
            <div class="col-md-3">
                <input type="hidden" name="archivos_tipo[]" value="<?php echo $archivo["tipo"]; ?>" />
                <?php echo nombreArchivoTipo($archivo["tipo"]); ?>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url("archivo/download_file/hash/" . $archivo["hash"]) ?>" target="_blank"><?php echo $archivo["nombre"]; ?></a>
            </div>
            <div class="col-md-2 text-center">
                <button class="btn btn-xs btn-danger quitar-archivo"> 
                    <i class="fa fa-remove"></i> 
                </button>
            </div> 
            </div>
        </div>
    <?php
            }
        }
    ?>
    </div>
</div>