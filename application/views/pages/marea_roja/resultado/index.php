<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>  Marea roja - Ingreso de resultados
                <div class="pull-right">

                    <a target="_blank" id="descargar" class="btn btn-default btn-square">
                        <i class="fa fa-download"></i>
                        Descargar excel
                    </a>

                </div>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Marea roja </li>
                <li class="active">
                    <i class="fa fa-bell"></i> Resultados 
                </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-default top-spaced">
            <div class="portlet-body"> 
                <div class="row">
                    
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label for="region" class="control-label">Región</label>
                            <?php 
                                echo formElementSelectRegionUsuario(
                                    "region", 
                                    "", 
                                    array(
                                        "class" => "form-control region",
                                        "data-rel" => "comuna"
                                    )
                                ); ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label for="comuna" class="control-label">Comuna</label>
                            <div id="select-comuna">
                            <?php echo formSelectComuna("comuna", "", ""); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label for="numero_muestra" class="control-label">N° de muestra</label>
                            <input type="text" class="form-control" id="numero_muestra" name="numero_muestra"/>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button id="buscar" type="button" class="btn btn-primary btn-square btn-buscar top-spaced">
                            <i class="fa fa-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">                        
        <div id="pResultados" class="portlet portlet-default hidden">
            <div class="portlet-body"> 
                <div class="row">
                    <div class="col-lg-12">
                        <div id="resultados" class="table-responsive" data-row="20">
                            <div class="col-lg-12 text-center" style="height: 100px;">
                                <i class="fa fa-4x fa-spin fa-spinner"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css"); ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js"); ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js"); ?>
