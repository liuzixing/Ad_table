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
 <!--  <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet"> -->
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../colourConf.css" type="text/css" />

  <!-- Custom styles for this template -->
 <!--  <link href="../external_library/bootstrap/css/bootstrap-custom.css" rel="stylesheet"> --></head>
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

<div class="row dashboardsubtitle">
    <div class="col-md-2">Dernier jour : 18/08/2014
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Purple, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Red, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">1 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
  </div>
  <div class="row dashboardsubtitle">
    <div class="col-md-4">Campagne en cours depuis le : 05/06/2014
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Green, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Blue, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile blue">
        <h3 class="title">2 Tile</h3>
        <p>Hello Orange, this is a colored tile.</p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <div class="tile darkblue">
      <div class="title"><div class="channelCircle"><img src="../img/channel-logos/M6.png" class="innerchannelCircle"></div></div>
        <p class="money">3,61€</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile darkblue">
        <div class="title"><div class="channelCircle"><img src="../img/channel-logos/France3.png" class="innerchannelCircle"></div></div>
        <p class="money">3,12€</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile darkblue">
        <div class="title"><div class="channelCircle"><img src="../img/channel-logos/NRJ12.png" class="innerchannelCircle"></div></div>
        <p class="money">1,78€</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile darkblue">
        <div class="title"><div class="channelCircle"><img src="../img/channel-logos/NT1.png" class="innerchannelCircle"></div></div>
        <p class="money">1,45€</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile darkblue">
        <div class="title"><div class="channelCircle"><img src="../img/channel-logos/LCI.png" class="innerchannelCircle"></div></div>
        <p class="money">2,10€</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="tile darkblue">
        <div class="title"><div class="channelCircle"><img src="../img/channel-logos/Gulli.png" class="innerchannelCircle"></div></div>
        <p class="money">1,45€</p>
      </div>
    </div>
  </div>
  <!-- end container -->
  </div>

  <!-- /container -->
  <!-- /print the libraries -->
  <?php include '../footer.php';?>
  <?php include '../library.php';?>
  <script type="text/javascript">
        $(document).ready(function () {
            $.getScript("../js/DashboardController.js", function() {
                        DashboardController();
                });
             realtimegraph = new RealTimeController();
            realtimegraph.InitialGraph();
        });
    </script>
</body>
</html>