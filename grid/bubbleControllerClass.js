function BubbleController() {
  this.responseData = [];
  var plot = {};
  var self = this;
  this.createBubbleChart = function() {
    self.plot = $.jqplot('bubbleChart', [this.responseData[1]], {
      title: this.responseData[0][1] + " VS " + this.responseData[0][2],
      axes: {
        xaxis: {
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          label: this.responseData[0][1],
          tickOptions:{
            angle: -30
          },
          labelOptions: {
            fontFamily: 'Helvetica',
            fontSize: '14pt'
          },
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        },
        yaxis: {
          renderer: $.jqplot.LogAxisRenderer,
          tickOptions:{
                labelPosition: 'middle',
                angle:-30
            },
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          labelOptions: {
            fontFamily: 'Helvetica',
            fontSize: '14pt'
          },
          label: this.responseData[0][2]
        }
      },
      seriesDefaults: {
        renderer: $.jqplot.BubbleRenderer,
        rendererOptions: {
          bubbleAlpha: 1,
          highlightAlpha: 1,
          showLabels: false,
          bubbleGradients: false,
          autoscaleBubbles: false,
        },
        shadow: true,
        shadowAlpha: 0.05,
        showMarkers : true,
        animation: {
          speed: 2500
        }
      }
    });
  }

  // Legend is a simple table in the html.
  // Dynamically populate it with the labels from each data value.
  this.createTable = function() {
    $('#legend1b').empty();
    $('#legend1b').append('<tr><th>' + self.responseData[0][0] + '</th><th>' + self.responseData[0][1] + '</th><th>' + self.responseData[0][2] + '</th><th>' + self.responseData[0][3] + '</th></tr>');
    $.each(self.responseData[1], function(index, val) {
      var tmp = val[3].split(",");
      $('#legend1b').append('<tr><td>' + tmp[1] + '</td><td>' + val[0] + '</td><td>' + val[1] + '</td><td>' + tmp[0] + '</td></tr>');
    });
  }
  // Now bind function to the highlight event to show the tooltip
  // and highlight the row in the legend.
  this.bindDataHignlight = function() {
    $('#bubbleChart').bind('jqplotDataHighlight',
      function(ev, seriesIndex, pointIndex, data, radius) {
        console.log(data);
        var chart_left = $('#bubbleChart').offset().left,
          chart_top = $('#bubbleChart').offset().top,
          x = self.plot.axes.xaxis.u2p(data[0]), // convert x axis unita to pixels
          y = self.plot.axes.yaxis.u2p(data[1]); // convert y axis units to pixels
        var color = 'rgb(50%,50%,100%)';
        $('#tooltip1b').css({
          left: chart_left + x + radius + 5,
          top: chart_top + y
        });
        var split = data[3].split(",", 2);
        $('#tooltip1b').html('<span style="font-size:14px;font-weight:bold;color:' +
          color + ';">' + split[1] + '</span><br />' + 'TTR: ' + data[0] +
          '<br />' + 'Visites Gagnnees: ' + data[1] + '<br />' + 'FIABILITE-2: ' + split[0]);
        $('#tooltip1b').show();
        $('#legend1b tr').css('background-color', '#ffffff');
        $('#legend1b tr').eq(pointIndex + 1).css('background-color', color);
      });
  }

  // Bind a function to the unhighlight event to clean up after highlighting.
  this.bindDataUnhightlight = function() {
    $('#bubbleChart').bind('jqplotDataUnhighlight',
      function(ev, seriesIndex, pointIndex, data) {
        $('#tooltip1b').empty();
        $('#tooltip1b').hide();
        $('#legend1b tr').css('background-color', '#ffffff');
      });
  }
  this.bindBubbleClick = function() {
    $('#bubbleChart').bind('jqplotDataClick',
      function(ev, seriesIndex, pointIndex, data) {
        console.log('series: ' + seriesIndex + ', point: ' + pointIndex + ', data: ' + data);
        $('#legend1b').empty();
      }
    );
  }
  this.createLoadingMessage = function() {
    $("#bubbleChart").html("<img src='ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#bubbleChart").empty();
  }
  this.InitialChart = function() {
    self.createLoadingMessage();
    $.ajax({
      dataType: 'json',
      url: "server.php",
      async: true,
      success: function(d) {
        self.responseData = d;
        self.destroyLoadingMessage();
        self.createBubbleChart();
        self.createTable();
        self.bindDataHignlight();
        self.bindDataUnhightlight();
        self.bindBubbleClick();
      },
      cache: true
    });
    console.log(self.responseData);
  }

}