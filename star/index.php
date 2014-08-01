<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<head>
    <link rel="icon" href="leadsmonitor.png">
    <title id='Description'>Leadsmonitor</title>
    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">
</head>
<body id='Campagne'>
    <div class="container">
      <!-- Static navbar -->
      <?php include 'header.php';?>

      <!-- Main component for a primary marketing message or call to action -->
  <div id="splitContainer">
        <div>
            <div class="jqx-hideborder jqx-hidescrollbars" id="settingArea">
                <ul>
                    <li style="margin-left: 30px;">Options</li>
                    <li>Filters</li>
                </ul>
                <div>
                    <div style="margin-top: 10px;">
                        <div id='datepicker1' style="float:left"></div>
                        <div id='datepicker2' style="float:right"></div>
                    </div>
                    <div id='dropdownlist2' style="margin-top: 10px;"></div>
                    <div id='dropdownlist3' style="margin-top: 10px;"></div>
                    <div id='dropdownlist4' style="margin-top: 10px;"></div>
                    <div style="margin-top: 10px;">
                            <input  type="button" id="btn_default" value="default" />
                            <input style="float:right" type="button" id="btn_validez" value="validez" />
                    </div>

                </div>
                <div>
                <!--  filter components-->
                    <div id='Chaîne' style="margin-top: 10px;"></div>
                    <div id='Version' style="margin-top: 10px;"></div>
                    <div id='Format' style="margin-top: 10px;"></div>
                    <div class="Optimisation-setter" style="margin-top: 10px;">
                            <div class="Optimisation-label" style="float:left;weight:40%;font-size:20px">Optimisation</div>
                            <div id="Optimisation" style="float:right"></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div id="splitter">
                <div>
                    <div class="jqx-hideborder jqx-hidescrollbars" id="graphArea">
                        <ul>
                            <li style="margin-left: 30px;">Graph</li>
                            <li></li>
                        </ul>
                        <div  id="chart" >
                        </div>
                        <div></div>
                    </div>
                </div>
                <div>
                    <div class="jqx-hideborder jqx-hidescrollbars" id="tableArea">
                        <ul>
                            <li style="margin-left: 30px;">Table</li>
                            <li></li>
                        </ul>
                        <div id="jqxgrid" >
                            <!-- <div id="jqxgrid"></div> -->
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- /container -->
    <!-- /print the libraries -->
    <?php include 'library.php';?>
    <script type="text/javascript">
        $(document).ready(function () {
            var globaltheme = 'bootstrap';
            $('#splitContainer').jqxSplitter({ height: 800, theme: globaltheme,width: "100%", orientation: 'vertical', panels: [{ collapsible: false, size: '20%' }, { size: '80%' }] });
            $('#splitter').jqxSplitter({ width: '100%',theme: globaltheme, orientation: 'horizontal',  panels: [{ size: "50%" }] });
            $("#settingArea").jqxTabs({  theme: globaltheme,height: '100%', width: '100%' });
            $("#graphArea").jqxTabs({  theme: globaltheme,height: '100%', width: '100%' });
            $("#tableArea").jqxTabs({  theme: globaltheme,height: '100%', width: '100%' });
            var source = [
                    "Budget net",
                    "Total affichage sur Google",
                    "Coût par recherche",
                    "CTR",
                    "Nombre total de visites immédiates",
                    "Coût de la visite immédiate",
                    "Nombre total de visites du site",
                    "Nombre total de visite campagne ",
                    "Coût de la visite campagne",
                    "% de nouveaux visiteurs immédiats",
                    "Nombre total de leads immédiats",
                    "Coût au lead immédiat",
                    "Nombre total de ventes immédiates",
                    "CPA",
                    "CPO",
                    "KPI personnalisé client",
                    "Nombre total de ventes",
                ];
                // Create a jqxDropDownList
            var dropdownlistsetting = { theme: globaltheme,source: source, width: '98%', height: '25'};

                $("#datepicker1").jqxDateTimeInput({width: '45%', height: '25px'});
                $("#datepicker2").jqxDateTimeInput({width: '45%',rtl: true, height: '25px'});
                $("#dropdownlist2").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "1ère valeur à afficher",width: '98%', height: '25'});
                $("#dropdownlist3").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "2ème valeur à afficher",width: '98%', height: '25'});
                $("#dropdownlist4").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "3ème valeur à afficher",width: '98%', height: '25'});
                // $("#listbox").jqxListBox({theme: globaltheme,width: '98%', source: source, checkboxes: true, height: 250});
                 $("#Chaîne").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "Chaîne",checkboxes: true,width: '98%', height: '25'});
                $("#Version").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "Version pub / créa",checkboxes: true,width: '98%', height: '25'});
                $("#Format").jqxDropDownList({ theme: globaltheme,source: source, placeHolder: "Format",checkboxes: true,width: '98%', height: '25'});
                $('#Optimisation').jqxSwitchButton({ height: 25, width: '40%',  checked: false });

                $("#btn_default").jqxButton({ theme: globaltheme, width: "40%"});
                $("#btn_validez").jqxButton({ theme: globaltheme, width: "40%"});
                $.getScript("GridControllerClass.js", function() {
                        var grid = new GridController();
                        grid.initialGrid();
                });
                $.getScript("bubbleControllerClass.js", function() {
                        var bubble = new BubbleController();
                        bubble.createBubbleChart();
                });
        });
    </script>
</body>
</html>