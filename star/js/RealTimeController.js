 function RealTimeController() {
     var _self = this;
     var _dataWithZero = [];
     //var data[];
     var _source = {};
     var _dataAdapter = {};
     var _settings = {};
     this.createLoadingMessage = function() {
         $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
     }
     this.destroyLoadingMessage = function() {
         $("#chart").empty();
     }
     this.attachLiveEvent = function() {
         $.ajax({
             data: "idsite=8",
             url: 'live_server.php',
             success: function(point) {
                 console.log(point);
                 //var pre = chart.series[0];
                 //var real = _self._dataAdapter.records;
                 var lastpoint = _self._dataWithZero[_self._dataWithZero.length - 1]["Date"];
                 console.log(_self._dataAdapter);
                 var atLeastUpdateOnePoint = false;
                 for (var i = 0; i < point.length; i++) {
                     if (point[i]["Date"] - lastpoint <= 0) {
                         continue;
                     }
                     while (point[i]["Date"] - lastpoint > 1000) {
                         lastpoint = lastpoint + 1000;
                         _self._dataWithZero.push({
                             "Date": lastpoint,
                             "Visits": 0
                         });
                         atLeastUpdateOnePoint = true;
                     }
                     if (point[i]["Date"] - lastpoint === 1000) {
                         lastpoint = lastpoint + 1000;
                         _self._dataWithZero.push({
                             "Date": point[i]["Date"],
                             "Visits": point[i]["Visits"]
                         });
                         atLeastUpdateOnePoint = true;
                     }
                 }
                 if (atLeastUpdateOnePoint === false) {
                     _self._dataWithZero.push({
                         "Date": lastpoint + 1000,
                         "Visits": 0
                     });
                 }
                 _self._dataAdapter.dataBind();
                $('#chart').jqxChart('update');
                 //$('#chart').jqxChart('refresh');
                 // call it again after 1 second
                 setTimeout(_self.attachLiveEvent, 1000);
             },
             statusCode: {
                 502: function() {
                     setTimeout(_self.attachLiveEvent, 1000);
                 }
             },
             cache: false
         });

     }
     this.createGraph = function() {
        _self._source = {
             datatype: "json",
             localdata:_self._dataWithZero,
             datafields: [{
                 name: 'Date',
                 type: 'date'
             }, {
                 name: 'Visits',
                 type: 'int'
             }]
         };
         _self._dataAdapter = new $.jqx.dataAdapter(_self._source, {
             autoBind: true});
         _self._settings = {
             title: "visit  / time",
             description: "",
             enableAnimations: true,
             animationDuration: 1000,
             enableAxisTextAnimation: true,
             enableCrosshairs: true,
            crosshairsDashStyle: '2,2',
            crosshairsLineWidth: 2.0,
            crosshairsColor: 'red',
             showLegend: true,
             padding: {
                 left: 10,
                 top: 5,
                 right: 10,
                 bottom: 5
             },
             titlePadding: {
                 left: 90,
                 top: 0,
                 right: 0,
                 bottom: 10
             },
             source: _self._dataAdapter,
             xAxis: {
                 dataField: 'Date',
                 type: 'date',
                 formatFunction: function(value) {
                    //return"<img src='../img/ajax-loader.gif' alt='loading' />";
                     return $.jqx.dataFormat.formatdate(value, 'T');

                 },
                 showTickMarks: true,
                 axisSize: 'auto',
                 tickMarksColor: '#888888',
                 gridLinesColor: '#888888',
                 valuesOnTicks: true,
                 tickMarksInterval: 1,
                 tickMarksColor: '#888888',
                 unitInterval: 1,
                 rangeSelector: {
                     renderTo: $('#selectorContainer'),
                     size: 120,
                     padding: {
                         left: 0,
                         right: 0,
                         top: 30,
                         bottom: 0
                     },
                     backgroundColor: 'white',
                     dataField: 'Visits',
                     showGridLines: false,
                     formatFunction: function(value) {
                         return $.jqx.dataFormat.formatdate(value, 'T');
                     }
                 },
             },
             colorScheme: 'scheme05',
             seriesGroups: [{
                 type: 'spline',
                 valueAxis: {
                     columnsGapPercent: 10,
                     seriesGapPercent: 0,
                     //unitInterval: 2,

                     displayValueAxis: true,
                     description: 'Visits',
                     axisSize: 'auto',
                     tickMarksColor: '#888888'
                 },
                 series: [{
                     dataField: 'Visits',
                     displayText: 'visites'
                 }]
             }]
         }; //end settings
         console.log(_self._settings);
         _self.destroyLoadingMessage();

         $('#chart').jqxChart(_self._settings);
         console.log($('#chart').jqxChart('getInstance'));
         //
         //_self.attachLiveEvent();

     }
     this.InitialGraph = function() {
         _self.createLoadingMessage();
         $.ajax({
             data: "idsite=8",
             url: 'server.php',
             async: true,
             success: function(data) {
                 console.log(data);
                 _self._dataWithZero =data;
                 _self._dataWithZero = [];
                 for (var i = 12300; i < data.length - 1; i++) {
                     //console.log(data[i]);
                     _self._dataWithZero.push(data[i]);
                     var currentX = data[i]["Date"];
                     while (data[i + 1]["Date"] - currentX > 1000) {
                         currentX += 1000;
                         _self._dataWithZero.push({
                             "Date": currentX,
                             "Visits": 0
                         });
                     }
                 }
                 _self._dataWithZero.push(data[data.length - 1]);
                 console.log(_self._dataWithZero);
                 _self.destroyLoadingMessage();
                 _self.createGraph();
             },
             cache: false,
         });
     }
 }