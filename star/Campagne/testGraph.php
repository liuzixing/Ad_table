<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<head>
    <link rel="icon" href="leadsmonitor.png">
    <title id='Description'>Leadsmonitor</title>
    <!-- Bootstrap core CSS -->
    <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../external_library/jqwidgets/jqx-all.js"></script>
    <script type="text/javascript" src="../js/TimeSeriesController.js"></script>

    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
</head>
<body id='Campagne'>
    <div class="container">
        <div id="chart" style="width:1000px;height:500px"></div>
        <div id='selectorContainer' style="width:500px; height:100px;">
        </div>
        <!-- Static navbar --> </div>
    <!-- /container -->
    <!-- /print the libraries -->
    <script type="text/javascript">
        $(document).ready(function () {
            var minDate = new Date("2014-05-27");

            console.log(minDate.getMonth()+"-"+minDate.getFullYear().toString().substring(2));
            var chart = new TimeSeriesController();
  chart.initialChart('http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne_graph_default.php?client='+'Balsamik');
        });
    </script>
</body>
</html>