function BubbleChart() {
  var self = this,
    zoomLevel = 0,
    regroupement = [],
    client_name = "",
    chart,
    seriesOptions = [],
    additionalInformation;
  this.currentValue = [""];
  this.bubbleClickAvailable = true;
  this.client_url = "http://tyco.mymedia.fr/api/test.php";
  //prepare jqxChart settings

  this.createLoadingMessage = function() {
    $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#chart").empty();
  }
  // setup the chart
  this.createChart = function() {
    self.destroyLoadingMessage();
    //self.chart = new
    $('#chart').highcharts({
      chart: {
        type: 'bubble',
        renderTo: 'chart',
      },
      title: {
        text: self.currentValue.slice(1, self.zoomLevel + 1).join(',')
      },
      legend: {
        enabled: true,
      },
      xAxis: {
        type: "linear",
      },
      yAxis: {
        title: {
          text: '',
        }
      },
      credits: {
        enabled: false
      },
      tooltip: {
        useHTML: true,
        formatter: function(tooltip) {
          var color = this.series.color,
            info = self.additionalInformation[self.zoomLevel][this.series.name][this.point.index],
            htmlString = "";
          for (key in info) {
            htmlString += '<span style="color:' + color + '"> ' + key + ' : </span><b>' + info[key] + '</b><br>'
          }
          htmlString += '<span style="color:' + color + '"> ' + self.yLabel[self.zoomLevel] + " : </span><b>" + this.y + '</b><br>' + '<span style="color:' + color + '">  ' + self.xLabel[self.zoomLevel] + " : </span><b>" + this.x + '</b><br>';
          return htmlString;
        }
      },
      plotOptions: {
        bubble: {
          cursor: 'pointer',
          point: {
            events: {
              click: function() {
                //this.bubbleClickAvailable = false;
                console.log(this);
                //alert('go inside');
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
                var info = self.additionalInformation[self.zoomLevel][this.series.name][this.index];
                for (key in info) {
                  requestData["bubble"] = [key, info[key]];
                }
                self.currentValue[self.zoomLevel + 1] = requestData["bubble"][1];
                console.log("sending request to zoom");
                console.log(requestData);
                self.zoom(requestData);
                codeCleaner = null;
              }
            }
          }
        }
      },
      series: self.seriesOptions[self.zoomLevel]
    });
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
        self.zoomLevel = 0;
        self.regroupement = d[3]["regroupement"].split(" > ");
        // d[0][0].name = self.regroupement[self.zoomLevel];
        self.seriesOptions = [d[0]];
        self.xLabel = [d[1]["x"]];
        self.yLabel = [d[1]["y"]];
        self.additionalInformation = [d[2]];
        self.createChart();
      },
      failure: function(err) {
        console.log("Error");
      },
      cache: true
    });
  }
  this.updateChart = function(graphData, regroupment, client_name) {
    self.createLoadingMessage();
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
        //releasing memory
        self.data = null;
        if (d.length > 0) {
          self.currentValue = [""];
          self.zoomLevel = 0;
          // d[0][0].name = self.regroupement[self.zoomLevel];
          self.seriesOptions = [d[0]];
          self.xLabel = [d[1]["x"]];
          self.yLabel = [d[1]["y"]];
          self.additionalInformation = [d[2]];
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
            // complete: function() {
      //   self.bubbleClickAvailable = true;
      // },
      success: function(d) {
        console.log("zoom return data");
        console.log(d);
        self.zoomLevel++;
        if (d.length > 0) {
          self.seriesOptions[self.zoomLevel] = null;
          // d[0][0].name = self.regroupement[self.zoomLevel];
          self.seriesOptions[self.zoomLevel] = d[0];
          self.xLabel[self.zoomLevel] = d[1]["x"];
          self.yLabel[self.zoomLevel] = d[1]["y"];
          self.additionalInformation[self.zoomLevel] = d[2];
          self.createChart();
        }
      },
      cache: false
    });
  }
  this.goBack = function() {
    console.log("going back");
    if (self.zoomLevel > 0) {
      self.seriesOptions[self.zoomLevel] = undefined;
      self.currentValue[self.zoomLevel] = "";
      self.zoomLevel--;
      self.createChart();
    }
  }
}