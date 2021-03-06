function AdministrationController() {
  var globaltheme = 'bootstrap',
    codeCleaner = new jqxHelperClass(),
    client_name = getCookie("mymedia_client_name"),
    layout = new LayoutController(),
    table = new DataTable();
  layout.createBasicLayout("250px");
  table.initializeTable();
  var source =
    [
      "Campagne",
      "Historique",
      "Taux",
      "Concurrence",
    ];
  codeCleaner.initialSideBarDropDownList("valueselector1", source, false);
  $("#valueselector1").jqxDropDownList('selectItem', 'Campagne');

  $("#Valider").click(function() {
    var text = codeCleaner.getDropDownListItem("valueselector1");
    if (text == "Taux" || text == "Concurrence"){
      $('#splitter').jqxSplitter('collapse');
       $('#splitter').jqxSplitter({ showSplitBar: false });
    }else{
      $('#splitter').jqxSplitter('expand');
       $('#splitter').jqxSplitter({ showSplitBar: true });
    }
    $("#pageText").html(text);
    console.log(text);
    table.updateTable(text);
  });
}