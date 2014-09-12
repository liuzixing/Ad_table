function ZoomableTimeSeries() {
    var self = this;
    var chart,
        seriesOptions = [],
        customtooltips,
        additionalspotInformation,
        customXaxis;
    this.yAxissetting = {};
    this.additionaleventInformation = {};

    this.isNavigatorEnabled = true;
    this.updateEvent = function(datetime, comment) {
        console.log(self.additionaleventInformation);
        if (self.additionaleventInformation == null) {
            self.additionaleventInformation = {};
        }
        self.additionaleventInformation[datetime] = comment;
        self.chart.series[2].addPoint([datetime, -1]);
        // var tmp = self.seriesOptions[2].data;
        // if (datetime > tmp[tmp.length - 1][0] || tmp.length == 0) {
        //     tmp.push([datetime, -1]);
        // } else {
        //     for (var i = tmp.length - 1; i >= 0; i--) {
        //         if(tmp[i][0] > datetime){
        //             tmp[i] = tmp[i - 1];
        //         }else{
        //             tmp[i] = [datetime,-1];
        //         }
        //     };
        // }
        // console.log(tmp);
        // self.seriesOptions[2].data = tmp;
        // self.chart.series[2].setData(self.seriesOptions[2].data);
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
    this.resetYaxis = function() {
        self.yAxissetting = {};
    }
    this.createMultiplyYaxis = function() {
        self.yAxissetting = [];
        for (var i = 0; i < self.seriesOptions.length; i++) {
            self.yAxissetting.push({
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                }
            });
            self.seriesOptions[i]["yAxis"] = i;
        };
    }
    this.resetXaxis = function() {
        self.customXaxis = {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000,
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

        self.destroyLoadingMessage();
        self.chart = new Highcharts.StockChart({
            chart: {
                type: 'spline',
                renderTo: 'chart',
                defaultSeriesType: 'spline',
                zoomType: 'xy',
            },
            navigator: {
                enabled: self.isNavigatorEnabled,
            },
            legend: {
                enabled: true,
            },
            rangeSelector: {
                inputEnabled: false,
            },
            yAxis: self.yAxissetting,
            plotOptions: {
                spline: {
                    //set how many points maximun
                    turboThreshold: 100000,
                    lineWidth: 2,
                }
            },
            xAxis: self.customXaxis,
            tooltip: self.customtooltips,
            series: self.seriesOptions
        }, function(chart) {
            self.onChartLoad(chart);
        });
        self.hideZoomBar();
    };
    self.onChartLoad = function(chart) {
        return;
    }
    //for concurrence
    this.updateChart = function(graphData, client_url) {
        self.createLoadingMessage();
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
                self.seriesOptions = null;
                self.additionalspotInformation = null;
                //d.length == 2 means you choose one day
                if (d.length == 2) {
                    self.seriesOptions = d[0];
                    self.additionalspotInformation = d[1];
                    //self.customXaxis["tickInterval"] = 60 * 1000;
                    self.customXaxis["ordinal"] = false;
                    console.log("customX");
                    console.log(self.customXaxis);
                    //self.isNavigatorEnabled = false;
                    // self.onChartLoad = function(chart) {
                    //     $.each(chart.series[0].data, function(i, point) {
                    //         var group;
                    //         // Create a group element that is positioned and clipped at 30 pixels width and height
                    //         group = chart.renderer.g()
                    //             .attr({
                    //                 translateX: point.plotX + chart.plotLeft - 30,
                    //                 translateY: point.plotY + chart.plotTop - 50,
                    //                 zIndex: 5
                    //             })
                    //             .clip(chart.renderer.clipRect(0, 0, 45, 45))
                    //             .add();

                    //         // Position the image inside it at the sprite position
                    //         chart.renderer.image(
                    //             '../img/channel-logos/' + self.additionalspotInformation[point.x]["Chaines"].replace(/\s+/g, '') + ".png", 20, 20,
                    //             20,
                    //             20
                    //         )
                    //             .add(group);
                    //     });
                    // }
                    self.customtooltips = {
                        useHTML: true,
                        formatter: function() {
                            //console.log(this);
                            //spot = self.additionalspotInformation[this.points[0].series.name][this.x],
                            var dateTime = new Date(this.x + 2 * 60 * 60 * 1000),
                            htmlString = dateTime.toUTCString().replace('GMT', '') + '<br>',
                            spot = self.additionalspotInformation[this.x],
                            color = this.points[0].series.color;
                            for (key in spot) {
                                // if (key == "Chaines") {
                                //     htmlString = htmlString + "<b>" + key + " : </b>" + '<img src="../img/channel-logos/' + self.additionalspotInformation[this.x][key] + '.png">' + '<br>';
                                // } else
                                // {
                                    htmlString = htmlString + '<span style="color:'+color+'"> ' + key + " : <b></span>" + spot[key] + '</b><br>';
                                // }
                            }
                            //console.log(htmlString);
                            return htmlString;
                        }
                    }
                } else {
                    //you choose a period
                    self.seriesOptions = d;
                    self.resetPointFormat();
                }
                console.log(self.customXaxis);
                self.createChart();
            },
            cache: false
        });
    }
    this.updateCampagne = function(graphData, client_url) {
        self.createLoadingMessage();
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
                //the following 3 lines are to release memory
                self.seriesOptions = null;
                self.additionalspotInformation = null;
                self.additionaleventInformation = null;
                //d.length == 3  means you choose one day
                if (d.length == 3) {
                    self.seriesOptions = d[0];
                    self.seriesOptions[0]["dataGrouping"] = {
                        approximation: "sum",
                        enabled: true,
                    };
                    self.additionalspotInformation = d[1];
                    self.additionaleventInformation = d[2];
                    //create custom plotband settings
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
                        plotband.push({ // plot the spots
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
                    };
                } else {
                    //when you choose a period
                    self.seriesOptions = d;
                    self.resetPointFormat();
                    self.resetXaxis();
                    self.createMultiplyYaxis();
                }
                self.createChart();
            },
            cache: false
        });
    }
    this.initialChart = function(client_url,multiY) {

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
                if (multiY){
                    self.createMultiplyYaxis();
                }else{
                    self.resetYaxis();
                }
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