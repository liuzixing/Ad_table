function PerformanceController() {
  var globaltheme = 'bootstrap';
  var client_name = "Balsamik";
  var layout = new LayoutController();
  layout.createLayout();

  // $("#datepicker1").jqxDateTimeInput({
  //     theme: globaltheme,
  //     width: '90%',
  //     height: '25px',
  //     selectionMode: 'range'
  // });
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
    "Cout de visite immédiate",
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
    "Total de visites immédiates",
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
    "Chaine,Jour > DayPart + MM (Chaine,Jour) > Ecran",
    "Chaine, Type de jour > DayPart + MM (Chaine,Type de jour) > Ecran",
    "Chaine,Ecran,Jour + Chaine,Jour",
  ];
  $("#regroupement").jqxDropDownList({
    theme: globaltheme,
    source: regroupmentSource,
    placeHolder: "Regroupement",
    width: '90%',
    height: '25'
  });
  $("#previous").click(function(e){
    alert("I'm going back");
  });
  //filters components

  $.ajax({
    type: 'GET',
    timeout: 10000,
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
      // var today = new Date();
      // var sixmonthsago = new Date();
      // sixmonthsago.setDate(today.getDate() - 180);
      $("#datepicker1").jqxDateTimeInput({
        theme: globaltheme,
        width: '90%',
        height: '25px',
        // min: sixmonthsago,
        // max: today,
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
  chart.initialChart("http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_data.php?client=" + client_name);

  $("#Valider").click(function() {
    var tableData = {
      "client": client_name,
      "period1": {
        "from": "",
        "to": ""
      },
      "period2": {
        "from": "",
        "to": ""
      },
      "comparaison": "",
      "filter": {}
    };
    var graphData = {
      "client": client_name,
      "period1": {
        "from": "",
        "to": ""
      },
      "period2": {
        "from": "",
        "to": ""
      },
      "comparaison": "",
      "xaxis": "",
      "yaxis": "",
      "regroupement": "",
      "filter": {}
    };
    tableData["comparaison"] = $("#Comparaison").is(":checked");
    graphData["comparaison"] = $("#Comparaison").is(":checked");
    var channel = $("#Chaîne").jqxDropDownList('getCheckedItems');
    var version = $("#Version").jqxDropDownList('getCheckedItems');
    var format = $("#Format").jqxDropDownList('getCheckedItems');
    var MMDaypart = $("#MMDaypart").jqxDropDownList('getCheckedItems');
    var Dayofweek = $("#Dayofweek").jqxDropDownList('getCheckedItems');
    var Categorie = $("#Catégorie").jqxDropDownList('getCheckedItems');
    var filter = {
      "channel": [],
      "format": [],
      "version": [],
      "day": [],
      "MMDayPart": [],
      "category": [],
      "Optimisation": ""
    };
    for (var i = 0; i < channel.length; i++) {
      filter["channel"].push(channel[i].label);
    };
    for (var i = 0; i < format.length; i++) {
      filter["format"].push(format[i].label);
    };
    for (var i = 0; i < version.length; i++) {
      filter["version"].push(version[i].label);
    };
    for (var i = 0; i < Dayofweek.length; i++) {
      filter["day"].push(Dayofweek[i].label);
    };
    for (var i = 0; i < Categorie.length; i++) {
      filter["category"].push(Categorie[i].label);
    };
    for (var i = 0; i < MMDaypart.length; i++) {
      filter["MMDayPart"].push(MMDaypart[i].label);
    };
    filter["Optimisation"] = $("#Optimisation").is(":checked");

    tableData["filter"] = filter;
    graphData["filter"] = filter;

    var regroupement = $("#regroupement").jqxDropDownList('getSelectedItem');
    var yaxis = $("#yaxisselector").jqxDropDownList('getSelectedItem');
    var xaxis = $("#xaxisselector").jqxDropDownList('getSelectedItem');
    graphData["regroupement"] = regroupement.label.split(" > ")[0];
    graphData["xaxis"] = xaxis.label;
    graphData["yaxis"] = yaxis.label;
    tableData["regroupement"] = regroupement.label.split(" > ")[0];
    tableData["xaxis"] = xaxis.label;
    tableData["yaxis"] = yaxis.label;
    var selection = $("#datepicker1").jqxDateTimeInput('getRange');
    if (selection.from != null) {
      tableData["period1"]["from"] = selection.from.toLocaleDateString();
      tableData["period1"]["to"] = selection.to.toLocaleDateString();
      graphData["period1"]["from"] = selection.from.toLocaleDateString();
      graphData["period1"]["to"] = selection.to.toLocaleDateString();
    }
    selection = $("#datepicker2").jqxDateTimeInput('getRange');
    if (selection.from != null && tableData["comparaison"] == true) {
      tableData["period2"]["from"] = selection.from.toLocaleDateString();
      tableData["period2"]["to"] = selection.to.toLocaleDateString();
      graphData["period2"]["from"] = selection.from.toLocaleDateString();
      graphData["period2"]["to"] = selection.to.toLocaleDateString();
    }
    console.log(tableData);
    grid.updateTreeGrid(tableData,'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_table.php');
    //console.log(tableData);
    // $.ajax({
    //   type: 'POST',
    //   dataType: 'json',
    //   data: tableData,
    //   url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_performance.php',
    //   async: true,
    //   success: function(d) {
    //     //grid.updateGrid(d);
    //     console.log(d);
    //   },
    //   cache: false
    // });
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: graphData,
      url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/performance_data.php',
      async: true,
      success: function(d) {

        //console.log(d);
        if (d.length>0) {
          chart.updateChart(d);
        } else {
          chart.destroyLoadingMessage();
        }
        //grid.updateGrid(d);
      },
      cache: false
    });
   });

}