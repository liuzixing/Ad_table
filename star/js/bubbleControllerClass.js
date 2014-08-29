function BubbleController() {
  var self = this;
  this.data = [];
  var source = {};
  var dataAdapter = {};
  var zoomLevel = 0;
  var regroupement = [];
  this.client_url = "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_data.php";
  var client_name = "";
  // prepare jqxChart settings

  this.createLoadingMessage = function() {
    $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");

  }
  this.destroyLoadingMessage = function() {
    $("#chart").empty();

  }
  this.clearPreviousTooltips = function() {
    $(".jqx-chart-tooltip-text").parent().remove();

  }
  // setup the chart
  this.createChart = function() {

    function myEventHandler(e) {
      if (self.zoomLevel >= self.regroupement.length - 1) {
        return;
      }
      var codeCleaner = new jqxHelperClass();
      var requestData = {
        "client": self.client_name,
        "period1": codeCleaner.getDateTimeInputRange("datepicker1"),
        "period2": {},
        "comparaison": $("#Comparaison").is(":checked"),
        "xaxis": codeCleaner.getDropDownListItem("xaxisselector"),
        "yaxis": codeCleaner.getDropDownListItem("yaxisselector"),
        "regroupement": "",
        "filter": {
          "channel": codeCleaner.getDropDownListItems("Chaîne"),
          "format": codeCleaner.getDropDownListItems("Format"),
          "version": codeCleaner.getDropDownListItems("Version"),
          "day": codeCleaner.getDropDownListItems("Dayofweek"),
          "MMDayPart": codeCleaner.getDropDownListItems("MMDaypart"),
          "category": codeCleaner.getDropDownListItems("Catégorie"),
          "Optimisation": $("#Optimisation").is(":checked")
        }
      };
      requestData["regroupement"] = self.regroupement[self.zoomLevel + 1];
      if (requestData["comparaison"] == true) {
        requestData["period2"] = codeCleaner.getDateTimeInputRange("datepicker2");
      }
      requestData["bubble"] = [Object.keys(self.data[self.zoomLevel][e.elementIndex])[0], self.data[self.zoomLevel][e.elementIndex][Object.keys(self.data[self.zoomLevel][e.elementIndex])[0]]];
      console.log("sending request to zoom");
      console.log(requestData);
      self.zoom(requestData);
      codeCleaner = null;
    };

    var toolTipCustomFormatFn = function(value, itemIndex, serie, group, categoryValue, categoryAxis) {
      var dataItem = self.data[self.zoomLevel][itemIndex];
      var htmlString = "<div>";
      for (key in dataItem) {
        htmlString = htmlString + '<b>' + key + ': </b>' + dataItem[key] + "<br>";
      }
      htmlString = htmlString + '</DIV>';
      return htmlString;
    };
    var keys = Object.keys(self.data[self.zoomLevel][0]);
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
    self.settings = {
      title: "Bubble Graph",
      description: "",
      toolTipShowDelay: 500,
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
      source: self.data[self.zoomLevel],
      xAxis: xAxis_setting,
      colorScheme: 'scheme02',
      seriesGroups: [{
        toolTipFormatFunction: toolTipCustomFormatFn,
        type: 'bubble',
        useGradient: false,
        valueAxis: {
          logarithmicScale: true,
          logarithmicScaleBase: 12,
          showGridLines: false,
        },
        series: series_setting
      }]
    };
    self.destroyLoadingMessage();
    $('#chart').jqxChart(self.settings);
    self.clearPreviousTooltips();
  }
  this.initialChart = function(client_name) {
    self.client_name = client_name;
    self.createLoadingMessage();
    $.ajax({
      type: 'GET',
      timeout: 10000,
      scriptCharset: "utf-8",
      dataType: 'json',
      url: self.client_url + "?client=" + self.client_name,
      async: true,
      success: function(d) {
        console.log("data for initial chart");
        console.log(d);
        self.data.push(d[0]);
        self.regroupement = d[1]["regroupement"].split(" > ");
        self.zoomLevel = 0;

        self.createChart();
      },
      failure: function(err) {
        console.log("Error");
      },
      cache: true
    });
  }
  this.updateChart = function(graphData, regroupment, client_name) {
    self.client_name = client_name;
    self.regroupement = regroupment.split(" > ");
    $.ajax({
      type: 'POST',
      dataType: 'json',
      scriptCharset: "utf-8",
      data: graphData,
      url: self.client_url,
      async: true,
      success: function(d) {
        console.log("updateChart");
        console.log(d);
        //self.destroyLoadingMessage();
        //releasing memory
        self.data = null;
        self.data = [];
        if (d.length > 0) {
          self.data.push(d);
          self.zoomLevel = 0;
          self.createChart();
        }
      },
      cache: false
    });
  }
  this.zoom = function(graphData) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      scriptCharset: "utf-8",
      data: graphData,
      url: self.client_url,
      async: true,
      success: function(d) {
        console.log("zoom return data");
        console.log(d);
        //self.destroyLoadingMessage();
        self.zoomLevel++;
        if (d.length > 0) {
          self.data[self.zoomLevel] = null;
          self.data[self.zoomLevel] = d;
          self.createChart();
        }
      },
      cache: false
    });
  }
  this.goBack = function() {
    console.log("going back");
    if (self.zoomLevel > 0) {
      self.data[self.zoomLevel] = undefined;
      self.zoomLevel--;
      self.destroyLoadingMessage();
      self.createChart();
    }
  }
}