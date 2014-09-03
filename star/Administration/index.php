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
    <title id='Description'>Administration</title>
        <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
    <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
    <script type="text/javascript" src="../js/LoginChecker.js"></script>
    <script>LoginChecker();</script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../external_library/bootstrap/css/bootstrap.min.css" rel="stylesheet"></head>
<body id='Administration'>
    <?php include '../header.php';?>
    <div class="container-fluid">
        <!-- Static navbar -->

        <!-- Main component for a primary marketing message or call to action -->
        <div id="splitContainer">
            <div>
                <div id='clientlogo' >
                    <div >
                        <img src="../img/iron.jpg" class="clientCircle">
                        <span class="client-website" >www.mymedia.com</span>
                    </div>
                    <div></div>
                </div>
                <div id='Admin' >
                        <div >
                            <span class="numberCircle" >1</span>
                            <span class="expander-header">adm</span>
                        </div>
                        <div class = "sidebar-dropdownlist" id='valueselector1' ></div>
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
                    <div>
                        <div id="chart" class="chart-container"></div>
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