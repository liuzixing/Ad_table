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
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">
</head>
<body id='Dashboard'>
    <div class="container">
      <!-- Static navbar -->
      <?php include '../header.php';?>

      <!-- Main component for a primary marketing message or call to action -->
      <div id='chart' style="width: 1000; height: 400px">
        </div>
      <div id="datatable" style="margin-top:10px">
      </div>
    </div> <!-- /container -->
    <!-- /print the libraries -->
    <?php include '../library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.getScript("../js/DashboardController.js", function() {
                        DashboardController();
                });
        });
    </script>
</body>
</html>