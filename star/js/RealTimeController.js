 function RealTimeController() {
     var _self = this;
     var _dataWithZero = [];
     //var data[];
     var _chart;
     this._dataWithZero = [];
     this._seriesOptions = [];
     this._plotLinesOptions = [];
     this.createLoadingMessage = function() {
         $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
     }
     this.destroyLoadingMessage = function() {
         $("#chart").empty();
     }
     this.attachLiveEvent = function() {
         $.ajax({
             data: "client=Justfab",
             url: 'live_server.php',
             success: function(point) {
                 var real = _self._chart.series[0];
                var lastpoint = _self._chart.series[0].xData[_self._chart.series[0].xData.length-1];
                console.log(point);
                var atLeastUpdateOnePoint = false;
                 for (var i = 0 ;i < point.length;i++){
                    if(point[i][0] - lastpoint <= 0){
                        continue;
                    }
                    while(point[i][0] - lastpoint > 1000){
                        lastpoint = lastpoint + 1000;
                        _self._chart.series[0].addPoint([lastpoint,0], true, true);
                        atLeastUpdateOnePoint = true;
                    }
                    if(point[i][0] - lastpoint === 1000 ){
                        lastpoint = lastpoint + 1000;
                        _self._chart.series[0].addPoint([point[i][0],point[i][1]], true, true);
                        atLeastUpdateOnePoint = true;
                    }
                }
                if(atLeastUpdateOnePoint === false){
                    _self._chart.series[0].addPoint([lastpoint+1000,0], true, true);
                }
                 // call it again after 1 second
                 setTimeout(_self.attachLiveEvent, 1000);
             },
             statusCode: {
                 502: function() {
                     setTimeout(_self.attachLiveEvent, 1000);
                 }
             },
             cache: true
         });

     }
     this.createGraph = function() {
         Highcharts.setOptions({
             global: {
                 useUTC: false,
                 timezoneOffset: 2 * 60
             }
         });
         _self._chart = new Highcharts.StockChart({
        series: _self._seriesOptions,
        chart: {
            type: 'spline',
            renderTo: 'chart',
            defaultSeriesType: 'spline',
            zoomType: 'xy',
            //load update function here
            events: {
                load: _self.requestRealTimeData
            }
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'Real time tracking'
        },
        plotOptions: {
            spline: {
                //set how many points maximun
                turboThreshold: 180000,
                lineWidth: 2
            }
        },
        rangeSelector: {
            buttons: [{
                count: 30,
                type: 'minute',
                text: '30M'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false,
            selected: 0
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000,
            plotLines: _self._plotLinesOptions
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Visits',
                margin: 80
            }
        },

    });
     }
     this.InitialGraph = function() {
         _self.createLoadingMessage();
         $.ajax({
             data: "client=Justfab",
             url: 'server.php',
             async: true,
             success: function(data) {

                 //console.log(data);
                 for (var i = 0; i < data[0].length - 1; i++) {
                     _self._dataWithZero.push(data[0][i]);
                     var currentX = data[0][i][0];
                     while (data[0][i + 1][0] - currentX > 1000) {
                         currentX += 1000;
                         _self._dataWithZero.push([currentX, 0]);
                     }
                 };
                 _dataWithZero.push(data[0][data[0].length - 1]);

                 _self._seriesOptions[0] = {
                     name: "Visites",
                     data: _self._dataWithZero,
                     dataGrouping: {
                         approximation: "sum",
                         enabled: true,
                     }
                 };
                 for (var i = 0; i < data[1].length; i++) {
                _self._plotLinesOptions[i] = {
                    color: 'red', // Color value
                    dashStyle: 'longdashdot', // Style of the plot line. Default to solid
                    value: data[1][i][0], // Value of where the line will appear
                    label: {
                        value: 10,
                        text: data[1][i][1],
                        align: 'right',
                        staggerLines: 1,
                        rotation: (90 * ((i * 2) + 1)),
                        verticalAlign: "middle",
                        x: 100,
                        y: 80,
                        style: {
                            color: 'blue',
                            //fontWeight: 'bold'
                        },
                        y: 0,
                        x: 5

                    },
                    allowPointSelect: true,
                    width: '2' // Width of the line

                };
                //console.log(data[i].text);
            }
                 _self.destroyLoadingMessage();
                 _self.createGraph();
                 _self.attachLiveEvent();
             },
             cache: true,
         });
     }
 }