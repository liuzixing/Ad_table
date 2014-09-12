function DataTable() {
  var self = this,
    datafields, columns;
  this.cellData = [];
  this.createCampagneData = function() {
    for (var i = 0; i < 20; i++) {
      self.cellData.push({
        date_start: "18-09-2014",
        date_end: "18-09-2014"
      });
    }
    self.datafields = [{
      name: 'date_start',
      type: 'string'
    }, {
      name: 'date_end',
      type: 'string'
    }];
    self.columns = [{
      text: 'Date de début',
      datafield: 'date_start',
      align: "center",
      cellsAlign: "center",
      width: "50%"
    }, {
      text: 'Date de fin',
      datafield: 'date_end',
      align: "center",
      cellsAlign: "center",
      width: "50%"
    }];
  }
  this.createHistoriqueData = function() {
    console.log("generate Historique  Data");
    self.createCampagneData();
  }
  this.createTauxData = function() {
    console.log("generate Taux  Data");
    for (var i = 0; i < 20; i++) {
      self.cellData.push({
        date_start: "18-09-2014",
        date_end: "18-09-2014",
        channel: "M6",
        rate: i,
      });
    }
    self.datafields = [{
      name: 'date_start',
      type: 'string'
    }, {
      name: 'date_end',
      type: 'string'
    }, {
      name: 'channel',
      type: 'string'
    }, {
      name: 'rate',
      type: 'string'
    }];
    self.columns = [{
      text: 'Date de début',
      datafield: 'date_start',
      align: "center",
      cellsAlign: "center",
      width: "25%"
    }, {
      text: 'Date de fin',
      datafield: 'date_end',
      align: "center",
      cellsAlign: "center",
      width: "25%"
    }, {
      text: 'Chaine',
      datafield: 'channel',
      align: "center",
      cellsAlign: "center",
      width: "25%"
    }, {
      text: 'Taux',
      datafield: 'rate',
      align: "center",
      cellsAlign: "center",
      width: "25%"
    }];
  }
  this.createConcurrenceData = function() {
    console.log("generate Concurrence  Data");

    for (var i = 0; i < 20; i++) {
      self.cellData.push({
        Concurrence: "Balsamik"
      });
    }
    self.datafields = [{
      name: 'Concurrence',
      type: 'string'
    }];
    self.columns = [{
      text: 'Concurrence',
      datafield: 'Concurrence',
      align: "center",
      cellsAlign: "center",
      width: "100%"
    }];
  }
  this.clearData = function() {
    self.cellData = null;
    self.datafields = null;
    self.columns = null;
    self.cellData = [];
  }
  this.create = function() {
    console.log("creating table");
    self.source = {
      localdata: self.cellData,
      datatype: "json",
      datafields: self.datafields,
      addRow: function(rowID, rowData, position, commit) {
        // synchronize with the server - send insert command
        // call commit with parameter true if the synchronization with the server is successful
        // and with parameter false if the synchronization failed.
        // you can pass additional argument to the commit callback which represents the new ID if it is generated from a DB.
        commit(true);
      },
      updateRow: function(rowID, rowData, commit) {
        // synchronize with the server - send update command
        // call commit with parameter true if the synchronization with the server is successful
        // and with parameter false if the synchronization failed.
        commit(true);
      },
      deleterow: function(rowid, commit) {
        // if (confirm("Etes vous sur?") == true) {
        commit(true);
        //}
      }
    };
    self.dataAdapter = new $.jqx.dataAdapter(self.source);
    self.destroyLoadingMessage();
    console.log(self.dataAdapter);
    // initialize jqxGrid
    $("#table").jqxDataTable({
      width: "100%",
      source: self.dataAdapter,
      showtoolbar: true,
      theme: 'mymedia-table',
      rendertoolbar: function(toolbar) {
        var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
        var buttonTemplate = "<div style='float: left; padding: 3px; margin: 2px;'><div style='margin: 4px; width: 16px; height: 16px;'></div></div>";
        var addButton = $(buttonTemplate);
        var editButton = $(buttonTemplate);
        var deleteButton = $(buttonTemplate);
        var cancelButton = $(buttonTemplate);
        var updateButton = $(buttonTemplate);
        container.append(addButton);
        container.append(editButton);
        container.append(deleteButton);
        container.append(cancelButton);
        container.append(updateButton);
        toolbar.append(container);
        addButton.jqxButton({
          cursor: "pointer",
          enableDefault: false,
          height: 25,
          width: 25
        });
        addButton.find('div:first').addClass('jqx-icon-plus');
        addButton.jqxTooltip({
          position: 'bottom',
          content: "Ajouter"
        });
        editButton.jqxButton({
          cursor: "pointer",
          disabled: true,
          enableDefault: false,
          height: 25,
          width: 25
        });
        editButton.find('div:first').addClass('jqx-icon-edit');
        editButton.jqxTooltip({
          position: 'bottom',
          content: "Edit"
        });
        deleteButton.jqxButton({
          cursor: "pointer",
          disabled: true,
          enableDefault: false,
          height: 25,
          width: 25
        });
        deleteButton.find('div:first').addClass('jqx-icon-delete');
        deleteButton.jqxTooltip({
          position: 'bottom',
          content: "Supprimer"
        });
        updateButton.jqxButton({
          cursor: "pointer",
          disabled: true,
          enableDefault: false,
          height: 25,
          width: 25
        });
        updateButton.find('div:first').addClass('jqx-icon-save');
        updateButton.jqxTooltip({
          position: 'bottom',
          content: "Save Changes"
        });
        cancelButton.jqxButton({
          cursor: "pointer",
          disabled: true,
          enableDefault: false,
          height: 25,
          width: 25
        });
        cancelButton.find('div:first').addClass('jqx-icon-cancel');
        cancelButton.jqxTooltip({
          position: 'bottom',
          content: "Cancel"
        });
        var updateButtons = function(action) {
          switch (action) {
            case "Select":
              addButton.jqxButton({
                disabled: false
              });
              deleteButton.jqxButton({
                disabled: false
              });
              editButton.jqxButton({
                disabled: false
              });
              cancelButton.jqxButton({
                disabled: true
              });
              updateButton.jqxButton({
                disabled: true
              });
              break;
            case "Unselect":
              addButton.jqxButton({
                disabled: false
              });
              deleteButton.jqxButton({
                disabled: true
              });
              editButton.jqxButton({
                disabled: true
              });
              cancelButton.jqxButton({
                disabled: true
              });
              updateButton.jqxButton({
                disabled: true
              });
              break;
            case "Edit":
              addButton.jqxButton({
                disabled: true
              });
              deleteButton.jqxButton({
                disabled: true
              });
              editButton.jqxButton({
                disabled: true
              });
              cancelButton.jqxButton({
                disabled: false
              });
              updateButton.jqxButton({
                disabled: false
              });
              break;
            case "End Edit":
              addButton.jqxButton({
                disabled: false
              });
              deleteButton.jqxButton({
                disabled: false
              });
              editButton.jqxButton({
                disabled: false
              });
              cancelButton.jqxButton({
                disabled: true
              });
              updateButton.jqxButton({
                disabled: true
              });
              break;
          }
        }
        var rowIndex = null;
        $("#table").on('rowSelect', function(event) {
          var args = event.args;
          rowIndex = args.index;
          updateButtons('Select');
        });
        $("#table").on('rowUnselect', function(event) {
          updateButtons('Unselect');
        });
        $("#table").on('rowEndEdit', function(event) {
          updateButtons('End Edit');
        });
        $("#table").on('rowBeginEdit', function(event) {
          updateButtons('Edit');
        });
        addButton.click(function(event) {
          if (!addButton.jqxButton('disabled')) {
            // add new empty row.
            $("#table").jqxDataTable('addRow', null, {}, 'first');
            // select the first row and clear the selection.
            $("#table").jqxDataTable('clearSelection');
            $("#table").jqxDataTable('selectRow', 0);
            // edit the new row.
            $("#table").jqxDataTable('beginRowEdit', 0);
            updateButtons('add');
          }
        });
        cancelButton.click(function(event) {
          if (!cancelButton.jqxButton('disabled')) {
            // cancel changes.
            $("#table").jqxDataTable('endRowEdit', rowIndex, true);
          }
        });
        updateButton.click(function(event) {
          if (!updateButton.jqxButton('disabled')) {
            // save changes.
            $("#table").jqxDataTable('endRowEdit', rowIndex, false);
          }
        });
        editButton.click(function() {
          if (!editButton.jqxButton('disabled')) {
            $("#table").jqxDataTable('beginRowEdit', rowIndex);
            updateButtons('edit');
          }
        });
        deleteButton.click(function() {
          if (!deleteButton.jqxButton('disabled')) {
            $("#table").jqxDataTable('deleteRow', rowIndex);
            updateButtons('delete');
          }
        });
        //$("#deleterowbutton").jqxButton();

        // delete row.
        // $("#deleterowbutton").on('click', function() {
        //   if (confirm("Etes vous sur?") == true) {
        //     var selectedrowindex = $("#Grid").jqxGrid('getselectedrowindex');
        //     var rowscount = $("#Grid").jqxGrid('getdatainformation').rowscount;
        //     if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
        //       var id = $("#Grid").jqxGrid('getrowid', selectedrowindex);
        //       var commit = $("#Grid").jqxGrid('deleterow', id);
        //     }
        //   }
        // });
      },
      columns: self.columns
    });
  }

  this.createLoadingMessage = function() {
    $("#table").html("<img src='../img/ajax-loader.gif' alt='loading' />");
  }
  this.destroyLoadingMessage = function() {
    $("#table").empty();
  }
  this.initializeTable = function() {
    self.createCampagneData();
    self.create();
  }
  this.updateTable = function(type) {
    self.clearData();
    $('.table-container').empty();
    $('.table-container').html("<div id='table'></div>");
    switch (type) {
      case "Campagne":
        self.createCampagneData();
        break;
      case "Historique":
        self.createHistoriqueData();
        break;
      case "Taux":
        self.createTauxData();
        break;
      case "Concurrence":
        self.createConcurrenceData();
        break;
      default:
        break;
    }

    self.create();
  }
}