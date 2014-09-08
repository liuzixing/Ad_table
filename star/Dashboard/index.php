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
  <!--  <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">
  -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">


  <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>
  <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
  <script type="text/javascript" src="../js/LoginChecker.js"></script>
  <script>LoginChecker();</script>

  <!-- <link rel="stylesheet" href="../colourConf.css" type="text/css" />
  -->
  <!-- Custom styles for this template -->
  <!--  <link href="../external_library/bootstrap/css/bootstrap-custom.css" rel="stylesheet">--></head>
<body id='Dashboard'>
  <?php include '../header.php';?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 dashboardselector">
        <img class="clientCircle">
        <div id='clientselector' ></div>
      </div>
    </div>
    <!-- Static navbar -->

    <!-- Main component for a primary marketing message or call to action -->
    <div id='chart' style="width: 100%; height: 500px"></div>

    <div class="row dashboardsubtitle" id="last_day_title">
      <div class="col-md-6">
        Dernier jour :
        <span id ="LASTDAY_date">null</span>
      </div>
    </div>
    <div class="row" id="last_day_table">
      <div class="col-sm-2 link_to_Campagne_with_Contact_oneday">
      <span class="custom-tooltip">Budget Net</span>
        <div class="tile blue">
          <p >
            <span id="LASTDAY_budgetBrut" class="title"></span><span class="title">€</span>
          </p>
          <p>
            <span id="LASTDAY_events" class="title">0</span>
            Evènement(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_Contact_oneday ">
        <div class="tile blue">
          <p >
            <span id="LASTDAY_nb_spot" class="title"
></span>
            Spot(s)
          </p>
          <p >
            <span id="LASTDAY_nb_channel" class="title"
></span>
            Chaine(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_oneday">
        <div class="tile blue">
          <h3 class="title">
            <span id="LASTDAY_CPVI"></span>€ CPVi
          </h3>
          <p>à 5mn</p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_CPVc_oneday">
      <span class="custom-tooltip">Moyenne journée</span>
        <div class="tile blue">
        <p>
          <span class="title" id="LASTDAY_CPVc"></span><span class="title">€ CPVc</span>
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_Contact_oneday">
      <span class="custom-tooltip">Total Campagne</span>
        <div class="tile blue">
          <p >
            <span id="LASTDAY_vues" class="title"></span>
            Vue(s)
          </p>
          <p >
            <span id="LASTDAY_Vc" class="title"></span>
            Visites gagnée(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Concurrence_oneday">
      <span class="custom-tooltip">Concurrence</span>
        <div class="tile blue">
          <p >
            <span id="Lastday_nbconcurrent" class="title"></span>
            Concurrent(s)
          </p>
          <p >
            <span id="Lastday_nbspot" class="title"></span>
            Spot(s)
          </p>
        </div>
      </div>
    </div>
    <!-- end row -->

    <div class="row dashboardsubtitle">
      <div class="col-sm-8">
        Campagne
        <span id ="CAMPAGNE_progress"></span>
        : du
        <span id="CAMPAGNE_date_start"></span>
        au
        <span id="CAMPAGNE_date_end"></span>
      </div>
      <div class="pull-right">
        <div class='ProgressBar' id='jqxProgressBar'></div>
     </div>
    </div>

    <div class="row">
      <div class="col-sm-2 link_to_Campagne_with_Contact">
        <span class="custom-tooltip">Budget Net</span>
        <div class="tile blue">
          <p >
            <span id="CAMPAGNE_C_budgetNet" class="title"></span><span class="title">€</span>
          </p>
          <p>
            <span id="CAMPAGNE_percent_CbudgetBrut"  class="title"></span>
            consommé
          </p>
          <p>
            <span id="CAMPAGNE_event" class="title">0</span>
            Evènement(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_Contact">
        <div class="tile blue">
          <p >
            <span id="CAMPAGNE_total_spot" class="title"></span>
            Spot(s)
          </p>
          <p >
            <span id="CAMPAGNE_total_channel" class="title"></span>
            Chaine(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="CAMPAGNE_CPVI" ></span>€ CPVi
          </h3>
          <p>à 5mn</p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_CPVc">
      <span class="custom-tooltip">Moyenne Campagne</span>
        <div class="tile blue">
          <p>
          <span id="CAMPAGNE_CPVc" class="title" ></span><span class="title">€ CPVc</span>
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne_with_Contact">
      <span class="custom-tooltip">Total Campagne</span>
        <div class="tile blue">
          <p >
            <span id="CAMPAGNE_total_vues" class="title"></span>
            Vue(s)
          </p>
          <p>
            <span id="CAMPAGNE_Vc"  class="title"></span>
            Visites gagnée(s)
          </p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Concurrence">
      <span class="custom-tooltip">Concurrence</span>
        <div class="tile blue">
          <p >
            <span id="campagne_nbconcurrent" class="title"></span>
            Concurrent(s)
          </p>
          <p >
            <span id="campagne_nbspot" class="title"></span>
            Spot(s)
          </p>
        </div>
      </div>
    </div>
    <!-- end row -->
    <div class="row">
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>
        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>
        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>

        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>
        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>
        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Performance">
      <span class="custom-tooltip">Moyenne Campagne</span>

        <div class="tile darkblue">
          <div class="title">
            <div class="channelCircle">
              <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
          </div>
          <p class="money"></p>
        </div>
      </div>
    </div>
    <!-- end row -->
    <!--  <div id='chartContainer' style="width:800px; height:500px;"></div>
  -->
</div>
<!-- end container -->

<!-- /container -->
<!-- /print the libraries -->

<?php include '../library.php';?>
<script type="text/javascript">
        $(document).ready(function () {
            LoginChecker();
            DashboardController();
        });
    </script>
</body>
</html>