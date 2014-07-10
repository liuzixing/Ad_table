$(document).ready(function() {
    var data = [];
    var dataCellWithoutColour = [[],[]];
    var showColourDataOnly = false;
    //0 :columnName
    //1:dataFields
    //2:cell data
    //3:colour table
    //4:column fitler
    $.ajax({
        dataType: 'json',
        url: 'screentable.php',
        async: false,
        success: function(d) {
            data = d;
        },
        cache: false
    });
    console.log(data);
    //create data cell without colour
    for (var i = 0; i < data[2].length; i++) {
        if (data[3][i] != "") {
            dataCellWithoutColour[0].push(data[2][i]);
            dataCellWithoutColour[1].push(data[3][i]);
        }
    }
    console.log(dataCellWithoutColour);
    var cellclass = function(row, columnfield, value) {
        //console.log(data[3][row]);
        if (showColourDataOnly) {
            return dataCellWithoutColour[1][row];
        } else {
            return data[3][row];
        }
    }
    for (var i = 0; i < data[0].length; i++) {
        data[0][i]["cellClassName"] = cellclass;
    }
    var source = {
        dataType: "json",
        dataFields: data[1],
        localData: data[2],
        id: "id"
    };

    var dataAdapter = new $.jqx.dataAdapter(source, {
        loadComplete: function() {}
    });
    // create jqxGrid.
    $("#jqxgrid").jqxGrid({
        source: dataAdapter,
        height: 800,
        showtoolbar: true,
        width: 1474,
        sortable: true,
        filterable: true,
        theme: 'ui-start',
        columnsResize: true,
        columns: data[0],
    });


    //create data exporting UI
    $("#csvExport").jqxButton({
        theme: 'ui-start'
    });
    $("#csvExport").click(function() {
        //$("#jqxgrid").jqxGrid('exportData', 'csv');
        $("#jqxgrid").jqxGrid('exportdata', 'csv', 'jqxGrid');
    });
    //create check list
    $("#columnfilterbox").jqxListBox({
        source: data[4],
        width: 130,
        autoHeight: true,
        theme: 'ui-start',
        checkboxes: true
    });
    // handle select all item in columnfilterbox.
    var handleColumnFilterBoxCheckChange = true;
    $("#columnfilterbox").on('checkChange', function(event) {
        if (!handleColumnFilterBoxCheckChange)
            return;
        $("#jqxgrid").jqxGrid('beginUpdate');
        if (event.args.value != "Select all") {
            handleColumnFilterBoxCheckChange = false;
            $("#columnfilterbox").jqxListBox('checkIndex', 0);
            if (event.args.checked) {
                $("#jqxgrid").jqxGrid('showColumn', event.args.value);
            } else {
                $("#jqxgrid").jqxGrid('hideColumn', event.args.value);
            }
            var checkedItems = $("#columnfilterbox").jqxListBox('getCheckedItems');
            var items = $("#columnfilterbox").jqxListBox('getItems');
            if (checkedItems.length == 1) {
                $("#columnfilterbox").jqxListBox('uncheckIndex', 0);
            } else if (items.length != checkedItems.length) {
                $("#columnfilterbox").jqxListBox('indeterminateIndex', 0);
            }
            handleColumnFilterBoxCheckChange = true;
        } else {
            handleColumnFilterBoxCheckChange = false;
            if (event.args.checked) {
                $("#columnfilterbox").jqxListBox('checkAll');
                for (var i = 0; i < data[4].length; i++) {
                    $("#jqxgrid").jqxGrid('showColumn', data[4][i]);
                }
            } else {
                $("#columnfilterbox").jqxListBox('uncheckAll');
                for (var i = 0; i < data[4].length; i++) {
                    $("#jqxgrid").jqxGrid('hideColumn', data[4][i]);
                }
            }
            handleColumnFilterBoxCheckChange = true;
        }
        $("#jqxgrid").jqxGrid('endUpdate');
    });

    //show/hide column
    $("#applyFilter").jqxButton({
        theme: 'ui-start'
    });


    // applies the filter.
    $("#applyFilter").click(function() {
        if (showColourDataOnly) {
            source.localData = data[2];
            showColourDataOnly = false;
        } else {
            source.localData = dataCellWithoutColour[0];
            showColourDataOnly = true;
        }
        dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function() {}
        });
        // update data in  jqxTreeGrid.
        $("#jqxgrid").jqxGrid('beginUpdate');
        $("#jqxgrid").jqxGrid('updateBoundData');
        $("#jqxgrid").jqxGrid('endUpdate');
    });
});