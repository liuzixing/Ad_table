<link rel="stylesheet" href="../css/sprites.css" type="text/css" />
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">

    <a class="navbar-brand" href="javascript: void(0)">
      <img style=""
             src="../img/reeperf_rvb.png"></a>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-pills">
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Dashboard") echo 'class="active"'; ?>
          >
          <a href="../Dashboard" style="line-height:30px">
            <div>
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Dashboard") echo 'class="sprite sprite-home-active"'; else echo 'class="sprite sprite-home"' ?>
              />
              <div >Dashboard</div>
              <!-- style="font-size:14px;font-family:OpenSans-Semibold;" --> </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Campagne") echo 'class="active"'; ?>
          >
          <a href="../Campagne" style="line-height:30px">
            <div sytle="text-align: center ;">
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Campagne") echo 'class="sprite sprite-campagne-active"'; else echo 'class="sprite sprite-campagne"' ?>
              />
              <div  >Campagne</div>
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
              <div >Performance</div>
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
              <div >Concurrence</div>
            </div>
          </a>
        </li>
        <li <?php if (basename($_SERVER["REQUEST_URI"]) == "Administration") echo 'class="active"'; ?>
          >
          <a href="../Administration"   style="line-height:30px">
            <div sytle="text-align: center ;">
              <div style="line-height:10px;height:10px"></div>
              <img src="../img/blank.png" style="display: block;margin-left: auto;margin-right: auto;" <?php if (basename($_SERVER["REQUEST_URI"]) == "Administration") echo 'class="sprite sprite-param-active"'; else echo 'class="sprite sprite-param"' ?>
              />
              <div  >Administration</div>
            </div>
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li style="width:80px">
        <span >
          <a href="javascript: void(0)" style="font-size:14px;font-family:OpenSans-Regular;color:#2DFF70;">FR</a>
          /
          <a href="javascript: void(0)" style="font-size:14px;font-family:OpenSans-Regular;">EN</a>
        </span>
      </li>
      -->
      <li>
        <img src="../img/logo-my-media.jpg" class="agenceCircle"></li>
      <!-- <li class="username-wrapper" style="line-height:105px;">
      <p id="username" ></p>
    </li>
    -->
    <li style="line-height:115px">
      <li class="dropdown" style="margin-right:30px;margin-left:30px">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 0px;">
          <span id="username"></span>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu" sytle="background-color:#28B1E5" >
          <li style="height:20px;">
            <a href=".." style="height:20px;line-height:20px" onclick="redicet()">Déconnexion</a>
          </li>
        </ul>
      </li>
    </li>
    <!-- <li id = "logout">
    <a  href = "../login/index.html" style="line-height:75px;font-size:17px;font-family:"Open Sans";font-weight: 500;" onclick="redicet()">Déconnexion</a>
  </li>
  -->
</ul>
</div>
<!--/.nav-collapse -->
</div>
<!--/.container-fluid -->
</div>
<div class="speratebar"></div>
<script>
$("#username").html(getCookie("mymedia_username"));
  function redicet(){
    setCookie("mymedia_username", "", 0);
    setCookie("mymedia_token","", 0);
  }
</script>