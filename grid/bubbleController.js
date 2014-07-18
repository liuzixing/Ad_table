$(document).ready(function(){
  var responseData = [];
  $.ajax({
        dataType: 'json',
        url: "server.php",
        async: false,
        success: function(d) {
            responseData = d;
        },
        cache: false
    });
  console.log(responseData);
  var arr = [[11, 123, 1236, "Acura"], [45, 92, 1067, "Alfa Romeo"],
  [24, 104, 1176, "AM General"], [50, 23, 610, "Aston Martin Lagonda"],
  [18, 17, 539, "Audi"], [7, 89, 864, "BMW"], [2, 13, 1026, "Bugatti"]];

  var plot1b = $.jqplot('chart1b',[responseData[1]],{
    title: 'Tooltip and Custom Legend Highlighting',
    seriesDefaults:{
      renderer: $.jqplot.BubbleRenderer,
      rendererOptions: {
        bubbleAlpha: 0.6,
        highlightAlpha: 0.8,
        showLabels: false,

      },
      shadow: true,
      shadowAlpha: 0.05
    }
  });

  // Legend is a simple table in the html.
  // Dynamically populate it with the labels from each data value.

  $('#legend1b').append('<tr><th>'+responseData[0][3]+'</th><th>'+responseData[0][4]+'</th><th>'+responseData[0][5]+'</th><th>'+responseData[0][2]+'</th></tr>');
  $.each(responseData[1], function(index, val) {
    var tmp = val[3].split(",");
    $('#legend1b').append('<tr><td>'+tmp[0]+'</td><td>'+tmp[1]+'</td><td>'+tmp[2]+'</td><td>'+val[2]+'</td></tr>');
  });

  // Now bind function to the highlight event to show the tooltip
  // and highlight the row in the legend.
  $('#chart1b').bind('jqplotDataHighlight',
    function (ev, seriesIndex, pointIndex, data, radius) {
      var chart_left = $('#chart1b').offset().left,
        chart_top = $('#chart1b').offset().top,
        x = plot1b.axes.xaxis.u2p(data[0]),  // convert x axis unita to pixels
        y = plot1b.axes.yaxis.u2p(data[1]);  // convert y axis units to pixels
      var color = 'rgb(50%,50%,100%)';
      $('#tooltip1b').css({left:chart_left+x+radius+5, top:chart_top+y});
      $('#tooltip1b').html('<span style="font-size:14px;font-weight:bold;color:' +
      color + ';">' + data[3] + '</span><br />' + 'TTR: ' + data[0] +
      '<br />' + 'Visites Gagnnees: ' + data[1] + '<br />' + 'Nombre de Contacts: ' + data[2]);
      $('#tooltip1b').show();
      $('#legend1b tr').css('background-color', '#ffffff');
      $('#legend1b tr').eq(pointIndex+1).css('background-color', color);
    });

  // Bind a function to the unhighlight event to clean up after highlighting.
  $('#chart1b').bind('jqplotDataUnhighlight',
      function (ev, seriesIndex, pointIndex, data) {
          $('#tooltip1b').empty();
          $('#tooltip1b').hide();
          $('#legend1b tr').css('background-color', '#ffffff');
      });
});