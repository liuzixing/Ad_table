function PerformanceController() {
  var globaltheme = 'bootstrap';
  var client_name = "Balsamik";
  var codeCleaner = new jqxHelperClass();
  var layout = new LayoutController();
  layout.createLayout();

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
  $("#datepicker2").jqxDateTimeInput({
    theme: globaltheme,
    width: '90%',
    height: '25px',
    disabled: true,
    selectionMode: 'range'
  });
  var xaxisSelectorSource = ["GRPRef",
    "GRPcible",
    "TTRi",
    "CPM",
    "CPVI",
    // "Cout de visite immediate",
    "CPLi (Cout par lead immediat)",
    "CPOi (Cost per order instant)",
    "% Nouveaux visiteurs i",
    "% Bounce rate (v3)"
  ];
  $("#xaxisselector").jqxDropDownList({
    theme: globaltheme,
    source: xaxisSelectorSource,
    placeHolder: "Abscisses (Taux)",
    width: '90%',
    height: '25'
  });
  var yaxisSelectorSource = ["Total nombre de spots",
    "Total de contacts",
    "Budget brut",
    "Budget net",
    "Total de visites immediates",
    "Total leads immediats",
  ];
  $("#yaxisselector").jqxDropDownList({
    theme: globaltheme,
    source: yaxisSelectorSource,
    placeHolder: "Ordonnées (Volume)",
    width: '90%',
    height: '25'
  });
  var regroupmentSource = ["Format",
    "Création",
    "Jour > DayPart + MMDayPart > Ecran (Jour,DayPart)",
    "DayPart + MMDayPart > Ecran (DayPart)",
    "Chaine(s) > DayPart (Chaine) + MMDayPart(Chaine) > Ecran (Chaine)",
    "Jour,Chaine > DayPart + MMDayPart (Jour,Chaine) > Ecran",
    "Chaine, Type de jour > DayPart + MMDayPart (Chaine,Type de jour) > Ecran",
    "Jour,Chaine + Jour,Chaine,Ecran",
  ];
  $("#regroupement").jqxDropDownList({
    theme: globaltheme,
    source: regroupmentSource,
    placeHolder: "Regroupement",
    width: '90%',
    height: '25'
  });

  $("#xaxisselector").jqxDropDownList('selectItem', 'CPVI');
  $("#yaxisselector").jqxDropDownList('selectItem', 'Budget net');
  $("#regroupement").jqxDropDownList('selectItem', 'Chaine(s) > DayPart (Chaine) + MMDayPart(Chaine) > Ecran (Chaine)');
  //filters components

  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_filter_default.php?client=' + client_name,
    async: true,
    success: function(d) {
      //console.log(d);
      $("#Chaîne").jqxDropDownList({
        theme: globaltheme,
        source: d["channel"],
        placeHolder: "Chaîne",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#Version").jqxDropDownList({
        theme: globaltheme,
        source: d["version"],
        placeHolder: "Version pub / créa",
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
      $("#Catégorie").jqxDropDownList({
        theme: globaltheme,
        source: d["category"],
        placeHolder: "Catégorie",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#MMDaypart").jqxDropDownList({
        theme: globaltheme,
        source: d["MMDayPart"],
        placeHolder: "MMDaypart",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#Dayofweek").jqxDropDownList({
        theme: globaltheme,
        source: d["day"],
        placeHolder: "Dayofweek",
        checkboxes: true,
        width: '90%',
        height: '25'
      });
      $("#Chaîne").jqxDropDownList('checkAll');
      $("#Version").jqxDropDownList('checkAll');
      $("#Catégorie").jqxDropDownList('checkAll');
      $("#Format").jqxDropDownList('checkAll');
      $("#MMDaypart").jqxDropDownList('checkAll');
      $("#Dayofweek").jqxDropDownList('checkAll');
      //datepick settings

      $("#datepicker1").jqxDateTimeInput({
        theme: globaltheme,
        width: '90%',
        height: '25px',
        selectionMode: 'range'
      });
      var from = new Date(d["period"]["from"]);
      var to = new Date(d["period"]["to"]);
      $("#datepicker1").jqxDateTimeInput('setRange', from, to);
      $("#datepicker2").jqxDateTimeInput('setRange', from, to);
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });

  var grid = new TreeGridController();
  grid.initialTreeGrid("http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_table.php?client=" + client_name, []);
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
    grid.updateTreeGrid(requestData, 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_table.php');
    chart.updateChart(requestData, codeCleaner.getDropDownListItem("regroupement"), client_name);
  });
}