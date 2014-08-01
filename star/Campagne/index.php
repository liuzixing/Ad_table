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
<body id='Campagne'>
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
                    <!--  options components-->
                    <div style="margin-top: 10px;">
                        <div id='datepicker1' style="float:left"></div>
                        <div id='datepicker2' style="float:right"></div>
                    </div>
                    <div id='valueselector1' style="margin-top: 10px;"></div>
                    <div id='valueselector2' style="margin-top: 10px;"></div>
                    <div id='valueselector3' style="margin-top: 10px;"></div>
                    <div style="margin-top: 10px;">
                            <input  type="button" id="btn_default" value="default" />
                            <input style="float:right" type="button" id="btn_validez" value="validez" />
                    </div>

                </div>
                <div>
                <!--  filters components-->
                    <div id='Chaîne' style="margin-top: 10px;"></div>
                    <div id='Version' style="margin-top: 10px;"></div>
                    <div id='Format' style="margin-top: 10px;"></div>
                    <div class="Optimisation-setter" style="margin-top: 10px;">
                            <div class="Optimisation-label" style="float:left;weight:40%;font-size:20px">Optimisation</div>
                            <div id="Optimisation" style="float:right"></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div id="splitter">
                <div>
                    <div class="jqx-hideborder jqx-hidescrollbars" id="graphArea">
                        <ul>
                            <li style="margin-left: 30px;">Graph</li>
                            <li></li>
                        </ul>
                        <div  id="chart" >
                        </div>
                        <div></div>
                    </div>
                </div>
                <div>
                    <div class="jqx-hideborder jqx-hidescrollbars" id="tableArea">
                        <ul>
                            <li style="margin-left: 30px;">Table</li>
                            <li></li>
                        </ul>
                        <div id="jqxgrid" >
                            <!-- <div id="jqxgrid"></div> -->
                        </div>
                        <div></div>
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
            $.getScript("../js/CampagneController.js", function() {
                        CampagneController();
                });
        });
    </script>
</body>
</html>