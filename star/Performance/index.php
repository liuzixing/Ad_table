<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<head>
    <link rel="icon" href="../img/leadsmonitor.png">
    <title id='Description'>Leadsmonitor</title>
    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">
</head>
<body id='Performance'>
    <div class="container">
      <!-- Static navbar -->
      <?php include '../header.php';?>

      <!-- Main component for a primary marketing message or call to action -->
  <div id="splitContainer">
        <div>
            <div class="jqx-hideborder jqx-hidescrollbars" id="settingArea">
                <ul>
                    <li style="margin-left: 30px;">Options</li>
                    <li>Filters</li>
                </ul>
                <div>
                    <div style="margin-top: 10px;">
                        <div id='datepicker1' style="float:left"></div>
                    </div>
                    <div class="Comparaison-setter" style="margin-top: 45px;">
                            <div class="Comparaison-label" style="float:left;weight:40%;vertical-align:middle;font-size:15px ;height:25px;line-height:25px; text-align:center">Comparaison</div>
                            <div id="Comparaison" style="float:right"></div>
                    </div>
                    <div style="margin-top: 80px;">
                        <div id='datepicker2' style="float:left"></div>
                    </div>
                    <div id='xaxisselector' style="margin-top: 115px;"></div>
                    <div id='yaxisselector' style="margin-top: 10px;"></div>
                    <div id='regroupement' style="margin-top: 10px;"></div>
                    <div style="margin-top: 10px;">
                            <input  type="button" id="btn_default" value="default" />
                            <input style="float:right" type="button" id="btn_validez" value="validez" />
                    </div>

                </div>
                <div>
                <!--  filter components-->
                    <div id='Chaîne' style="margin-top: 10px;"></div>
                    <div id='Version' style="margin-top: 10px;"></div>
                    <div id='Format' style="margin-top: 10px;"></div>
                    <div id='Catégorie' style="margin-top: 10px;"></div>
                    <div id='MMDaypart' style="margin-top: 10px;"></div>
                    <div id='Dayofweek' style="margin-top: 10px;"></div>
                    <div class="Optimisation-setter" style="margin-top: 10px;">
                            <div class="Optimisation-label" style="float:left;weight:40%;font-size:20px">Optimisation</div>
                            <div id="Optimisation" style="float:right"></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div id="splitter">
                <div  id="chart" >
                </div>
                <div style="width:100%;height:100%">
                <div id="jqxgrid">
                </div>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- /container -->
    <!-- /print the libraries -->
    <?php include '../library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.getScript("../js/PerformanceController.js", function() {
                        PerformanceController();
                });
        });
    </script>
</body>
</html>