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
    <title id='Description'>Administration</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
    <script type="text/javascript" src="../js/LoginChecker.js"></script>
    <script>LoginChecker();</script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../external_library/bootstrap/css/bootstrap.min.css" rel="stylesheet"></head>
<body id='Administration'>
    <?php include '../header.php';?>
    <div class="container-fluid">

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
                <div id='clientlogo' >
                    <div >
                        <img src="../img/iron.jpg" class="clientCircle">
                        <span class="client-website" ></span>
                    </div>
                    <div></div>
                </div>
                <div id='options' >
                    <div >
                        <span class="numberCircle" >1</span>
                        <span class="expander-header">Administration</span>
                    </div>
                    <div>
                        <div class="chooser-text">Choix de l'option</div>
                        <div class = "sidebar-dropdownlist bottom-sidebar-dropdownlist" id='valueselector1' ></div>
                    </div>
                </div>
                <div id='validation' >
                    <div>
                        <span class="numberCircle" >2</span>
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
                    <!-- top area -->
                    <div>
                        <div style="margin: 20px auto;width: 100%;text-align: center;">
                        <a href="createCampagneCSV.php" class="modalCSV">Modèle CSV à respecter pour l'import <span id="pageText">Campagne</span></a>
                        </div>
                        <div style = "width: 100%;text-align: center;">
                            <form method="POST" id="upload" action="setupStepBridge.php" enctype="multipart/form-data">
                                <input type="hidden" style="margin:0 auto;" name="MAX_FILE_SIZE" value="10000000000">
                                <input type="file" name="plan_campagne" style="margin:0 auto;" class="button">
                                <br/>
                                <br/>
                                <input class="button" type="submit" onclick='document.getElementById("upload").submit()' name="upload" value="Charger le fichier"></form>
                        </div>
                    </div>
                    <!-- bottom area -->
                    <div>
                        <div class="table-container" >
                            <div id="table"></div>
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

            $.getScript("../js/AdministrationController.js", function() {
                        AdministrationController();
                });

        });
    </script>
</body>
</html>