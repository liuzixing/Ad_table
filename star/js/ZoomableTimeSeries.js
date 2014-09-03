function ZoomableTimeSeries() {
    var self = this;
    var chart;
    var seriesOptions = [];
    var customtooltips;
    var additionalInformation;
    var customXaxis;
    this.createLoadingMessage = function() {
        $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
    }
    this.destroyLoadingMessage = function() {
        $("#chart").empty();
    }
    this.resetPointFormat = function() {
        self.customtooltips = {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>'
        };
    }
    this.resetXaxis = function() {
        self.customXaxis = {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 100,
            y: -50,
        };
    }
    this.hideZoomBar = function(){
            self.chart.rangeSelector.zoomText.hide();
            $.each(self.chart.rangeSelector.buttons, function() {
                this.hide();
            });
            $(self.chart.rangeSelector.divRelative).hide();
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
            },
            legend: {
                enabled: true,
            },
            rangeSelector: {
                inputEnabled: false,

            },
            yAxis: {},
            plotOptions: {
                spline: {
                    //set how many points maximun
                    turboThreshold: 100000,
                    lineWidth: 2
                }
            },
            xAxis: self.customXaxis,
            tooltip: self.customtooltips,
            series: self.seriesOptions
        });
        self.hideZoomBar();
        //console.log(self.chart);
    };
    //for concurrence
    this.updateChart = function(graphData, client_url) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            scriptCharset: "utf-8",
            data: graphData,
            url: client_url,
            async: true,
            success: function(d) {
                console.log("update chart");
                console.log(d);
                if (d.length == 2) {
                    self.seriesOptions = d[0];
                    self.additionalInformation = d[1];
                    self.customtooltips = {
                        formatter: function() {
                            //console.log(this);
                            var dateTime = new Date(this.x);
                            var htmlString = dateTime.toUTCString().replace('GMT', '') + '<br>';
                            for (key in self.additionalInformation[this.x]) {
                                htmlString = htmlString + "<b>" + key + " : " + self.additionalInformation[this.x][key] + '</b><br>';
                            }
                            return htmlString;
                        }
                    }
                } else {
                    self.seriesOptions = d;
                    self.resetPointFormat();
                }

                self.createChart();
            },
            cache: false
        });
    }
    this.updateCampagne = function(graphData, client_url) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            scriptCharset: "utf-8",
            data: graphData,
            url: client_url,
            async: true,
            success: function(d) {
                console.log("update chart");
                console.log(d);
                if (d.length == 2) {
                    self.seriesOptions = d[0];
                    self.seriesOptions[0]["dataGrouping"] = {
                        approximation: "sum",
                        enabled: true,
                    };
                    self.additionalInformation = d[1];
                    var spot = self.seriesOptions[1].data;
                    var plotband = [];
                    var plotevent = {
                        mouseover: function(e) {
                            //console.log(self.chart.series[1].points[this.id]);
                            self.chart.tooltip.refresh(self.chart.series[1].points[this.id]);
                        }
                    };
                    console.log("here");
                    for (var i = 0; i < spot.length; i++) {
                        // spot[i][0]
                        plotband.push({ // mark the weekend
                            color: '#FCFFC5',
                            id: i,
                            from: spot[i][0],
                            to: spot[i][0] + 5 * 60 * 1000,
                            events: plotevent
                        });
                    };
                    self.customXaxis = {
                        plotBands: plotband,
                        type: 'datetime'
                    };
                    self.customtooltips = {
                        formatter: function() {
                            //console.log(this);
                            var dateTime = new Date(this.x + 2 * 60 * 60 * 1000);
                            var htmlString = dateTime.toUTCString().replace('GMT', '') + '<br>';
                            //.points[0].series.name == "spot"
                            if (this.hasOwnProperty("series")) {
                                for (key in self.additionalInformation[this.x]) {
                                    htmlString = htmlString + '<span style="color:#2DCC70">' + key + " </span> : " + "<b>" + self.additionalInformation[this.x][key] + '</b><br>';
                                }
                            } else {
                                //console.log(this);
                                htmlString = htmlString + '<span style="color:' + this.points[0].series.color + '">' + this.points[0].series.name + '</span>: <b>' + this.y + '</b><br/>';
                            }

                            return htmlString;
                        }
                    }
                } else {
                    self.seriesOptions = d;
                    self.resetPointFormat();
                }

                self.createChart();
            },
            cache: false
        });
    }
    this.initialChart = function(client_url) {
        Highcharts.setOptions({
            global: {
                useUTC: false,
                timezoneOffset: 2 * 60
            }
        });
        self.createLoadingMessage();
        $.ajax({
            type: 'GET',
            timeout: 10000,
            dataType: 'json',
            scriptCharset: "utf-8",
            url: client_url,
            async: true,
            success: function(d) {
                console.log("data for initial chart");
                console.log(d);
                self.seriesOptions = d;
                self.resetPointFormat();
                self.resetXaxis();
                self.createChart();
            },
            failure: function(err) {
                console.log("Error");
            },
            cache: true
        });
    }
}