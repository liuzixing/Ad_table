<html>
    <header>
        <title>This is title</title>
        <script type="text/javascript" src="../external_library/scripts/jquery-1.10.2.min.js"></script>

        <!-- <script src="http://code.highcharts.com/highcharts.js"></script> -->

        <script src="http://code.highcharts.com/stock/highstock.js"></script>
        <script src="http://code.highcharts.com/highcharts-more.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <script  type="text/javascript"src="../js/cookies_helper_function.js"></script>
        <script type="text/javascript" src="../js/LoginChecker.js"></script>
        <script type="text/javascript" src="../js/BubbleChart.js"></script>

    </header>
<body>
    <div id="chart"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            var chart = new BubbleChart();
             chart.initialChart("Justfab");
        });
    </script>
</body>
</html>