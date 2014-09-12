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
    <title id='Description'>Campagne</title>
    <!-- Bootstrap core CSS -->
    <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>
    <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
    <script type="text/javascript" src="../js/LoginChecker.js"></script>
    <script>LoginChecker();</script>
    <link rel="stylesheet" href="../external_library/bootstrap/css/bootstrap.min.css" rel="stylesheet"></head>
<body id='Campagne'>
    <?php include '../header.php';?>
    <div class="container-fluid">
        <!-- Static navbar -->

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
                <div id='clientlogo' >
                        <img class="clientCircle">
                        <div class="client-website" ></div>
                </div>
                <div id='options' >
                    <div >
                        <span class="numberCircle" >1</span>
                        <span class="expander-header">Choix des données</span>
                    </div>
                    <div>
                        <div class="periode-text">Période</div>
                        <div id='datepicker1' class="datepicker"></div>
                        <div class="chooser-text">Choix des données à afficher</div>
                        <div class = "sidebar-dropdownlist" id='valueselector1' ></div>
                        <div class = "sidebar-dropdownlist" id='valueselector2' ></div>
                        <div class = "sidebar-dropdownlist bottom-sidebar-dropdownlist" id='valueselector3' ></div>
                    </div>
                </div>
                <div id='filters' >
                    <div>
                        <span class="numberCircle" >2</span>
                        <span class="expander-header">Filtres</span>
                    </div>
                    <div>
                        <div id='Chaîne' class = "sidebar-dropdownlist" ></div>
                        <div id='Version' class = "sidebar-dropdownlist" ></div>
                        <div id='Format' class = "sidebar-dropdownlist bottom-sidebar-dropdownlist" ></div>
                    </div>
                </div>
                <div id='validation' >
                    <div>
                        <span class="numberCircle" >3</span>
                        <span class="expander-header">Validation</span>
                    </div>
                    <div>
                        <button class="button sidebar-button" id="Valider">
                            <img src="../img/blank.png" class="sprite  sprite-check_btn button-sprite" />
                            Valider
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <div id="splitter">
                    <div>
                        <button class="button ajouter-button" id="addcomment" >
                            <img src="../img/blank.png" class="sprite  sprite-plus_btn button-sprite"  />
                            Ajouter un évènement
                        </button>
                        <div id='jqxwindow'>
                            <div>  Ajouter un commentaire</div>
                            <div>
                                <div id='commentdatepicker' ></div>
                                <div class="comment-input-wrapper"><textarea  maxlength="200" id="commentinput" class="fitwrapper"/></textarea></div>
                                <button class="button comment-ok-button " id="commitcomment" >Valider</button><button class="button comment-cancle-button" id="canclecomment" >Annuler</button>
                            </div>
                        </div>
                        <div id="chart" class="chart-container"></div>
                    </div>
                    <div >
                        <div>
                            <button id="csvExport" class="button exporter-button" class="exporter-button">
                                <img src="../img/blank.png" class="sprite  sprite-exporter button-sprite"  />
                                Exporter
                            </button>
                        </div>
                        <div class="table-container" >
                            <div id="treeGrid"></div>
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
            //LoginChecker();
            CampagneController();
        });
    </script>
</body>
</html>