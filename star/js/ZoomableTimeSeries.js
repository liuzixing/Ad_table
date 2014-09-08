function ZoomableTimeSeries() {
    var self = this;
    var chart;
    var seriesOptions = [];
    var customtooltips;
    var additionalspotInformation;
    var additionaleventInformation;
    var customXaxis;
    this.updateEvent = function(datetime, comment) {
        self.additionaleventInformation[datetime] = comment;
        self.chart.series[2].addPoint([datetime, -1]);
        var tmp = self.seriesOptions[2].data;
        if (datetime > tmp[tmp.length - 1][0] || tmp.length == 0) {
            tmp.push([datetime, -1]);
        } else {
            for (var i = tmp.length - 1; i >= 0; i--) {
                if(tmp[i][0] > datetime){
                    tmp[i] = tmp[i - 1];
                }else{
                    tmp[i] = [datetime,-1];
                }
            };
        }
        console.log(tmp);
        self.seriesOptions[2].data = tmp;
        self.chart.series[2].setData(self.seriesOptions[2].data);
        console.log(self.chart.series[2]);
    }
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
    this.hideZoomBar = function() {
        self.chart.rangeSelector.zoomText.hide();
        $.each(self.chart.rangeSelector.buttons, function() {
            this.hide();
        });
        $(self.chart.rangeSelector.divRelative).hide();
    }
    // create the chart when all data is loaded
    this.createChart = function() {
        Highcharts.setOptions({
            global: {
                useUTC: false,
                timezoneOffset: 2 * 60
            }
        });
        var yAxissetting = [];
        console.log(self.seriesOptions);
        for (var i = 0; i < self.seriesOptions.length; i++) {
            yAxissetting.push({
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                }
            });
            self.seriesOptions[i]["yAxis"] = i;
        };
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
            yAxis: yAxissetting
            // {
            //     type: 'logarithmic',
            // }
            ,
            plotOptions: {
                spline: {
                    //set how many points maximun
                    turboThreshold: 100000,
                    lineWidth: 2,
                    // compare: 'percent'
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
                    self.additionalspotInformation = d[1];
                    self.customtooltips = {
                        formatter: function() {
                            //console.log(this);
                            var dateTime = new Date(this.x);
                            var htmlString = dateTime.toUTCString().replace('GMT', '') + '<br>';
                            for (key in self.additionalspotInformation[this.x]) {
                                htmlString = htmlString + "<b>" + key + " : " + self.additionalspotInformation[this.x][key] + '</b><br>';
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
                if (d.length == 3) {
                    self.seriesOptions = d[0];
                    self.seriesOptions[0]["dataGrouping"] = {
                        approximation: "sum",
                        enabled: true,
                    };
                    self.additionalspotInformation = d[1];
                    self.additionaleventInformation = d[2];
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

                            if (this.hasOwnProperty("series")) {
                                if (this.series.name == "Evènements") {
                                    htmlString = htmlString + '<p style="color:#CDD8DA">' + "Evènements" + " </p> : " + "<p><b>" + self.additionaleventInformation[this.x] + '</b></p><br>';
                                } else {
                                    for (key in self.additionalspotInformation[this.x]) {
                                        htmlString = htmlString + '<span style="color:#2DCC70">' + key + " </span> : " + "<b>" + self.additionalspotInformation[this.x][key] + '</b><br>';
                                    }
                                }
                            } else {
                                //console.log(this);
                                if (this.points[0].series.name == "Events") {
                                    htmlString = htmlString + '<span style="color:' + this.points[0].series.color + '">' + this.points[0].series.name + '</span>: <p>' + self.additionalspotInformation[this.x] + '</p><br/>';
                                } else {
                                    htmlString = htmlString + '<span style="color:' + this.points[0].series.color + '">' + this.points[0].series.name + '</span>: <b>' + this.y + '</b><br/>';
                                }
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