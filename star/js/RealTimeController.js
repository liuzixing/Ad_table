 function RealTimeController() {
   var data = [{
     a: 100,
     b: 200,
     c: 1
   }, {
     a: 120,
     b: 140,
     c: 2
   }, {
     a: 100,
     b: 110,
     c: 3
   }, {
     a: 90,
     b: 135,
     c: 4
   }, {
     a: 70,
     b: 210,
     c: 5
   }, {
     a: 170,
     b: 210,
     c: 5
   }, {
     a: 270,
     b: 350,
     c: 5
   }, {
     a: 710,
     b: 410,
     c: 5
   }, {
     a: 230,
     b: 305,
     c: 5
   }];
   // prepare jqxChart settings
   var settings = {
     title: "Live updates ",
     description: "Data changes every 1 seconds",
     enableAnimations: true,
     animationDuration: 1000,
     enableAxisTextAnimation: true,
     showLegend: true,
     padding: {
       left: 5,
       top: 5,
       right: 5,
       bottom: 5
     },
     titlePadding: {
       left: 0,
       top: 0,
       right: 0,
       bottom: 10
     },
     source: data,
     xAxis: {
       unitInterval: 1,
       gridLinesInterval: 2,
       valuesOnTicks: false
     },
     colorScheme: 'scheme05',
     seriesGroups: [{
       type: 'stackedsplinearea',
       columnsGapPercent: 50,
       alignEndPointsWithIntervals: true,
       valueAxis: {
         minValue: 0,
         maxValue: 1000,
         description: 'Index Value'
       },
       series: [{
         dataField: 'a',
         displayText: 'a',
         opacity: 1,
         lineWidth: 1,
         symbolType: 'circle',
         fillColorSymbolSelected: 'white',
         radius: 15
       }, {
         dataField: 'b',
         displayText: 'b',
         opacity: 1,
         lineWidth: 1,
         symbolType: 'circle',
         fillColorSymbolSelected: 'white',
         radius: 15
       }]
     }]
   };
   // create the chart
   $('#chart').jqxChart(settings);


   // auto update timer
   var ttimer = setInterval(function() {
     var max = 800;
     for (var i = 0; i < data.length; i++) {
       data[i].a = Math.max(100, (Math.random() * 800) % max);
       data[i].b = Math.max(100, (Math.random() * 800) % max);
     }
     $('#chart').jqxChart('update');
   }, 1500);
 }