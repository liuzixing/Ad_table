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
     <!--  <link href="../external_library/bootstrap/css/bootstrap-custom.css" rel="stylesheet"> -->

<body id='Concurrence'>
    <div class="container-fluid">
        <!-- Static navbar -->
        <?php include '../header.php';?>

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
            <div id='clientlogo' >
                    <div style="width:100%;text-align: center;height:30px;font-size:12px">www.mymedia.com</div>
                    <div>
                    </div>
                </div>
                <div id='options' >
                    <div style="width:100%;text-align: center;height:30px;font-size:16px">Options</div>
                    <div>
                        <div style="margin-top: 10px;">
                            <div id='datepicker1' style="margin-left:5%;float:left"></div>
                        </div>
                        <div id='concurrenceselector' style="margin-top: 45px;margin-left:5%;"></div>
                        <div id='channelselector' style="margin-top: 10px;margin-bottom:10px;margin-left:5%;"></div>
                        <!-- <div style="margin-top: 10px;">
                            <input  type="button" id="btn_default" value="default" />
                            <input style="float:right" type="button" id="btn_validez" value="validez" />
                        </div> -->
                    </div>
                </div>
                <div id='filters'>
                    <div style="width:100%;text-align: center;height:30px;font-size:16px">Filters</div>
                    <div>
                        <div id='Version' style="margin-top: 10px;margin-left:5%;"></div>
                        <div id='Format' style="margin-top: 10px;margin-left:5%;"></div>
                        <div class="Optimisation-setter" style="margin-top: 10px;margin-left:5%;margin-bottom:50px;">
                            <div class="Optimisation-label" style="float:left;weight:35%;font-size:17px">Optimisation</div>
                            <div id="Optimisation" style="float:right;margin-right:5%;"></div>
                        </div>
                    </div>
                </div>
                <div id='validation' style="">
                    <div style="width:100%;text-align: center;height:30px;font-size:16px">VALIDATION</div>
                    <div >
                        <button class="button" style ="margin-left:5%;margin-bottom:10px;width:90%;">Valider</button>
                    </div>
                </div>
            </div>
            <div>
                <div id="splitter">
                    <div  id="chart" ></div>
                    <div style="width:100%;height:100%">
                        <div>
                            <button class="button">Exporter</button>
                        </div>
                        <div style="margin: 15px 15px 15px 15px;height:75%">
                            <div id="jqxgrid" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /container -->
    <!-- /print the libraries -->
    <?php include '../library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.getScript("../js/ConcurrenceController.js", function() {
                        ConcurrenceController();
                });
        });
    </script>
</body>
</html>