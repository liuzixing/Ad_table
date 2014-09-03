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
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../external_library/jqwidgets/styles/jqx.office.css" type="text/css" />
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
      <div class="dashboardselector">
        <img src="../img/iron.jpg" class="clientCircle">
        <div id='clientselector' ></div>
      </div>
    </div>
    <!-- Static navbar -->

    <!-- Main component for a primary marketing message or call to action -->
    <div id='chart' style="width: 100%; height: 500px"></div>

    <div class="row dashboardsubtitle" id="last_day_title">
      <div class="col-md-2">
        Dernier jour :
        <span id ="LASTDAY_date">null</span>
      </div>
    </div>
    <div class="row" id="last_day_table">
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="LASTDAY_budgetBrut"></span>
            €
          </h3>
          <p >Budget net</p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="LASTDAY_nb_spot"></span>
            Spots
          </h3>
          <h3 class="title">
            <span id="LASTDAY_nb_channel"></span>
            Chaines
          </h3>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="LASTDAY_CPVI"></span>
            € CPVI
          </h3>
          <p>à 5mn Moy. Campagne</p>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="tile blue">
          <h3 class="title">No data display yet</h3>
          <p></p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="LASTDAY_vues"></span>
            Vues
          </h3>
          <h3 class="title">
            <span id="LASTDAY_vi_won"></span>
          </h3>
          <p>Visites gagnées</p>
          <p>Total campagne</p>
        </div>
      </div>
      <div class="col-sm-2 link_to_Concurrence">
        <div class="tile blue">
          <h3 class="title">Concurrence</h3>
          <h3 class="title">
            <span id="Lastday_nbconcurrent"></span>
            Concurrents
          </h3>
          <h3 class="title">
            <span id="Lastday_nbspot"></span>
            Spots
          </h3>
        </div>
      </div>
    </div>
    <!-- end row -->

    <div class="row dashboardsubtitle">
      <div class="col-sm-6">
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
      <div class="col-sm-2 link_to_Campagne">
        <div class="tile blue">
          <h3 class="title">
            <span id="CAMPAGNE_total_budgetBrut"></span>
            €
          </h3>
          <p id="CAMPAGNE_percent_CbudgetBrut"></p>
          <!-- <p id="CAMPAGNE_event">X événements</p>
        -->
      </div>
    </div>
    <div class="col-sm-2 link_to_Campagne">
      <div class="tile blue">
        <h3 class="title">
          <span id="CAMPAGNE_total_spot"></span>
          Spots
        </h3>
        <h3 class="title">
          <span id="CAMPAGNE_total_channel"></span>
          Chaines
        </h3>
      </div>
    </div>
    <div class="col-sm-2 link_to_Campagne">
      <div class="tile blue">
        <h3 class="title">
          <span id="CAMPAGNE_CPVI"></span>
          € CPVI
        </h3>
        <p>à 5mn Moy. Campagne</p>
      </div>
    </div>
    <div class="col-sm-2 ">
      <div class="tile blue">
        <h3 class="title">No data display yet</h3>
        <p></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Campagne">
      <div class="tile blue">
        <h3 class="title">
          <span id="CAMPAGNE_total_vues"></span>
          Vues
        </h3>
        <h3 class="title">
          <span id="CAMPAGNE_total_vi_won"></span>
        </h3>
        <p>Visites gagnées</p>
        <p>Total campagne</p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Concurrence">
      <div class="tile blue">
        <h3 class="title">Concurrence</h3>
        <h3 class="title">
          <span id="campagne_nbconcurrent"></span>
          Concurrents
        </h3>
        <h3 class="title">
          <span id="campagne_nbspot"></span>
          Spots
        </h3>
      </div>
    </div>
  </div>
  <!-- end row -->
  <div class="row">
    <div class="col-sm-2 link_to_Performance">
      <div class="tile darkblue">
        <div class="title">
          <div class="channelCircle">
            <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
        </div>
        <p class="money"></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Performance">
      <div class="tile darkblue">
        <div class="title">
          <div class="channelCircle">
            <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
        </div>
        <p class="money"></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Performance">
      <div class="tile darkblue">
        <div class="title">
          <div class="channelCircle">
            <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
        </div>
        <p class="money"></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Performance">
      <div class="tile darkblue">
        <div class="title">
          <div class="channelCircle">
            <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
        </div>
        <p class="money"></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Performance">
      <div class="tile darkblue">
        <div class="title">
          <div class="channelCircle">
            <img src="../img/ajax-loader.gif" class="innerchannelCircle"></div>
        </div>
        <p class="money"></p>
      </div>
    </div>
    <div class="col-sm-2 link_to_Performance">
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
 <!--  <div id='chartContainer' style="width:800px; height:500px;">
        </div> -->
</div>
<!-- end container -->

<!-- /container -->
<!-- /print the libraries -->

<?php include '../library.php';?>
<script type="text/javascript">
        $(document).ready(function () {
            LoginChecker();
            DashboardController();
            realtimegraph = new RealTimeController();
            realtimegraph.InitialGraph();
        });
    </script>
</body>
</html>