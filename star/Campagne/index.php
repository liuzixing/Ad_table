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
    <!--   <link href="../external_library/bootstrap/css/bootstrap-custom.css" rel="stylesheet">--></head>
<body id='Campagne'>
    <div class="container-fluid">
        <!-- Static navbar -->
        <?php include '../header.php';?>

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
            <div id='clientlogo' >
                    <div style="width:100%;height:50px;font-size:12px"><img src="../img/ajax-loader2.gif"  class="img-circle"/>www.mymedia.com</div>
                    <div>
                    </div>
                </div>
                <div id='options' >
                    <div style="width:100%;height:30px;font-size:16px"><img src="../img/ajax-loader3.gif"  class="img-circle"/>CHOIS DES DONNÉES</div>
                    <div>
                        <div style="margin-top: 10px;">
                            <div id='datepicker1' style="float:left;margin-left:5%;"></div>
                        </div>
                        <div id='valueselector1' style="margin-top: 45px;margin-left:5%;"></div>
                        <div id='valueselector2' style="margin-top: 10px;margin-left:5%;"></div>
                        <div id='valueselector3' style="margin-top: 10px;margin-left:5%;margin-bottom:10px;"></div>

                    </div>
                </div>
                <div id='filters' style="">
                    <div style="width:100%;height:30px;font-size:16px"><img src="../img/ajax-loader3.gif"  class="img-circle"/>FILTRES</div>
                    <div>
                        <div id='Chaîne' style="margin-top: 10px;margin-left:5%;"></div>
                        <div id='Version' style="margin-top: 10px;margin-left:5%;"></div>
                        <div id='Format' style="margin-top: 10px;margin-left:5%;margin-bottom: 10px;"></div>

                    </div>
                </div>
                <div id='validation' style="">
                    <div style="width:100%;height:30px;font-size:16px"><img src="../img/ajax-loader3.gif"  class="img-circle"/>VALIDATION</div>
                    <div >
                        <button class="button" style ="margin-left:5%;margin-bottom:10px;width:90%;">Valider</button>
                    </div>
                </div>
            </div>
            <div>
                <div id="splitter">
                    <div>
                        <div>
                            <button class="button">Ajouter un commentaire</button>
                            <div id="chart" sytle="height:100%"></div>
                        </div>
                        <!-- <div style="width:100%;height:90%">

                        </div> -->
                    </div>

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

            $.getScript("../js/CampagneController.js", function() {
                        CampagneController();
                });
        });
    </script>
</body>
</html>