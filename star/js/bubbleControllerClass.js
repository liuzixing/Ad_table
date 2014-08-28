function BubbleController() {
  var self = this;
  var data = [];
  var source = {};
  var dataAdapter = {};

  // prepare jqxChart settings

  this.createLoadingMessage = function() {
    $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#chart").empty();
  }
  this.updateChart = function(d) {
    self.data = d;
    self.destroyLoadingMessage();
    self.createChart();
  }
  // setup the chart
  // http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_data.php?client=Balsamik
  this.createChart = function() {
    function myEventHandler(e) {
      var eventData = 'DataField: ' + e.serie.dataField + ', Value: ' + e.elementValue;
      console.log(e);
      alert(eventData + "                        skipping to another graph");
    };
    //console.log(self.data[0]);

    var toolTipCustomFormatFn = function(value, itemIndex, serie, group, categoryValue, categoryAxis) {
      var dataItem = self.data[itemIndex];
      var htmlString = "<div>";
      for (key in dataItem) {
        htmlString = htmlString + '<b>' + key + ': </b>' +
          dataItem[key] + "<br>";
      }
      htmlString = htmlString + '</DIV>';
      return htmlString;
    };
    var keys = Object.keys(self.data[0]);
    //console.log(keys);
    var xAxis_setting = {
      dataField: keys[1],
      valuesOnTicks: false,
      showGridLines: false,
    };
    var series_setting = [];
    if (keys.length > 3) {
      series_setting = [{
        dataField: keys[1],
        radiusDataField: keys[3],
        minRadius: 24,
        maxRadius: 25,
        click: myEventHandler,
        displayText: 'first period'
      }, {
        dataField: keys[2],
        radiusDataField: keys[0],
        minRadius: 24,
        maxRadius: 25,
        click: myEventHandler,
        displayText: 'second period'
      }];
    } else {
      series_setting = [{
        logarithmicScale: true,
        dataField: keys[2],
        radiusDataField: keys[0],
        minRadius: 24,
        maxRadius: 25,
        click: myEventHandler,
        displayText: 'first period'
      }];
    }

    //console.log(series_setting);
    //console.log(xAxis_setting);
    self.settings = {
      title: "Bubble Graph",
      description: "",
      enableAnimations: true,
      showLegend: true,
      padding: {
        left: 5,
        top: 5,
        right: 5,
        bottom: 5
      },
      titlePadding: {
        left: 90,
        top: 0,
        right: 0,
        bottom: 10
      },
      source: self.data,
      xAxis: xAxis_setting,
      colorScheme: 'scheme02',
      seriesGroups: [{
        toolTipFormatFunction: toolTipCustomFormatFn,
        type: 'bubble',
        useGradient: false,

        valueAxis: {
          logarithmicScale: true,
          logarithmicScaleBase:12,
          showGridLines: false,
          // unitInterval: 50000,
          //description: 'Sales ($)',k
          // formatSettings: {
          //   prefix: '$',
          //   thousandsSeparator: ','
          // }
        },
        series: series_setting
      }]
    };
    $('#chart').jqxChart(self.settings);
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
        self.data = d;
        //console.log(self.data);
        self.destroyLoadingMessage();
        self.createChart();
      },
      failure: function(err) {
        console.log("Error");
      },
      cache: true
    });
  }
}