<?php
include("presentacion/encabezado.php");
require_once("logica/Paseo.php");

$paseo = new Paseo();
$datosGraficos = $paseo->obtenerDatosGraficos();
?>

<!-- Carga Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    drawPieChart();
    drawBarChart();
    drawColumnChart();
    drawLineChart();
}

function drawPieChart() {
    var data = google.visualization.arrayToDataTable([
        ['Estado', 'Cantidad'],
        <?php foreach ($datosGraficos['porEstado'] as $row): ?>
            ['<?= $row[0] ?>', <?= $row[1] ?>],
        <?php endforeach; ?>
    ]);

    var options = {
        title: 'Distribución por Estado'
    };

    var chart = new google.visualization.PieChart(document.getElementById('chartEstado'));
    chart.draw(data, options);
}

function drawBarChart() {
    var data = google.visualization.arrayToDataTable([
        ['Paseador', 'Cantidad'],
        <?php foreach ($datosGraficos['porPaseador'] as $row): ?>
            ['<?= $row[0] ?>', <?= $row[1] ?>],
        <?php endforeach; ?>
    ]);

    var options = {
        title: 'Top Paseadores',
        legend: { position: 'none' },
        hAxis: { title: 'Cantidad de Paseos' }
    };

    var chart = new google.visualization.BarChart(document.getElementById('chartPaseador'));
    chart.draw(data, options);
}

function drawColumnChart() {
    var data = google.visualization.arrayToDataTable([
        ['Mes', 'Paseos'],
        <?php foreach ($datosGraficos['porMes'] as $row): ?>
            ['<?= $row[0] ?>', <?= $row[1] ?>],
        <?php endforeach; ?>
    ]);

    var options = {
        title: 'Paseos por Mes',
        hAxis: { title: 'Mes' },
        vAxis: { title: 'Paseos' }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chartMes'));
    chart.draw(data, options);
}

function drawLineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Mes', 'Ingresos'],
        <?php foreach ($datosGraficos['ingresos'] as $row): ?>
            ['<?= $row[0] ?>', <?= $row[1] ?>],
        <?php endforeach; ?>
    ]);

    var options = {
        title: 'Ingresos por Mes',
        hAxis: { title: 'Mes' },
        vAxis: { title: 'Ingresos' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chartIngresos'));
    chart.draw(data, options);
}
</script>

<!-- Contenedores para los gráficos -->
<div class="container mt-5">
    <h2>Estadísticas Visuales</h2>

    <div id="chartEstado" style="width: 100%; height: 400px;"></div>
    <div id="chartPaseador" style="width: 100%; height: 400px;"></div>
    <div id="chartMes" style="width: 100%; height: 400px;"></div>
    <div id="chartIngresos" style="width: 100%; height: 400px;"></div>
</div>
