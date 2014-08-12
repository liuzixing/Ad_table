<style type="text/css">
.navbar-default {
  background-color: #f0f0f0;
  border-color: #28b1e5;
}
.navbar-default .navbar-brand {
  color: #4e6479;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
  color: #ffffff;
}
.navbar-default .navbar-text {
  color: #4e6479;
}
.navbar-default .navbar-nav > li > a {
  color: #4e6479;
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
  background-color: #4e6479;
}
.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
  border-color: #4e6479;
}
.navbar-default .navbar-link {
  color: #4e6479;
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
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">

    <a class="navbar-brand" href="javascript: void(0)">
      <img style=""
             src="../img/leadsmonitor-logo.png">
    </a>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-pills">
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Dashboard") echo 'class="active"'; ?> >
          <a href="../Dashboard" >
          <span class="glyphicon glyphicon-home" sytle="font-size: 60px"></span>Dashboard
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Campagne") echo 'class="active"'; ?> >
          <a href="../Campagne">Campagne</a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Performance") echo 'class="active"'; ?> >
          <a href="../Performance">Performance</a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Concurrence") echo 'class="active"'; ?> >
          <a href="../Concurrence">Concurrence</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li style="width:80px">
          <span >
          <a href="javascript: void(0)"><img src="../img/blank.png" class="flag flag-fr" />
            </a>/
            <a href="javascript: void(0)"><img src="../img/blank.png" class="flag flag-gb" />
          </a>
          </span>
        </li>

        <li>
          <img src="../img/ajax-loader2.gif"  class="img-circle">
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">User name <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Settings</a></li>
                        </ul>
          </li>
      </ul>
    </div>
    <!--/.nav-collapse --> </div>
  <!--/.container-fluid -->
</div>