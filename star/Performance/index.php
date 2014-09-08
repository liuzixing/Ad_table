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
    <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
    <script type="text/javascript" src="../js/LoginChecker.js"></script>
    <script>LoginChecker();</script>

    <!-- Custom styles for this template -->
</head>
<body id='Performance'>
    <?php include '../header.php';?>
    <div class="container-fluid">
        <!-- Static navbar -->

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
                <div id='clientlogo' >
                    <img class="clientCircle">
                    <span class="client-website" ></span>
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
                        <div  class="onoffswitch-outside-wrapper">
                            <div class="onoffswitch-text" >Comparaison</div>
                            <div class="onoffswitch-inside-wrapper">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="Comparaison" unchecked>
                                    <label class="onoffswitch-label" for="Comparaison">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="second-datepicker-wrapper">
                            <div id='datepicker2' class="datepicker"></div>
                        </div>
                        <div class="chooser-text">Choix des données à afficher</div>
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

                        <div  class="onoffswitch-outside-wrapper">
                            <div class="onoffswitch-text">Optimisation</div>
                            <div class="onoffswitch-inside-wrapper">
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
                        <div  id="chart" class="chart-container-performance"></div>
                    </div>
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
    <?php include '../library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
                PerformanceController();
        });
    </script>
</body>
</html>