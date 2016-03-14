<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Reportes Gráficos Casos Febriles

            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Casos Febriles </a></li>
                <li class="active"><i class="fa fa-bell"></i> Gráficos</li>
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
                <div class="col-xs-12 col-md-9">
                    <canvas id="pie-estados-febriles" class="" style="height: 350px"></canvas>
                </div>
                <div class="col-xs-12 col-md-3 text-center" id="pie-estados-febriles-legend"></div>
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
                    <canvas id="bar-semana-estados" class="" style="height: 350px;"></canvas>
                </div>
                <div class="col-xs-12" id="bar-semana-estados-legend"></div>
            </div>
        </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<?php echo loadJS('assets/js/library/chartjs/Chart.StackedBar.js');?>

<script>
    $(document).ready(function () {
        Chart.defaults.global.responsive = true;

        /** grafico Casos Febriles **/
        var ctx = document.getElementById("pie-estados-febriles").getContext("2d");
        var data = <?php echo $estados?>;
        var options = {legendTemplate: "<ul style=\"list-style: none;padding-left:0;\" class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li style=\"padding:2px;color:#fff;background-color:<%=segments[i].fillColor%>\"><span style=\"display:block;background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"};
        var myPieChart = new Chart(ctx).Pie(data, options);
        $("#pie-estados-febriles-legend").append(myPieChart.generateLegend());


        /** grafico Semanas - Numero de Casos **/
        var ctx = document.getElementById("bar-semana-estados").getContext("2d");
        var data = {
            labels: <?php echo $semanas_labels?>,
            datasets: [
                {
                    label: "Casos Positivos",
                    fillColor: "#e74c3c",
                    strokeColor: "#e74c3",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: <?php echo $semanas_positivo?>
                },
                {
                    label: "Casos Sospechosos",
                    fillColor: "#f39c12",
                    strokeColor: "#f39c12",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: <?php echo $semanas_sospechoso?>
                },
                {
                    label: "No Concluyente",
                    fillColor: "#2980b9",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: <?php echo $semanas_no_concluyente?>
                },
                {
                    label: "Descartados",
                    fillColor: "#16a085",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: <?php echo $semanas_negativo?>
                }

            ]
        };
        var options = {
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            tooltipHideZero: true
        };
        var myBarChart = new Chart(ctx).StackedBar(data,options);
        $("#bar-semana-estados-legend").append(myBarChart.generateLegend());

    });

</script>