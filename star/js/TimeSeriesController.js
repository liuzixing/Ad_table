function TimeSeriesController() {
  var self = this;
  var data = [];
  var source = {};
  var dataAdapter = {};
  this.createLoadingMessage = function() {
    $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#chart").empty();
  }
  this.getChartType = function() {
    var first_date = self.data[2][0]["date"].split(" ")[0];
    var last_date = self.data[2][self.data[2].length - 1]["date"].split(" ")[0];
    if (first_date == last_date) {
      return "column";
    } else {
      return "spline";
    }
  }
  this.createChart = function() {
    var toolTipCustomFormatFn = function(value, itemIndex, serie, group, categoryValue, categoryAxis) {
      var dataItem = self.data[2][itemIndex];
      var htmlString = "<div>";
      for (key in dataItem) {
        htmlString = htmlString + '<b>' + key + ': </b>' +
          dataItem[key] + "<br>";
      }
      htmlString = htmlString + '</DIV>';
      return htmlString;
    };
    var chart_type = self.getChartType();
    console.log(chart_type);
    self.source = {
      datatype: "json",
      datafields: self.data[0],
      localData: self.data[2],
    };
    self.dataAdapter = new $.jqx.dataAdapter(self.source, {
      loadError: function(xhr, status, error) {
        alert('Error loading "' + self.source.url + '" : ' + error);
      }
    });
    var minDate = new Date(self.data[2][0]["date"]);
    var maxDate = new Date(self.data[2][self.data[2].length - 1]["date"]);
    // prepare jqxChart settings
    self.settings = {
      title: "",
      description: " ",
      enableAnimations: true,
      showLegend: true,
      enableCrosshairs: true,
      padding: {
        left: 20,
        top: 5,
        right: 25,
        bottom: 5
      },
      titlePadding: {
        left: 90,
        top: 0,
        right: 0,
        bottom: 10
      },
      source: self.dataAdapter,
      xAxis: {
        dataField: 'date',
        showTickMarks: true,
        baseUnit: 'day',
        tickMarksInterval: 5,
        tickMarksColor: '#888888',
        type: "date",
        valuesOnTicks: true,
        minValue: minDate,
        maxValue: maxDate,
        showGridLines: false,
      },
      colorScheme: 'scheme13',
      seriesGroups: [{
        toolTipFormatFunction: toolTipCustomFormatFn,
        type: chart_type,
        useGradient: false,
        valueAxis: {
          unitInterval: 10,
          displayValueAxis: false,
          displayGridLines: false,
          showGridLines: false,
          showLabels: true
        },
        series: [self.data[1][0]]
      }, {
        toolTipFormatFunction: toolTipCustomFormatFn,
        type: chart_type,
        useGradient: false,
        valueAxis: {
          unitInterval: 10,
          displayValueAxis: false,
          displayGridLines: false,
          showLabels: true
        },
        series: [self.data[1][1]]
      }, {
        toolTipFormatFunction: toolTipCustomFormatFn,
        type: chart_type,
        useGradient: false,
        valueAxis: {
          unitInterval: 10,
          displayValueAxis: false,
          displayGridLines: false,
          showLabels: true
        },
        series: [self.data[1][2]]
      }]
    };

    //console.log(self.settings);
    $('#chart').jqxChart(self.settings);
  }
  this.updateChart = function(d) {
    self.data = d;
    self.destroyLoadingMessage();
    self.createChart();
  }
  // setup the chart
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
        console.log(self.data);
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