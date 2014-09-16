function CampagneController() {
  var
    client_name = getCookie("mymedia_client_name"),
    codeCleaner = new jqxHelperClass(),
    layout = new LayoutController(),
    grid = new TreeGridController(),
    chart = new ZoomableTimeSeries(),
    comment_url = "http://tyco.mymedia.fr/api/Campagne_comments.php",
    filter_url = "http://tyco.mymedia.fr/api/api_filtre_default.php",
    graph_url = "http://tyco.mymedia.fr/api/hc_graph.php",
    table_url = "http://tyco.mymedia.fr/api/api_campagne.php";
  layout.createLayout();

  $('.client-website').html(client_name);
  //initial comment windows componenets
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
    var current_date = codeCleaner.getDateTimeInputRange("datepicker1"),
    x_date = $('#commentdatepicker').jqxDateTimeInput('getDate');
    x_date.setHours(0,0,0,0);
    x_date = x_date.getTime();
    if (current_date.from == current_date.to) {
      chart.updateOneDayEvent(x_date, $("#commentinput").val());
    }
    else{
      console.log(x_date);
      chart.updateEvent(x_date);
    }
    console.log(requestData);
    $.ajax({
      type: 'POST',
      dataType: 'json',
      scriptCharset: "utf-8",
      data: requestData,
      url: comment_url,
      async: true,
      success: function() {},
      cache: true
    });

    $("#jqxwindow").jqxWindow('close');
  });

  $("#commentdatepicker").jqxDateTimeInput({
    theme: "bootstrap",
    formatString: "dd-MM-yyyy HH:mm:ss",
    // formatString: 'F',
    width: '300px',
    height: '25px'
  });

  //initial selectors
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
  codeCleaner.initialSideBarDropDownList("valueselector1", source, false);
  codeCleaner.initialSideBarDropDownList("valueselector2", source, false);
  codeCleaner.initialSideBarDropDownList("valueselector3", source, false);
  if (getCookie("default_value_1")) {
    $("#valueselector1").jqxDropDownList('selectItem', getCookie("default_value_1"));
    $("#valueselector2").jqxDropDownList('selectItem', getCookie("default_value_2"));
    $("#valueselector3").jqxDropDownList('selectItem', getCookie("default_value_3"));
  } else {
    $("#valueselector1").jqxDropDownList('selectItem', 'CPVi');
    $("#valueselector2").jqxDropDownList('selectItem', 'Visites du site');
    $("#valueselector3").jqxDropDownList('selectItem', 'Budget net');
  }
  //get filter data
  $.ajax({
    type: 'GET',
    timeout: 10000,
    scriptCharset: "utf-8",
    dataType: 'json',
    url: filter_url + '?client=' + client_name,
    async: true,
    success: function(d) {
      //console.log(d);
      codeCleaner.initialSideBarDropDownList("Chaîne", d["channel"], true);
      codeCleaner.initialSideBarDropDownList("Version", d["version"], true);
      codeCleaner.initialSideBarDropDownList("Format", d["format"], true);
      $("#Chaîne").jqxDropDownList('setContent', 'Chaîne(s)');
      $("#Version").jqxDropDownList('setContent', 'Création(s)');
      $("#Format").jqxDropDownList('setContent', 'Format(s)');
      //datepick settings
      var today = new Date(),
        sixmonthsago = new Date();
      sixmonthsago.setDate(today.getDate() - 180);
      codeCleaner.initialSideBarRangeDatePicker("datepicker1", false, sixmonthsago, today);
      console.log(getCookie("default_date"));
      if (getCookie("default_date")) {
        $("#datepicker1").jqxDateTimeInput('setRange', getCookie("default_date"), getCookie("default_date"));
        $('#commentdatepicker ').jqxDateTimeInput('setDate', getCookie("default_date"));
        setCookie("default_date", "", 0);
      } else {
        var from = new Date(d["period"]["from"]),
          to = new Date(d["period"]["to"]);
        $('#commentdatepicker ').jqxDateTimeInput('setDate', to);
        $("#datepicker1").jqxDateTimeInput('setRange', from, to);
      }
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });
//collapseSetting only for the campagne
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
      console.log("x");
      //requestData["period"] = codeCleaner.getDateTimeInputRange("datepicker1");
    }
    console.log("from dashboard");
    console.log(requestData);

    chart.updateCampagne(requestData, graph_url);
    // grid.collapseSetting = collapseSetting;
    // grid.updateTreeGrid(requestData, table_url);
    //delete cookies
    setCookie("default_value_1", "", 0);
    setCookie("default_value_2", "", 0);
    setCookie("default_value_3", "", 0);
  } else {
    chart.initialChart(graph_url + "?client=" + client_name, true);
  }
    grid.initialTreeGrid(table_url + '?client=' + client_name, collapseSetting);

  $("#Valider").click(function() {
    var period = codeCleaner.getDateTimeInputRange("datepicker1");
    $('#commentdatepicker ').jqxDateTimeInput('setDate', $("#datepicker1").jqxDateTimeInput('getRange').to);
    var requestData = {
      "client": client_name,
      "period": period,
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