function ConcurrenceController() {
  var client_name = getCookie("mymedia_client_name"),
    codeCleaner = new jqxHelperClass(),
    layout = new LayoutController(),
    grid = new TreeGridController(),
    chart = new ZoomableTimeSeries(),
    filter_url = "http://tyco.mymedia.fr/api/api_concurrence_filters.php",
    graph_url = "http://tyco.mymedia.fr/api/api_concurrence_graphe.php",
    table_url = "http://tyco.mymedia.fr/api/api_concurrence.php";
  layout.createLayout();
  $('.client-website').html(client_name);
  //get filter and options data
  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: filter_url + '?client=' + client_name,
    async: true,
    success: function(d) {
      codeCleaner.initialSideBarDropDownList("concurrenceselector", d["Concurrent"], false);
      codeCleaner.initialSideBarDropDownList("Chaîne", d["chaines"], true);
      codeCleaner.initialSideBarDropDownList("MMDayPart", d["MMDayPart"], true);
      codeCleaner.initialSideBarDropDownList("Format", d["format"], true);
      $("#Chaîne").jqxDropDownList('setContent', 'Chaîne(s)');
      $("#MMDayPart").jqxDropDownList('setContent', 'DaypartMM(s)');
      $("#Format").jqxDropDownList('setContent', 'Format(s)');
      $("#concurrenceselector").jqxDropDownList('setContent', 'Sélection des concurrents');
      //datepick settings
      var today = new Date(),
        sixmonthsago = new Date();
      sixmonthsago.setDate(today.getDate() - 180);
      codeCleaner.initialSideBarRangeDatePicker("datepicker1", false, sixmonthsago, today);

      console.log(getCookie("default_date"));
      if (getCookie("default_date")) {
        $("#datepicker1").jqxDateTimeInput('setRange', getCookie("default_date"), getCookie("default_date"));
        setCookie("default_date", "", 0);
      } else {
        var from = new Date(d["period"]["from"]),
          to = new Date(d["period"]["to"]);
        $("#datepicker1").jqxDateTimeInput('setRange', from, to);
      }
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });

  console.log(getCookie("default_date"));
  if (getCookie("default_date")) {
    var requestData = {
      "client": client_name,
      "dashboard_oneday":true,
    };
    requestData["period"] = {
      "from": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
      "to": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
    };
    console.log("from dashboard");
    console.log(requestData);
    chart.updateChart(requestData, graph_url);
    grid.updateTreeGrid(requestData, table_url);
  } else {
    chart.initialChart(graph_url + "?client=" + client_name);
    grid.initialTreeGrid(table_url + '?client=' + client_name, []);
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