function ConcurrenceController() {
    var globaltheme = 'bootstrap';
    var client_name = "EDarling";
    var layout = new LayoutController();
    layout.createLayout();
    var source = [
        "Budget net",
        "Total affichage sur Google",
        "Coût par recherche",
        "CTR",
        "Nombre total de visites immédiates",
        "Coût de la visite immédiate",
        "Nombre total de visites du site",
        "Nombre total de visite campagne ",
        "Coût de la visite campagne",
        "% de nouveaux visiteurs immédiats",
        "Nombre total de leads immédiats",
        "Coût au lead immédiat",
        "Nombre total de ventes immédiates",
        "CPA",
        "CPO",
        "KPI personnalisé client",
        "Nombre total de ventes",
    ];


    $("#datepicker1").jqxDateTimeInput({
        theme:globaltheme,
        width: '90%',
        height: '25px',
        selectionMode: 'range'
    });
$.ajax({
    type: 'GET',
    timeout: 10000,
    dataType: 'json',
    url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence_filters.php?client='+client_name,
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
    grid.initialTreeGrid('http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence.php?client='+client_name,[]);

    // var chart = new BubbleController();
    // chart.createBubbleChart();

    $("#Valider").click(function() {
    var tableData = {
      "client": client_name,
      "period": {
        "from": "",
        "to": ""
      },
      "concurrent":"",
      "filter": {
        "chaines": [],
        "format": [],
        "MMDayPart": []
      }
    };
    var graphData = {
      "client": client_name,
      "period": {
        "from": "",
        "to": ""
      },
    };
    var channel = $("#Chaîne").jqxDropDownList('getCheckedItems');
    var MMDayPart = $("#MMDayPart").jqxDropDownList('getCheckedItems');
    var format = $("#Format").jqxDropDownList('getCheckedItems');
    for (var i = 0; i < channel.length; i++) {
      tableData["filter"]["chaines"].push(channel[i].label);
    };
    for (var i = 0; i < format.length; i++) {
      tableData["filter"]["format"].push(format[i].label);
    };
    for (var i = 0; i < MMDayPart.length; i++) {
      tableData["filter"]["MMDayPart"].push(MMDayPart[i].label);
    };
    var selection = $("#datepicker1").jqxDateTimeInput('getRange');
    if (selection.from != null) {
      tableData["period"]["from"] = selection.from.toLocaleDateString();
      tableData["period"]["to"] = selection.to.toLocaleDateString();
      graphData["period"]["from"] = selection.from.toLocaleDateString();
      graphData["period"]["to"] = selection.to.toLocaleDateString();
    }
    console.log(tableData);

    var concurrents = $("#concurrenceselector").jqxDropDownList('getSelectedItem');
    tableData["concurrent"] = concurrents.label;
    console.log(graphData);
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: tableData,
      url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_concurrence.php',
      async: true,
      success: function(d) {
        grid.updateTreeGrid(d);
      },
      cache: false
    });
    // $.ajax({
    //   type: 'POST',
    //   dataType: 'json',
    //   data: graphData,
    //   url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne_graph_default.php',
    //   async: true,
    //   success: function(d) {
    //     chart.updateChart(d);
    //     console.log(d);
    //   },
    //   cache: false
    // });
  });
}