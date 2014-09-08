function CampagneController() {
  var globaltheme = 'bootstrap';
  var client_name = getCookie("mymedia_client_name");
  var codeCleaner = new jqxHelperClass();
  var layout = new LayoutController();
  var grid = new TreeGridController();
  var chart = new ZoomableTimeSeries();
  var comment_url = "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/Campagne_comments.php";
  var filter_url = "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_filtre_default.php";
  var graph_url = "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/hc_graph.php";
  var table_url = "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne.php";
  layout.createLayout();
  $('.client-website').html(client_name);
  $("#jqxwindow").jqxWindow({
    height: 300,
    width: 500,
    theme: 'jqx-windows-custom',
    autoOpen: false,
    isModal: true
  });
  $("#addcomment").click(function() {
    $("#jqxwindow").jqxWindow('open');
  });
  $("#canclecomment").click(function() {
    $("#jqxwindow").jqxWindow('close');
  });
  $("#commitcomment").click(function() {

    var requestData = {
      "client_name": client_name,
      "date": $('#commentdatepicker').jqxDateTimeInput('getDate').getTime(),
      "comment": $("#commentinput").val()
    }
    console.log(requestData);
    $.ajax({
      type: 'POST',
      dataType: 'json',
      scriptCharset: "utf-8",
      data: requestData,
      url: comment_url,
      async: true,
      success: function(d) {
        var requestData = {
          "client": client_name,
          "period": codeCleaner.getDateTimeInputRange("datepicker1"),
          "value1": codeCleaner.getDropDownListItem("valueselector1"),
          "value2": codeCleaner.getDropDownListItem("valueselector2"),
          "value3": codeCleaner.getDropDownListItem("valueselector3"),
          "filter": {
            "chaines": codeCleaner.getDropDownListItems("Chaîne"),
            "format": codeCleaner.getDropDownListItems("Format"),
            "version": codeCleaner.getDropDownListItems("Version")
          }
        };
        console.log(requestData);
        //chart.updateCampagne(requestData, "http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/hc_graph.php");
        chart.updateEvent();
        // console.log("valider");
        // console.log(d);
        //self.data = d;
        //self.createTreeGrid();
      },
      cache: true
    });

    $("#jqxwindow").jqxWindow('close');
  });

  $("#commentdatepicker").jqxDateTimeInput({
    theme: globaltheme,
    formatString: 'F',
    width: '250px',
    height: '25px'
  });
  var source = ["Budget net",
    "Ecran / spot",
    "Chaines",
    "Contact",
    "Affichage Recherche Google",
    "Visites immediates",
    "CPVi",
    "% nouveaux visiteurs immediats",
    "Visites campagne",
    "CPVc",
    "Visites du site",
    "KPI personnalise client",
    "Clic sur Google",
    "CTR",
    "Leads immediats",
    "Ventes immediates",
  ];


  $("#valueselector1").jqxDropDownList({
    theme: globaltheme,
    source: source,
    placeHolder: "1ère valeur à afficher",
    width: '90%',
    height: '25'
  });
  $("#valueselector2").jqxDropDownList({
    theme: globaltheme,
    source: source,
    placeHolder: "2ème valeur à afficher",
    width: '90%',
    height: '25'
  });
  $("#valueselector3").jqxDropDownList({
    theme: globaltheme,
    source: source,
    placeHolder: "3ème valeur à afficher",
    width: '90%',
    height: '25'
  });
  if (getCookie("default_value_1")) {
    $("#valueselector1").jqxDropDownList('selectItem', getCookie("default_value_1"));
    $("#valueselector2").jqxDropDownList('selectItem', getCookie("default_value_2"));
    $("#valueselector3").jqxDropDownList('selectItem', getCookie("default_value_3"));
  } else {
    $("#valueselector1").jqxDropDownList('selectItem', 'CPVi');
    $("#valueselector2").jqxDropDownList('selectItem', 'Visites immediates');
    $("#valueselector3").jqxDropDownList('selectItem', 'Budget net');
  }
  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: filter_url + '?client=' + client_name,
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
      $("#Chaîne").jqxDropDownList('checkAll');
      $("#Version").jqxDropDownList('checkAll');
      $("#Format").jqxDropDownList('checkAll');
      $("#Chaîne").jqxDropDownList('setContent', 'Chaîne(s)');
      $("#Version").jqxDropDownList('setContent', 'Création(s)');
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

  var collapseSetting = [{
    collapsed: false,
    group: 1,
    columns: ["Position", "MMdayPart"]
  }, {
    collapsed: false,
    group: 2,
    columns: ["Budget Brut"]
  }, {
    collapsed: false,
    group: 3,
    columns: ["Status Audience", "CPM", "GRP cible", "Affinité"]
  }, {
    collapsed: false,
    group: 4,
    columns: ["Type Ap", "Emission Avant", "Type Av"]
  }, {
    collapsed: false,
    group: 5,
    columns: ["CTR"]
  }]

  grid.initialTreeGrid(table_url+'?client=' + client_name, collapseSetting);

  if (getCookie("default_value_1") || getCookie("default_date")) {
    var requestData = {
      "client": client_name,
      "value1": codeCleaner.getDropDownListItem("valueselector1"),
      "value2": codeCleaner.getDropDownListItem("valueselector2"),
      "value3": codeCleaner.getDropDownListItem("valueselector3"),
    };
    if (getCookie("default_date")) {
      requestData["period"] = {
        "from": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
        "to": codeCleaner.getDateFormat(new Date(getCookie("default_date"))),
      };
    } else {
      requestData["period"] = codeCleaner.getDateTimeInputRange("datepicker1");
    }
    console.log("from dashboard");
    console.log(requestData);
    chart.updateCampagne(requestData, graph_url);
    setCookie("default_value_1", "", 0);
    setCookie("default_value_2", "", 0);
    setCookie("default_value_3", "", 0);
    //
  } else {
    chart.initialChart(graph_url + "?client=" + client_name);
  }

  $("#Valider").click(function() {
    var requestData = {
      "client": client_name,
      "period": codeCleaner.getDateTimeInputRange("datepicker1"),
      "value1": codeCleaner.getDropDownListItem("valueselector1"),
      "value2": codeCleaner.getDropDownListItem("valueselector2"),
      "value3": codeCleaner.getDropDownListItem("valueselector3"),
      "filter": {
        "chaines": codeCleaner.getDropDownListItems("Chaîne"),
        "format": codeCleaner.getDropDownListItems("Format"),
        "version": codeCleaner.getDropDownListItems("Version")
      }
    };
    console.log(requestData);
    grid.updateTreeGrid(requestData, table_url);
    chart.updateCampagne(requestData, graph_url);
  });

}