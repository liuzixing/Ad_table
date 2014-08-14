<link rel="stylesheet" href="../css/sprites.css" type="text/css" />
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">

    <a class="navbar-brand" href="javascript: void(0)">
      <img style=""
             src="../img/leadsmonitor-logo.png"></a>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-pills">
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Dashboard") echo 'class="active"'; ?>
          >
          <a href="../Dashboard" style="line-height:30px">
            <div>
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Dashboard") echo 'class="sprite sprite-home-active"'; else echo 'class="sprite sprite-home"' ?>
              />
              <div style="font-size:14px;font-family:OpenSans-Semibold;">Dashboard</div>
            </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Campagne") echo 'class="active"'; ?>
          >
          <a href="../Campagne" style="line-height:30px">
            <div sytle="text-align: center ;">
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Campagne") echo 'class="sprite sprite-campagne-active"'; else echo 'class="sprite sprite-campagne"' ?>
              />
              <div  style="font-size:14px;font-family:OpenSans-Semibold;">Campagne</div>
            </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Performance") echo 'class="active"'; ?>
          >
          <a href="../Performance" style="line-height:30px">
            <div sytle="text-align: center ;">
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Performance") echo 'class="sprite sprite-performance-active"'; else echo 'class="sprite sprite-performance"' ?>
              />
              <div  style="font-size:14px;font-family:OpenSans-Semibold;">Performance</div>
            </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Concurrence") echo 'class="active"'; ?>
          >
          <a href="../Concurrence"  style="line-height:30px">
            <div sytle="text-align: center ;">
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Concurrence") echo 'class="sprite sprite-concurrents-active"'; else echo 'class="sprite sprite-concurrents"' ?>
              />
              <div  style="font-size:14px;font-family:OpenSans-Semibold;">Concurrence</div>
            </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Administration") echo 'class="active"'; ?>
          >
          <a href=""   style="line-height:30px">
            <div sytle="text-align: center ;">
            <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Administration") echo 'class="sprite sprite-param-active"'; else echo 'class="sprite sprite-param"' ?>
              />
              <div  style="font-size:14px;font-family:OpenSans-Semibold;">Administration</div>
            </div>
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li style="width:80px">
          <span >
            <a href="javascript: void(0)" style="font-size:14px;font-family:OpenSans-Regular;color:#2DFF70;">FR
              <!-- <img src="../img/blank.png" class="flag flag-fr" /> -->
            </a>
            /
            <a href="javascript: void(0)" style="font-size:14px;font-family:OpenSans-Regular;">
            EN
              <!-- <img src="../img/blank.png" class="flag flag-gb" /> -->
            </a>
          </span>
        </li>
        <li>
          <img src="../img/adopting-a-cat.jpg" class="agenceCircle">
          <!-- <span class="agenceCircle" style="margin-top:20px">A</span> -->
        </li>
        <li style="width:180px;" class="dropdown" >
          <a href="#" style="line-height:75px" data-toggle="dropdown" class="dropdown-toggle">Nomdelagence <b class="caret"></b>
          </a>
          <ul class="dropdown-menu" style="line-height:20px">
            <li>
              <a href="#">Action</a>
            </li>
            <li>
              <a href="#">Another action</a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="#">Settings</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!--/.nav-collapse --> </div>
  <!--/.container-fluid -->
</div>
<div style="background-color: #305277;height:6px;"></div>
<style type="text/css">
.navbar-default {
  background-color: #f0f0f0;
  border-color: #28b1e5;
}
.navbar-default .navbar-brand {
  color: #23466E;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
  color: #ffffff;
}
.navbar-default .navbar-text {
  color: #23466E;
}
.navbar-default .navbar-nav > li > a {
  color: #23466E;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
  color: #ffffff;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
  color: #ffffff;
  background-color: #28b1e5;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
  color: #ffffff;
  background-color: #28b1e5;
}
.navbar-default .navbar-toggle {
  border-color: #28b1e5;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
  background-color: #28b1e5;
}
.navbar-default .navbar-toggle .icon-bar {
  background-color: #23466E;
}
.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
  border-color: #23466E;
}
.navbar-default .navbar-link {
  color: #23466E;
}
.navbar-default .navbar-link:hover {
  color: #ffffff;
}

@media (max-width: 767px) {
  .navbar-default .navbar-nav .open .dropdown-menu > li > a {
    color: #4e6479;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
    color: #ffffff;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
    color: #ffffff;
    background-color: #28b1e5;
  }
}
  .navbar-nav, .navbar-nav li, .navbar-nav li a {
  height: 100px;
     line-height: 100px;

}
.navbar-brand {
        padding: 0;
}
.navbar {
    margin-bottom: 0 !important;
}
</style>