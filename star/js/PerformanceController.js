function PerformanceController() {
  var client_name = getCookie("mymedia_client_name"),
    codeCleaner = new jqxHelperClass(),
    layout = new LayoutController(),
    filter_url = "http://tyco.mymedia.fr/api/api_performance_filters.php",
    graph_url = "http://tyco.mymedia.fr/api/api_performance_graphe.php",
    table_url = "http://tyco.mymedia.fr/api/api_performance_table.php";
  //"http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_data.php";

  layout.createLayout();

  $('.client-website').html(client_name);

  $("#Comparaison").change(function() {
    if ($(this).is(":checked")) {
      $("#datepicker2").jqxDateTimeInput({
        disabled: false
      });
    } else {
      $("#datepicker2").jqxDateTimeInput({
        disabled: true
      });
    }
  });

  codeCleaner.initialSideBarRangeDatePicker("datepicker2", true);

  var xaxisSelectorSource = ["GRPRef",
    "GRPcible",
    "TTRi",
    "CPM",
    "CPVi",
    "CPLi (Cout par lead immediat)",
    "CPOi (Cost per order instant)",
    "% Nouveaux visiteurs i",
    "% Bounce rate (v3)"
  ];
  var yaxisSelectorSource = ["Total nombre de spots",
    "Total de contacts",
    "Budget brut",
    "Budget net",
    "Total de visites immediates",
    "Total leads immediats",
  ];
  var regroupmentSource = ["Format",
    "Création",
    "Jour > DayPart + MMDayPart > Ecran (Jour,DayPart)",
    "DayPart + MMDayPart > Ecran (DayPart)",
    "Chaine(s) > DayPart (Chaine) + MMDayPart(Chaine) > Ecran (Chaine)",
    "Jour,Chaine > DayPart + MMDayPart (Jour,Chaine) > Ecran",
    "Chaine, Type de jour > DayPart + MMDayPart (Chaine,Type de jour) > Ecran",
    "Jour,Chaine + Jour,Chaine,Ecran",
  ];
  codeCleaner.initialSideBarDropDownList("xaxisselector", xaxisSelectorSource, false);
  codeCleaner.initialSideBarDropDownList("yaxisselector", yaxisSelectorSource, false);
  codeCleaner.initialSideBarDropDownList("regroupement", regroupmentSource, false);
  $("#xaxisselector").jqxDropDownList('selectItem', 'CPVi');
  $("#yaxisselector").jqxDropDownList('selectItem', 'Budget net');
  $("#regroupement").jqxDropDownList('selectItem', 'Chaine(s) > DayPart (Chaine) + MMDayPart(Chaine) > Ecran (Chaine)');
  //filters components
  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: filter_url + '?client=' + client_name,
    async: true,
    success: function(d) {
      codeCleaner.initialSideBarDropDownList("Chaîne", d["channel"], true);
      codeCleaner.initialSideBarDropDownList("Version", d["version"], true);
      codeCleaner.initialSideBarDropDownList("Catégorie", d["category"], true);
      codeCleaner.initialSideBarDropDownList("Format", d["format"], true);
      codeCleaner.initialSideBarDropDownList("MMDaypart", d["MMDayPart"], true);
      codeCleaner.initialSideBarDropDownList("Dayofweek", d["day"], true);

      $("#Chaîne").jqxDropDownList('setContent', 'Chaîne(s)');
      $("#Version").jqxDropDownList('setContent', 'Version(s) pub / créa');
      $("#Catégorie").jqxDropDownList('setContent', 'Catégorie(s) d’émission');
      $("#Format").jqxDropDownList('setContent', 'Format(s)');
      $("#MMDaypart").jqxDropDownList('setContent', 'Daypart/MM');
      $("#Dayofweek").jqxDropDownList('setContent', 'Dayofweek/typeofday');

      //datepick default settings
      codeCleaner.initialSideBarRangeDatePicker("datepicker1", false);
      var from = new Date(d["period"]["from"]),
        to = new Date(d["period"]["to"]);
      $("#datepicker1").jqxDateTimeInput('setRange', from, to);
      $("#datepicker2").jqxDateTimeInput('setRange', from, to);
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });

  var grid = new TreeGridController();
  grid.initialTreeGrid(table_url + "?client=" + client_name, []);
  var chart = new BubbleController();
  chart.initialChart(client_name);
  $("#previous").click(function(e) {
    chart.goBack();
  });
  $("#Valider").click(function() {
    var requestData = {
      "client": client_name,
      "period1": codeCleaner.getDateTimeInputRange("datepicker1"),
      "period2": {},
      "comparaison": $("#Comparaison").is(":checked"),
      "xaxis": codeCleaner.getDropDownListItem("xaxisselector"),
      "yaxis": codeCleaner.getDropDownListItem("yaxisselector"),
      "regroupement": codeCleaner.getDropDownListItem("regroupement").split(" > ")[0],
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
    if (requestData["comparaison"] == true) {
      requestData["period2"] = codeCleaner.getDateTimeInputRange("datepicker2");
    }
    // console.log(requestData);
    grid.updateTreeGrid(requestData, table_url);
    chart.updateChart(requestData, codeCleaner.getDropDownListItem("regroupement"), client_name);
  });
}