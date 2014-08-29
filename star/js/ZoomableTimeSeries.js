function ZoomableTimeSeries() {
    var self = this;
    var chart;
    var seriesOptions = [];
    this.createLoadingMessage = function() {
        $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
    }
    this.destroyLoadingMessage = function() {
        $("#chart").empty();
    }
    // create the chart when all data is loaded
    this.createChart = function() {
        self.destroyLoadingMessage();
        self.chart = new Highcharts.StockChart({
            chart: {
                type: 'spline',
                renderTo: 'chart',
                defaultSeriesType: 'spline',
                zoomType: 'xy',
                //load update function here
                events: {
                    //load: _self.requestRealTimeData
                }
            },
            rangeSelector: {
                inputEnabled: false,

            },
            yAxis: {

            },
            plotOptions: {
                spline: {
                    lineWidth: 2
                }
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000,
                y: -50,
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                valueDecimals: 2
            },
            series: self.seriesOptions
        });
        console.log(self.chart);
    };
    this.updateChart = function(graphData, client_url) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: graphData,
            url: client_url,
            async: true,
            success: function(d) {
                console.log("update chart");
                 console.log(d);
                 console.log( self.chart);
                 self.seriesOptions = d;
                 self.createChart();
            },
            cache: false
        });
    }
    this.initialChart = function(client_url) {
        self.createLoadingMessage();
        $.ajax({
            type: 'GET',
            timeout: 10000,
            dataType: 'json',
            url: client_url,
            async: true,
            success: function(d) {
                console.log(d);
                self.seriesOptions = d;
                self.createChart();
            },
            failure: function(err) {
                console.log("Error");
            },
            cache: true
        });
    }
}