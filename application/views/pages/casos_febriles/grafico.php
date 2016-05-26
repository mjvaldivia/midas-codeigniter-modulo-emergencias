<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Reportes Gráficos Casos Febriles

            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?php echo base_url(getController()); ?>"> Casos Febriles </a></li>
                <li class="active"><i class="fa fa-area-chart"></i> Gráficos</li>
                <li class="pull-right"><a href="<?php echo base_url(getController()); ?>"> <i class="fa fa-backward"></i> Volver </a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Casos Febriles</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12">
                    <div id="pie-estados-febriles" class="" style="height:550px"></div>
                </div>
                <div class="col-xs-12 text-center" id="pie-estados-febriles-legend"></div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Semanas Epidemiológicas</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12">
                    <div id="bar-semana-estados" class="" style="height: 550px;"></div>
                </div>
                <div class="col-xs-12" id="bar-semana-estados-legend"></div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Casos confirmados por Sexo</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12">
                    <div id="bar-casos-confirmados-sexo" style="height: 550px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>