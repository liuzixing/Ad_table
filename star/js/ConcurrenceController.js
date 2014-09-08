function ConcurrenceController() {
  var globaltheme = 'bootstrap';
  var client_name = getCookie("mymedia_client_name");
  var codeCleaner = new jqxHelperClass();
  var layout = new LayoutController();
  var grid = new TreeGridController();
  var chart = new ZoomableTimeSeries();
  var filter_url = "http://tyco.mymedia.fr/api/api_concurrence_filters.php";
  var graph_url = "http://tyco.mymedia.fr/api/api_concurrence_graphe.php";
  var table_url = "http://tyco.mymedia.fr/api/api_concurrence.php";
  layout.createLayout();
  $('.client-website').html(client_name);
  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: filter_url + '?client=' + client_name,
    async: true,
    success: function(d) {
      //console.log(d);
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
      $("#Chaîne").jqxDropDownList('setContent', 'Chaîne(s)');
      $("#MMDayPart").jqxDropDownList('setContent', 'DaypartMM(s)');
      $("#Format").jqxDropDownList('setContent', 'Format(s)');
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
      console.log(getCookie("default_date"));
      if (getCookie("default_date")) {
        $("#datepicker1").jqxDateTimeInput('setRange', getCookie("default_date"), getCookie("default_date"));
        setCookie("default_date", "", 0);
      } else {
        var from = new Date(d["period"]["from"]);
        var to = new Date(d["period"]["to"]);
        $("#datepicker1").jqxDateTimeInput('setRange', from, to);
      }
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });

  grid.initialTreeGrid(table_url + '?client=' + client_name, []);
  console.log(getCookie("default_date"));
  if (getCookie("default_date")) {
    var requestData = {
      "client": client_name,
    };
    requestData["period"] = {
      "from": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
      "to": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
    };
    console.log("from dashboard");
    console.log(requestData);
    chart.updateChart(requestData, graph_url);
  } else {
    chart.initialChart(graph_url + "?client=" + client_name);
  }
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
    grid.updateTreeGrid(requestData, table_url);
    chart.updateChart(requestData, graph_url);
  });
}