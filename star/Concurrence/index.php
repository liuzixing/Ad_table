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
    <title id='Description'>Concurrence</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../external_library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
    <script type="text/javascript" src="../js/LoginChecker.js"></script>
    <script>LoginChecker();</script>
<body id='Concurrence'>
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
                <div id='options' >
                    <div >
                        <span class="numberCircle" >1</span>
                        <span class="expander-header">Données</span>
                    </div>
                    <div>
                        <div class="periode-text">Période</div>
                        <div id='datepicker1' class="datepicker"></div>
                        <div class="chooser-text">Choix des données à afficher</div>
                        <div id='concurrenceselector' class = "sidebar-dropdownlist  bottom-sidebar-dropdownlist"></div>

                    </div>
                </div>
                <div id='filters'>
                    <div>
                        <span class="numberCircle" >2</span>
                        <span class="expander-header">Filtres</span>
                    </div>
                    <div>
                        <div id='Chaîne' class = "sidebar-dropdownlist"></div>
                        <div id='MMDayPart' class = "sidebar-dropdownlist" ></div>
                        <div id='Format' class = "sidebar-dropdownlist bottom-sidebar-dropdownlist" ></div>

                    </div>
                </div>
                <div id='validation' >
                    <div>
                        <span class="numberCircle" >3</span>
                        <span class="expander-header">Validation</span>
                    </div>
                    <div>
                        <button class="button sidebar-button" id = "Valider">
                            <img src="../img/blank.png" class="sprite  sprite-check_btn button-sprite" />
                            Valider
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <div id="splitter">
                    <div  id="chart" ></div>
                    <div >
                        <div>
                            <button class="button exporter-button" id="csvExport">
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
 <br>
    <!-- /container -->
    <!-- /print the libraries -->
    <?php include '../library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
            ConcurrenceController();
        });
    </script>
</body>
</html>