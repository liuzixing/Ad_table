<!DOCTYPE html>
<html lang="FR">
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

    <link rel="stylesheet" href="../external_library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <!-- <link href="../external_library/bootstrap/css/bootstrap-custom.css" rel="stylesheet">--></head>
<body id='Performance'>
    <?php include '../header.php';?>
    <div class="container-fluid">
        <!-- Static navbar -->

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
                <div id='clientlogo' >
                    <div>
                        <img src="../img/iron.jpg" class="clientCircle">
                        <span class="client-website" >www.mymedia.com</span>
                    </div>
                    <div></div>
                </div>
                <div id='options'>
                    <div >
                        <span class="numberCircle" >1</span>
                        <span class="expander-header">Choix des données</span>
                    </div>
                    <div>
                        <div class="periode-text">Période</div>
                        <div id='datepicker1' class="datepicker"></div>
                        <!-- not refactor yet -->
                        <div  style="margin-top: 18px;margin-left:5%;">
                            <div class="Comparaison-label" style="height:34px;vertical-align: middle;display:table-cell;text-align: center;line-height: 22px;float:left;weight:35%;font-size:12px;font-family: OpenSans-Light;">Comparaison</div>
                            <div style="margin-left:100px">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="Comparaison" unchecked>
                                    <label class="onoffswitch-label" for="Comparaison">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="Comparaison-setter" style="margin-top: 10px;margin-left:5%;">
                        <div class="Comparaison-label" style="float:left;weight:35%;vertical-align:middle;font-size:17px ;height:25px;line-height:25px; text-align:center">Comparaison</div>
                        <div id="Comparaison" style="float:right;margin-right:5%;"></div>
                    </div>
                    -->
                    <div style="margin-top: 28px;">
                        <div id='datepicker2' style=";margin-left:5%;"></div>
                    </div>
                    <!-- end -->

                    <div id='xaxisselector' class = "sidebar-dropdownlist"></div>
                    <div id='yaxisselector' class = "sidebar-dropdownlist"></div>
                    <div id='regroupement' class = "sidebar-dropdownlist bottom-sidebar-dropdownlist"></div>
                </div>
            </div>
            <div id='filters' >
                <div>
                    <span class="numberCircle" >2</span>
                    <span class="expander-header">Filtres</span>
                </div>
                <div>
                    <div id='Chaîne' class = "sidebar-dropdownlist"></div>
                    <div id='Version' class = "sidebar-dropdownlist"></div>
                    <div id='Format' class = "sidebar-dropdownlist"></div>
                    <div id='Catégorie' class = "sidebar-dropdownlist"></div>
                    <div id='MMDaypart' class = "sidebar-dropdownlist"></div>
                    <div id='Dayofweek' class = "sidebar-dropdownlist  bottom-sidebar-dropdownlist"></div>

                    <div  style="margin-top: 18px;margin-bottom:18px;margin-left:5%;">
                        <div class="Optimisation-label" style="height:34px;vertical-align: middle;display:table-cell;text-align: center;line-height: 22px;float:left;weight:35%;font-size:12px;font-family: OpenSans-Light;">Optimisation</div>
                        <div style="margin-left:100px">
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="Optimisation" checked>
                                <label class="onoffswitch-label" for="Optimisation">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div id='validation'>
                <div>
                    <span class="numberCircle" >3</span>
                    <span class="expander-header">Validation</span>
                </div>
                <div>
                    <button class="button sidebar-button"  id="Valider">
                        <img src="../img/blank.png" class="sprite  sprite-check_btn button-sprite" />
                        Valider
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div id="splitter">
            <div>
            <img src="../img/blank.png" id="previous" class="sprite  sprite-previous">
            <div  id="chart" style="width:100%;height:95%"></div></div>
                <div >
                    <div>
                        <button class="button exporter-button" class="exporter-button" id = "csvExport">
                            <img src="../img/blank.png" class="sprite  sprite-exporter button-sprite"  />
                            Exporter
                        </button>
                    </div>
                    <div class="table-container">
                        <div id="treeGrid" ></div>
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
            $.getScript("../js/PerformanceController.js", function() {
                        PerformanceController();
                });
        });
    </script>
</body>
</html>