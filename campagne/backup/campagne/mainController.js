$(document).ready(function() {
    var data = [];
    var getLocalization = function() {
        var localizationobj = {};
        localizationobj.currencySymbol = '£';
        localizationobj.currencySymbolPosition = "before";
        return localizationobj;
    }

    //0 :columnName
    //1:dataFields
    //2:cpvi data
    //3:column filter list source
    //4:colour table
    //5:length filter list source
    //6:version filter list source
    //7:sql request checker
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            'requestType': 'ALL'
        },
        url: 'getDataServer.php',
        async: false,
        success: function(d) {
            data = d;
        },
        cache: false
    });
    console.log(data);
    var cellClass = function(row, dataField, cellText, rowData) {
            var cellValue = rowData[dataField];
            if (cellValue === undefined) {
                return "nothing";
            }
            return data[4][rowData["id"]][dataField];
        }
        //update cell formatting even
    for (var i = 1; i < data[0].length; i++) {
        data[0][i]["cellClassName"] = cellClass;
    }
        //fire animation

     // var cellsRendererFunction = function(row, dataField, cellValue, rowData, cellText) {
     //    if(rowData["id"] == 1){
     //        var letters = cellText.split('');
     //        var res = "";
     //        $.each(letters,function(el){
     //            res= res + ('<span>'+this+'</span>');
     //        });
     //        return res;
     //    }

     // }
     // data[0][data[0].length - 1]["cellsRenderer"] = cellsRendererFunction;
     //  var step = 1;
     // function nextShadow() {
     //        $('.total span').each(function() {

     //            y = parseFloat($(this).attr("y_pos"));
     //            y += step + Math.random() * 3;
     //            $(this).attr("y_pos", y);
     //            shaking = Math.random();
     //            shadow1 = "0px 0px " + (y % 5) + "px white";
     //            shadow2 = shaking * 24 / y * Math.cos(y / 5) * 15 + "px -" + (shaking * 4 / y + (y % 17)) + "px " + (shaking + (y % 17)) + "px red";
     //            shadow3 = shaking * 24 / y * Math.cos(y / 7) * 15 + "px -" + (shaking * 4 / y + (y % 31)) + "px " + (shaking + (y % 31)) + "px #993";
     //            shadow4 = shaking * 24 / y * Math.cos(y / 13) * 15 + "px -" + (shaking * 4 / y + (y % 41)) + "px " + (shaking + (y % 41)) + "px yellow";
     //            $(this).css("text-shadow", shadow2 + ", " + shadow1 + ", " + shadow4 + ", " + shadow3);
     //        });
     //    }
     //    $(function() {
     //        $('.total span').each(function() {
     //            $(this).attr("y_pos", "0");
     //        });
     //        setInterval(nextShadow, 50);
     //    });

    var source = {
        dataType: "json",
        dataFields: data[1],
        hierarchy: {
            root: "children"
        },
        localData: data[2],
        id: "id"
    };

    var dataAdapter = new $.jqx.dataAdapter(source, {
        loadComplete: function() {}
    });
    // create jqxTreeGrid.
    $("#treeGrid").jqxTreeGrid({
        source: dataAdapter,
        localization: getLocalization(),
        selectionMode: 'none',
        sortable: true,
        pageable: true,
        filterable: true,
        enablehover: false,
        filterMode: 'advanced',
        theme: 'ui-start',
        pagerMode: 'advanced',
        pageSize: 100,
        pageSizeOptions: ['100', '150', '200'],
        columnsResize: true,
        ready: function() {
            $("#treeGrid").jqxTreeGrid('expandRow', '1');
            $("#treeGrid").jqxTreeGrid('expandRow', '2');
            $("#treeGrid").jqxTreeGrid('expandRow', '3');
        },
        columns: data[0],
        columnGroups: [{
            text: "Option ",
            name: "Option",
            align: "center"
        }, {
            text: "Channel ",
            name: "Channel",
            align: "center"
        }]
    });
    //create format filter
    $("#applyFilter").jqxButton({
        theme: 'ui-start'
    });
    var listLengthSource = data[5];
    $("#lengthfilterbox").jqxListBox({
        source: listLengthSource,
        width: 130,
        autoHeight: true,
        theme: 'ui-start',
        checkboxes: true
    });
    // handle select all item in lengthfilterbox.
    var handleLengthFilterBoxCheckChange = true;
    $("#lengthfilterbox").on('checkChange', function(event) {
        if (!handleLengthFilterBoxCheckChange)
            return;
        if (event.args.value != "Select all") {
            handleLengthFilterBoxCheckChange = false;
            $("#lengthfilterbox").jqxListBox('checkIndex', 0);
            var checkedItems = $("#lengthfilterbox").jqxListBox('getCheckedItems');
            var items = $("#lengthfilterbox").jqxListBox('getItems');
            if (checkedItems.length == 1) {
                $("#lengthfilterbox").jqxListBox('uncheckIndex', 0);
            } else if (items.length != checkedItems.length) {
                $("#lengthfilterbox").jqxListBox('indeterminateIndex', 0);
            }
            handleLengthFilterBoxCheckChange = true;
        } else {
            handleLengthFilterBoxCheckChange = false;
            if (event.args.checked) {
                $("#lengthfilterbox").jqxListBox('checkAll');
            } else {
                $("#lengthfilterbox").jqxListBox('uncheckAll');
            }
            handleLengthFilterBoxCheckChange = true;
        }
    });
    //create version filter
    var listVersionSource = data[6];
    $("#versionfilterbox").jqxListBox({
        source: listVersionSource,
        width: 130,
        autoHeight: true,
        theme: 'ui-start',
        checkboxes: true
    });
    // handle select all item in versionfilterbox.
    var handleVersionFilterBoxCheckChange = true;
    $("#versionfilterbox").on('checkChange', function(event) {
        if (!handleVersionFilterBoxCheckChange)
            return;
        if (event.args.value != "Select all") {
            handleVersionFilterBoxCheckChange = false;
            $("#versionfilterbox").jqxListBox('checkIndex', 0);
            var checkedItems = $("#versionfilterbox").jqxListBox('getCheckedItems');
            var items = $("#versionfilterbox").jqxListBox('getItems');
            if (checkedItems.length == 1) {
                $("#versionfilterbox").jqxListBox('uncheckIndex', 0);
            } else if (items.length != checkedItems.length) {
                $("#versionfilterbox").jqxListBox('indeterminateIndex', 0);
            }
            handleVersionFilterBoxCheckChange = true;
        } else {
            handleVersionFilterBoxCheckChange = false;
            if (event.args.checked) {
                $("#versionfilterbox").jqxListBox('checkAll');
            } else {
                $("#versionfilterbox").jqxListBox('uncheckAll');
            }
            handleVersionFilterBoxCheckChange = true;
        }
    });

    //create data exporting UI
    $("#csvExport").jqxButton({
        theme: 'ui-start'
    });
    $("#csvExport").click(function() {
        $("#treeGrid").jqxTreeGrid('exportData', 'csv');

    });
    //create check list
    $("#columnfilterbox").jqxListBox({
        source: data[3],
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
        $("#treeGrid").jqxTreeGrid('beginUpdate');
        if (event.args.value != "Select all") {
            handleColumnFilterBoxCheckChange = false;
            $("#columnfilterbox").jqxListBox('checkIndex', 0);
            if (event.args.checked) {
                $("#treeGrid").jqxTreeGrid('showColumn', event.args.value);
            } else {
                $("#treeGrid").jqxTreeGrid('hideColumn', event.args.value);
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
                for (var i = 0; i < data[3].length; i++) {
                    $("#treeGrid").jqxTreeGrid('showColumn', data[3][i]["value"]);
                }
            } else {
                $("#columnfilterbox").jqxListBox('uncheckAll');
                for (var i = 0; i < data[3].length; i++) {
                    $("#treeGrid").jqxTreeGrid('hideColumn', data[3][i]["value"]);
                }
            }
            handleColumnFilterBoxCheckChange = true;
        }

        $("#treeGrid").jqxTreeGrid('endUpdate');
        $(function() {
            $('.total span').each(function() {
                $(this).attr("y_pos", "0");
            });
            setInterval(nextShadow, 50);
        });
    });
    $("#applyFilter").click(function() {
        var lengthList = {},
            versionList = {};
        var verisonItems = $("#versionfilterbox").jqxListBox('getCheckedItems');
        var lengthItems = $("#lengthfilterbox").jqxListBox('getCheckedItems');
        for (var i = 0; i < lengthItems.length; i++) {
            if (lengthItems[i].label != "Select all") {
                lengthList[lengthItems[i].label] = lengthItems[i].label;
            }
        }
        for (var i = 0; i < verisonItems.length; i++) {
            if (verisonItems[i].label != "Select all") {
                versionList[verisonItems[i].label] = verisonItems[i].label;
            }
        }
        console.log(lengthList);
        if(lengthItems.length > 0 && verisonItems.length > 0){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    'requestType': "part",
                    "verisonList": versionList,
                    "lengthList": lengthList
                },
                url: 'getDataServer.php',
                async: false,
                success: function(d) {
                    data = d;
                },
                cache: false
            });
        console.log(data);
            source.localData = data[2];
        }else{
            source.localData = null;
        }
        dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function() {}
        });
        // update data in  jqxTreeGrid.
        $("#treeGrid").jqxTreeGrid('beginUpdate');
        $("#treeGrid").jqxTreeGrid('updateBoundData');
        $("#treeGrid").jqxTreeGrid('endUpdate');
    });

});