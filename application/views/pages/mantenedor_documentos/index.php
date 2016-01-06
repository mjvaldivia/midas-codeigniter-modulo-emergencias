<?= loadCSS("assets/lib/dropzone/css/dropzone.css") ?>


<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Documentación
                <small><i class="fa fa-arrow-right"></i> Librer&iacute;a de documentos</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="<?= site_url() ?>"> Dashboard </a></li>
                <li class="active">Librer&iacute;a de documentos</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <!-- Striped Responsive Table -->
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#gallery" data-toggle="tab"> <i class="fa fa-list"></i> Librer&iacute;a</a>
                    </li>
                    <?php if(puedeEditar("documentacion")) { ?>
                    <li><a href="#upload" data-toggle="tab"> <i class="fa fa-upload"></i> Subir Archivo</a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="gallery">
                        <div class="col-lg-12">
                            <div class="row top-spaced">
                                <div class="col-lg-4">
                                    <!--<input type="hidden" name="taghidden" id="taghidden" value="<?php echo $this->tag; ?>" />
                                    <form method="get" action="/imagegallery/index">
                                    <div class="input-group">
                                        <input id="search" name="search" class="form-control" placeholder="Buscar..." type="text" value="<?php echo $this->search; ?>">

                                        <span class="input-group-btn">
                                            <button id="button-search" class="btn btn-default" type="button">Ir!</button>
                                        </span>
                                    </div>
                                    </form>-->
                                </div>
                                
                                <?php if(puedeEliminar("documentacion")) { ?>
                                <div class="col-lg-5">
                                    <div id="div-archivos-seleccionados" class="alert alert-warning hidden" style="padding: 7px; text-align: center;">
                                        <strong><span id="seleccionadas-cantidad"><?php echo $cantidad; ?></span></strong>
                                        Archivos seleccionados
                                    </div>
                                </div>
                                
                                <div class="col-lg-3" style="text-align: right">

                                    <button data-toggle="tooltip"  id="clear-all" class="btn btn-info" title="Limpiar todos los archivos seleccionados">
                                        <i class="fa fa-eraser"></i>
                                        Limpiar selección
                                    </button>

                                    <button data-toggle="tooltip"  id="delete-all" class="btn btn-danger" title="Borrar todos los archivos seleccionados">
                                        <i class="fa fa-ban"></i>
                                        Borrar
                                    </button>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <!--<div class="col-lg-2">
                                    <?php //echo $this->Tags($this->search); ?>
                                </div>-->
                                <div id="div-grilla-documentos" class="col-lg-12">
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <?php //echo $this->GalleryTotal($this->search, $this->tag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(puedeEditar("documentacion")) { ?>
                    <div class="tab-pane fade " id="upload">
                        <div class="col-lg-12 top-spaced">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button id="clear-files" class="btn btn-white"><i class="fa fa-eraser"></i> Limpiar archivos subidos</button>
                                </div>
                            </div>
                            <div class="row top-spaced">
                                <div class="col-lg-12">
                                    <form action="<?php echo site_url("mantenedor_documentos/upload"); ?>" class="dropzone" enctype="multipart/form-data" id="my-awesome-dropzone">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/bootbox.min.js", true) ?>
<?= loadJS("assets/lib/dropzone/dropzone.js") ?>
<?= loadJS("assets/js/modulo/mantenedor/documentos.js") ?>