<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de Vigilancia de Vectores </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Vectores</li>
                <li class="active"><i class="fa fa-bell"></i> Imágenes</li>
            </ol>
        </div>
    </div>
</div>
<a class="btn btn-primary pull-right btn-square" href="<?php echo base_url('vectores/index')?>">Volver</a>
<div class="row" style="margin-top:15px">
    <div class="col-xs-12">

        <div id="pResultados" class="portlet portlet-default">

            <div class="portlet-body">

                <form class="form-horizontal" role="form" enctype="multipart/form-data"
                      action="<?php echo base_url("vectores/subirImagenDenuncia") ?>" method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                    <legend>Galería de imágenes para caso Nº D-<?php echo $id ?>

                    </legend>
                    <div class="form-group">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <input type="file" name="imagen" id="imagen" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-square"
                                            onclick="this.form.submit();"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($error) and $error): ?>
                            <div class="col-xs-12 col-md-6">
                                <div class="label label-danger" style="line-height: 26px;padding:10px"><i
                                        class="fa fa-exclamation-circle"></i> <?php echo $error_mensaje; ?></div>
                            </div>
                        <?php elseif (isset($error) and !$error): ?>
                            <div class="col-xs-12 col-md-6">
                                <div class="label label-success" style="line-height: 26px;padding:10px"><i
                                        class="fa fa-exclamation-circle"></i> <?php echo $error_mensaje; ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>

                <div class="col-xs-12" id="contenedor_imagenes">
                    <?php if ($imagenes): ?>
                        <div class="row">
                        <?php foreach ($imagenes as $imagen): ?>
                            <div class="col-xs-6 col-md-3" style="padding:5px;border:1px solid #111;">
                                <button type="button" class="btn btn-danger btn-sm btn-square pull-right" style="margin-bottom:5px" title="Eliminar Imagen" onclick="Vectores.eliminarImagen(<?php echo $imagen['id']?>,<?php echo $id;?>)"><i class="fa fa-trash-o"></i></button>
                                <img src="<?php echo base_url($imagen['ruta'].'/'.$imagen['nombre']) ?>" class="img-responsive" style="height: 300px;cursor:pointer;"
                                     onclick="xModal.open('<?php echo base_url('vectores/verImagenDenuncia/id/' . $imagen['id'] . '/sha/' . $imagen['sha'].'/otra/true') ?>','Imagen Denuncia D-<?php echo $id ?>','lg');"/>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= loadJS("assets/js/modulo/mapa/formulario.js"); ?>
<?= loadJS("assets/js/modulo/vectores/denuncias/denuncias.js"); ?>



