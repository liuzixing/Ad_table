function ConcurrenceController() {
  var globaltheme = 'bootstrap';
  var client_name = "EDarling";
  var codeCleaner = new jqxHelperClass();
  var layout = new LayoutController();
  layout.createLayout();
  $("#datepicker1").jqxDateTimeInput({
    theme: globaltheme,
    width: '90%',
    height: '25px',
    selectionMode: 'range'
  });
  $.ajax({
    type: 'GET',
    timeout: 10000,
    dataType: 'json',
    url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence_filters.php?client=' + client_name,
    async: true,
    success: function(d) {
      //console.log(d);
      //
      $("#concurrenceselector").jqxDropDownList({
        theme: globaltheme,
        source: d["Concurrent"],
        placeHolder: "Sélection des concurrents",
        width: '90%',
        height: '25'
      });
      $("#Chaîne").jqxDropDownList({
        theme: globaltheme,
        source: d["chaines"],
        placeHolder: "Chaîne",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#MMDayPart").jqxDropDownList({
        theme: globaltheme,
        source: d["MMDayPart"],
        placeHolder: "MMDayPart",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#Format").jqxDropDownList({
        theme: globaltheme,
        source: d["format"],
        placeHolder: "Format",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#Chaîne").jqxDropDownList('checkAll');
      $("#MMDayPart").jqxDropDownList('checkAll');
      $("#Format").jqxDropDownList('checkAll');

      //datepick settings
      var today = new Date();
      var sixmonthsago = new Date();
      sixmonthsago.setDate(today.getDate() - 180);
      $("#datepicker1").jqxDateTimeInput({
        theme: globaltheme,
        width: '90%',
        height: '25px',
        min: sixmonthsago,
        max: today,
        selectionMode: 'range'
      });
      var from = new Date(d["period"]["from"]);
      var to = new Date(d["period"]["to"]);
      $("#datepicker1").jqxDateTimeInput('setRange', from, to);
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });
  var grid = new TreeGridController();
  grid.initialTreeGrid('http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence.php?client=' + client_name, []);

  // var chart = new ZoomableTimeSeries();
  //  chart.initialChart("http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/hc_graph.php?client="+client_name);

  $("#Valider").click(function() {
    var requestData = {
      "client": client_name,
      "period": codeCleaner.getDateTimeInputRange("datepicker1"),
      "concurrent": codeCleaner.getDropDownListItem("concurrenceselector"),
      "filter": {
        "chaines": codeCleaner.getDropDownListItems("Chaîne"),
        "format": codeCleaner.getDropDownListItems("Format"),
        "MMDayPart": codeCleaner.getDropDownListItems("MMDayPart")
      }
    };
    console.log(requestData);
    grid.updateTreeGrid(requestData, 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence.php');
    //chart.updateChart(requestData,"");
  });
}