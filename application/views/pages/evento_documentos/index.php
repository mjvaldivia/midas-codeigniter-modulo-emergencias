
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Documentos
                <small><i class="fa fa-arrow-right"></i> <?php echo $nombre; ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="<?= site_url() ?>"> Inicio </a></li>
                <li><i class="fa fa-bullhorn"></i> Evento </li>
                <li class="active">Documentos</li>
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
                                <div class="col-lg-8">
                                    <input type="hidden" name="taghidden" id="taghidden" value="<?php echo $this->tag; ?>" />
                                    <form method="get" action="/imagegallery/index">
                                    <div class="input-group">
                                        <input id="search" name="search" class="form-control" placeholder="Buscar..." type="text" value="<?php echo $this->search; ?>">

                                        <span class="input-group-btn">
                                            <button id="button-search" class="btn btn-default" type="button">Ir!</button>
                                        </span>
                                    </div>
                                    </form>
                                </div>
                                
                                <div class="col-lg-4 text-right">
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="div-archivos-seleccionados" class="hidden">
                                                <strong><span id="seleccionadas-cantidad"><?php echo $cantidad; ?></span></strong>
                                                Archivos seleccionados
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="position: relative;">
                                        <div class="col-lg-12">

                                            <button data-toggle="tooltip"  id="clear-all" class="btn btn-info" title="Limpiar todos los archivos seleccionados">
                                                <i class="fa fa-eraser"></i>
                                                Limpiar seleccionados
                                            </button>

                                            <button data-toggle="tooltip"  id="delete-all" class="btn btn-danger" title="Borrar todos los archivos seleccionados">
                                                <i class="fa fa-ban"></i>
                                                Borrar seleccionados
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row top-spaced">
                                <div id="div-grilla-documentos" >
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade " id="upload">
                        <div class="col-lg-12 top-spaced">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button id="clear-files" class="btn btn-white"><i class="fa fa-eraser"></i> Limpiar archivos subidos</button>
                                </div>
                            </div>
                            <div class="row top-spaced">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo formElementEventoArchivos(""); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
