function AdministrationController() {
  var globaltheme = 'bootstrap';
  var client_name = "Balsamik";
  var codeCleaner = new jqxHelperClass();
  var layout = new LayoutController();
  layout.createLayout();
  var source = ["Budget net",
    "Ecran / spot",
    "Chaines",
    "Contact",
    "Affichage Recherche Google",
    "Visites immédiates",
    "CPVI",
    "% nouveaux visiteurs immédiats",
    "Visites campagne",
    "CPVc",
    "Visites du site",
    "KPI personnalisé client",
    "Clic sur Google",
    "CTR",
    "Leads immédiats",
    "Ventes immédiates",
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
  $("#valueselector1").jqxDropDownList('selectItem', 'CPVI');
  $("#valueselector2").jqxDropDownList('selectItem', 'Visites immédiates');
  $("#valueselector3").jqxDropDownList('selectItem', 'Budget net');
  // $.ajax({
  //   type: 'GET',
  //   timeout: 10000,
  //   scriptCharset: "utf-8",
  //   dataType: 'json',
  //   url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_filtre_default.php?client='+client_name,
  //   async: true,
  //   success: function(d) {
  //     //console.log(d);
  //     $("#Chaîne").jqxDropDownList({
  //       theme: globaltheme,
  //       source: d["channel"],
  //       placeHolder: "Chaîne",
  //       checkboxes: true,
  //       width: '90%',
  //       height: '25'
  //     });
  //     $("#Version").jqxDropDownList({
  //       theme: globaltheme,
  //       source: d["version"],
  //       placeHolder: "Version pub / créa",
  //       checkboxes: true,
  //       width: '90%',
  //       height: '25'
  //     });
  //     $("#Format").jqxDropDownList({
  //       theme: globaltheme,
  //       source: d["format"],
  //       placeHolder: "Format",
  //       checkboxes: true,
  //       width: '90%',
  //       height: '25'
  //     });
  //     $("#Chaîne").jqxDropDownList('checkAll');
  //     $("#Version").jqxDropDownList('checkAll');
  //     $("#Format").jqxDropDownList('checkAll');

  //     //datepick settings
  //     var today = new Date();
  //     var sixmonthsago = new Date();
  //     sixmonthsago.setDate(today.getDate() - 180);
  //     $("#datepicker1").jqxDateTimeInput({
  //       theme: globaltheme,
  //       width: '90%',
  //       height: '25px',
  //       min: sixmonthsago,
  //       max: today,
  //       selectionMode: 'range'
  //     });
  //     var from = new Date(d["period"]["from"]);
  //     var to = new Date(d["period"]["to"]);
  //     $("#datepicker1").jqxDateTimeInput('setRange', from, to);
  //   },
  //   failure: function(err) {
  //     //console.log("Error");
  //   },
  //   cache: true
  // });

// var collapseSetting  = [{
//         collapsed: false,
//         group: 1,
//         columns: ["Position", "MMdayPart"]
//     }, {
//         collapsed: false,
//         group: 2,
//         columns: ["Budget Brut"]
//     }, {
//         collapsed: false,
//         group: 3,
//         columns: ["Status Audience", "CPM", "GRP cible", "Affinité"]
//     }, {
//         collapsed: false,
//         group: 4,
//         columns: ["Type Ap", "Emission Avant", "Type Av"]
//     }, {
//         collapsed: false,
//         group: 5,
//         columns: ["CTR"]
//     }]
//   var grid = new TreeGridController();
//   grid.initialTreeGrid('http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne.php?client='+client_name,collapseSetting);
// var chart = new ZoomableTimeSeries();
//      chart.initialChart("http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/hc_graph.php?client="+client_name);

  // $("#Valider").click(function() {
  //   var requestData = {
  //     "client": client_name,
  //     "period": codeCleaner.getDateTimeInputRange("datepicker1"),
  //     "value1": codeCleaner.getDropDownListItem("valueselector1"),
  //     "value2": codeCleaner.getDropDownListItem("valueselector2"),
  //     "value3": codeCleaner.getDropDownListItem("valueselector3"),
  //     "filter": {
  //       "chaines": codeCleaner.getDropDownListItems("Chaîne"),
  //       "format": codeCleaner.getDropDownListItems("Format"),
  //       "version": codeCleaner.getDropDownListItems("Version")
  //     }
  //   };
    //console.log(requestData);
    // grid.updateTreeGrid(requestData,'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne.php');
    // chart.updateCampagne(requestData,"http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/hc_graph.php");
  //});

}