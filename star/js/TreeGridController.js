function TreeGridController() {
  var data = [];
  //0 :columnName
  //1:dataFields
  //2:cpvi data
  //3:column filter list source
  //4:colour table
  //5:length filter list source
  //6:version filter list source

  var self = this;
  var source = {};
  var dataAdapter = {};
  this.collapseSetting = [];

  this.setGroupTitleStyle = function() {
    for (var i = 0; i < self.collapseSetting.length; i++) {
      if (self.collapseSetting[i]["collapsed"]) {
        $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").html("<div style='overflow: hidden; text-overflow: ellipsis; text-align: center; margin-left: 4px; margin-right: 4px; margin-bottom: 8px; margin-top: 8px;'><span style='text-overflow: ellipsis; cursor: default;'>" + $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").text() + "</span>   <img src='../img/blank.png' class='sprite  sprite-plus_table' /></div>");
      } else {
        $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").html("<div style='overflow: hidden; text-overflow: ellipsis; text-align: center; margin-left: 4px; margin-right: 4px; margin-bottom: 8px; margin-top: 8px;'><span style='text-overflow: ellipsis; cursor: default;'>" + $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").text() + "</span>   <img src='../img/blank.png' class='sprite  sprite-minus_table' /></div>");
      }
    }
  }

  this.createTreeGrid = function() {
     // console.log(self.data);
    self.source = {
      datatype: "json",
      datafields: self.data[1],
      hierarchy: {
        root: "children"
      },
      localdata: self.data[2],
      id: "id"
    };
    self.dataAdapter = new $.jqx.dataAdapter(self.source, {
      loadComplete: function() {}
    });
    //console.log(self.source);
    self.destroyLoadingMessage();
    // create jqxTreeGrid.
    $("#treeGrid").jqxTreeGrid({
      source: self.dataAdapter,
      selectionMode: 'none',
      sortable: false,
      columnsHeight: 50,
      pageable: true,
      width: "100%",
      enablehover: true,
      altRows: true,
      autoRowHeight: true,
      theme: 'mymedia-table',
      pageSize: 15,
      // pagerPosition: 'top',
      columnsResize: true,
      ready: function() {
        //$("#treeGrid").jqxTreeGrid('expandRow', '3321');
      },
      columns: self.data[0],
      columnGroups: self.data[3]
    });
    console.log("creating treeGrid");
    self.attachColumnGroupClickEvent();
  }
  this.groupEcranObserver = function(index) {
    $("#treeGrid").jqxTreeGrid('beginUpdate');
    if (self.collapseSetting[index]["collapsed"]) {
      self.collapseSetting[index]["collapsed"] = false;
      for (var i = 0; i < self.collapseSetting[index]["columns"].length; i++) {
        $("#treeGrid").jqxTreeGrid('showColumn', self.collapseSetting[index]["columns"][i]);
      }
    } else {
      self.collapseSetting[index]["collapsed"] = true;
      for (var i = 0; i < self.collapseSetting[index]["columns"].length; i++) {
        $("#treeGrid").jqxTreeGrid('hideColumn', self.collapseSetting[index]["columns"][i]);
      }
    }
    $("#treeGrid").jqxTreeGrid('endUpdate');
    self.attachColumnGroupClickEvent();

  }

  this.attachColumnGroupClickEvent = function() {
    if(self.collapseSetting.length == 0){
       return;
    }
    self.setGroupTitleStyle();
    $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[0]["group"] + ")").click(function() {
      self.groupEcranObserver(0);
    });
    $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[1]["group"] + ")").click(function() {
      self.groupEcranObserver(1);
    });
    $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[2]["group"] + ")").click(function() {
      self.groupEcranObserver(2);
    });
    $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[3]["group"] + ")").click(function() {
      self.groupEcranObserver(3);
    });
    $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[4]["group"] + ")").click(function() {
      self.groupEcranObserver(4);
    });

  }

  this.createExportButton = function() {
    //create data exporting UI
    $("#csvExport").jqxButton({});
    $("#csvExport").click(function() {
      $("#treeGrid").jqxTreeGrid('exportData', 'csv');
    });
  }

  this.createLoadingMessage = function() {
    $("#treeGrid").html("<img src='../img/ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#treeGrid").empty();
  }
  this.updateTreeGrid = function(requestData, client_url) {
    $("#treeGrid").jqxTreeGrid('destroy');
    self.data = null;
    self.source = null;
    self.dataAdapter = null;

    $('.table-container').empty();
    $('.table-container').html("<div id='treeGrid'></div>");
    //self.data = d.slice(0);
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: requestData,
      url: client_url,
      async: true,
      success: function(d) {
        self.data = d;
        //$("#treeGrid").jqxTreeGrid('clear');
        console.log("valider");
        console.log(d);
        self.createTreeGrid();
      },
      cache: true
    });
    //self.data = d;
    // self.source.localData = self.data[2];
    // self.dataAdapter = new $.jqx.dataAdapter(self.source, {
    //   loadComplete: function() {}
    // });
    // // update data in  jqxTreeGrid.
    // $("#treeGrid").jqxTreeGrid('beginUpdate');
    // $("#treeGrid").jqxTreeGrid('updateBoundData');
    // $("#treeGrid").jqxTreeGrid('endUpdate');
    // self.attachColumnGroupClickEvent();

    //$("#treeGrid").jqxTreeGrid('destroy');

  }
  this.initialTreeGrid = function(client_url, collapseSetting) {
    self.collapseSetting = collapseSetting;
    self.createExportButton();
    self.createLoadingMessage();
    $.ajax({
      type: 'GET',
      timeout: 20000,
      dataType: 'json',
      url: client_url,
      async: true,
      success: function(d) {

        self.data =d;
        //console.log(d);
        self.createTreeGrid();
      },
      failure: function(err) {
        console.log("Error");
      },
      cache: true
    });
  }
}