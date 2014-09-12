function BubbleChart() {
  var self = this,
    zoomLevel = 0,
    regroupement = [],
    client_name = "",
    chart,
    seriesOptions = [],
    additionalInformation;
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
      legend: {
        enabled: true,
      },
      xAxis: {
            type:"linear",
        },
      tooltip: {
        useHTML: true,
        formatter: function(tooltip) {
          console.log(tooltip);
          console.log(this);
          var color = this.series.color,
          channel = self.additionalInformation[this.series.name][this.x.toFixed(2)];
          htmlString = '<span style="color:' + color + '"> Chaine : </span><b>' + channel+ '</b><br>'
          + '<span style="color:' + color + '"> ' + self.yLabel + " : </span><b>" + this.y + '</b><br>'
          + '<span style="color:' + color + '">  ' + self.xLabel + " : </span><b>" + this.x + '</b><br>';
          return htmlString;
        }
      },
      plotOptions: {
        bubble: {
          cursor: 'pointer',
          point: {
            events: {
              click: function() {
                alert('go inside');
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
                // requestData["bubble"] = [Object.keys(self.data[self.zoomLevel][e.elementIndex])[0], self.data[self.zoomLevel][e.elementIndex][Object.keys(self.data[self.zoomLevel][e.elementIndex])[0]]];
                console.log("sending request to zoom");
                console.log(requestData);
                self.zoom(requestData);
                codeCleaner = null;
              }
            }
          }
        }
      },
      series: self.seriesOptions
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
        self.seriesOptions = d[0];
        self.xLabel = d[1]["x"];
        self.yLabel = d[1]["y"];
        self.additionalInformation = d[2];
        self.regroupement = d[3]["regroupement"].split(" > ");
        self.zoomLevel = 0;
        self.createChart();
      },
      failure: function(err) {
        console.log("Error");
      },
      cache: true
    });
  }
  // this.updateChart = function(graphData, regroupment, client_name) {
  //   self.client_name = client_name;
  //   self.regroupement = regroupment.split(" > ");
  //   $.ajax({
  //     type: 'POST',
  //     dataType: 'json',
  //     scriptCharset: "utf-8",
  //     data: graphData,
  //     url: self.client_url,
  //     async: true,
  //     success: function(d) {
  //       console.log("updateChart");
  //       console.log(d);
  //       //releasing memory
  //       self.data = null;
  //       self.data = [];
  //       if (d.length > 0) {
  //         self.data.push(d);
  //         self.zoomLevel = 0;
  //         self.createChart();
  //       }
  //     },
  //     cache: false
  //   });
  // }
  // this.zoom = function(graphData) {
  //   $.ajax({
  //     type: 'POST',
  //     dataType: 'json',
  //     scriptCharset: "utf-8",
  //     data: graphData,
  //     url: self.client_url,
  //     async: true,
  //     success: function(d) {
  //       console.log("zoom return data");
  //       console.log(d);
  //       self.zoomLevel++;
  //       if (d.length > 0) {
  //         self.data[self.zoomLevel] = null;
  //         self.data[self.zoomLevel] = d;
  //         self.createChart();
  //       }
  //     },
  //     cache: false
  //   });
  // }
  // this.goBack = function() {
  //   console.log("going back");
  //   if (self.zoomLevel > 0) {
  //     self.data[self.zoomLevel] = undefined;
  //     self.zoomLevel--;
  //     self.destroyLoadingMessage();
  //     self.createChart();
  //   }
  // }
}