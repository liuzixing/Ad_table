function GridController() {
    var _self = this;
    var _data = [];
    this._dataCellOnlyWithColour = [[],[]];
    var _source = {};
    var _dataAdapter = {};
    var _showColourDataOnly = false;
    this.createGrid = function() {
        _self._source = {
            dataType: "json",
            dataFields: _self._data[1],
            hierarchy: {
                root: "children"
            },
            localData: _self._data[2],
            id: "id"
        };

        _self._dataAdapter = new $.jqx.dataAdapter(_self._source, {
            loadComplete: function() {}
        });
        $("#jqxgrid").jqxGrid({
            source: _self._dataAdapter,
            height: "100%",
            width: "100%",
            sortable: true,
            filterable: true,
            theme: 'bootstrap',
            columnsResize: true,
            columns: _self._data[0],
        });
        var localizationobj = {};
        localizationobj.currencysymbol = '&#8240';
        localizationobj.currencysymbolposition = "after";
        $("#jqxgrid").jqxGrid('localizestrings', localizationobj);
    }
    // this.createExportButton = function() {
    //     //create data exporting UI
    //     $("#csvExport").jqxButton({
    //         theme: 'ui-start',
    //         width: 130
    //     });
    //     $("#csvExport").click(function() {
    //         $("#jqxgrid").jqxGrid('exportdata', 'csv', 'jqxGrid');
    //     });
    // }
    // this.handleColumnFilterBoxCheckChange = true;
    // this.CreateColumnFilterBox = function() {
    //     //create check list
    //     $("#columnfilterbox").jqxListBox({
    //         source: _self._data[4],
    //         width: 140,
    //         autoHeight: true,
    //         theme: 'ui-start',
    //         checkboxes: true
    //     });
    //     // handle select all item in columnfilterbox.
    //     $("#columnfilterbox").on('checkChange', function(event) {
    //         if (!_self.handleColumnFilterBoxCheckChange)
    //             return;
    //         $("#jqxgrid").jqxGrid('beginUpdate');
    //         if (event.args.value != "Select all") {
    //             _self.handleColumnFilterBoxCheckChange = false;
    //             $("#columnfilterbox").jqxListBox('checkIndex', 0);
    //             if (event.args.checked) {
    //                 $("#jqxgrid").jqxGrid('showColumn', event.args.value);
    //             } else {
    //                 $("#jqxgrid").jqxGrid('hideColumn', event.args.value);
    //             }
    //             var checkedItems = $("#columnfilterbox").jqxListBox('getCheckedItems');
    //             var items = $("#columnfilterbox").jqxListBox('getItems');
    //             if (checkedItems.length == 1) {
    //                 $("#columnfilterbox").jqxListBox('uncheckIndex', 0);
    //             } else if (items.length != checkedItems.length) {
    //                 $("#columnfilterbox").jqxListBox('indeterminateIndex', 0);
    //             }
    //             _self.handleColumnFilterBoxCheckChange = true;
    //         } else {
    //             _self.handleColumnFilterBoxCheckChange = false;
    //             if (event.args.checked) {
    //                 $("#columnfilterbox").jqxListBox('checkAll');
    //                 for (var i = 0; i < _data[4].length; i++) {
    //                     $("#jqxgrid").jqxGrid('showColumn', _data[4][i]["value"]);
    //                 }
    //             } else {
    //                 $("#columnfilterbox").jqxListBox('uncheckAll');
    //                 for (var i = 0; i < _data[4].length; i++) {
    //                     $("#jqxgrid").jqxGrid('hideColumn', _data[4][i]["value"]);
    //                 }
    //             }
    //             _self.handleColumnFilterBoxCheckChange = true;
    //         }
    //         $("#jqxgrid").jqxGrid('endUpdate');
    //     });
    // // }
    // this.createApplyFilterButton = function() {
    //     //show/hide column
    //     $("#applyFilter").jqxButton({
    //         theme: 'ui-start',
    //         width: 130
    //     });
    //     $("#applyFilter").val("Optimisation");
    //     // applies the filter.
    //     $("#applyFilter").click(function() {
    //         if (_self._showColourDataOnly) {
    //             _self._source.localData = _self._data[2];
    //             _self._showColourDataOnly = false;
    //         } else {
    //             _self._source.localData = _self._dataCellOnlyWithColour[0];
    //             _self._showColourDataOnly = true;
    //         }
    //         _self._dataAdapter = new $.jqx.dataAdapter(_self._source, {
    //             loadComplete: function() {}
    //         });
    //         // update data in  jqxTreeGrid.
    //         $("#jqxgrid").jqxGrid('beginUpdate');
    //         $("#jqxgrid").jqxGrid('updateBoundData');
    //         $("#jqxgrid").jqxGrid('endUpdate');
    //     });
    // }
    this.createLoadingMessage = function(){
        $("#jqxgrid").html("<img src='ajax-loader.gif' alt='loading' />");
    }
    this.destroyLoadingMessage = function(){
        $("#jqxgrid").empty();
    }
    this.initialGrid = function() {
        //_self.createExportButton();
        _self.createLoadingMessage();
        $.ajax({
            dataType: 'json',
            url: "server.php",
            async: true,
            success: function(d) {
                _self._data = d;
                console.log(_self._data);
                //create data cell without colour
                for (var i = 0; i < _self._data[2].length; i++) {
                    if (_self._data[3][i] != "") {
                        _self._dataCellOnlyWithColour[0].push(_self._data[2][i]);
                        _self._dataCellOnlyWithColour[1].push(_self._data[3][i]);
                    }
                }
                console.log(_self._dataCellOnlyWithColour);
                var cellclass = function(row, columnfield, value) {
                    if (_self._showColourDataOnly) {
                        return _self._dataCellOnlyWithColour[1][row];
                    } else {
                        return _self._data[3][row];
                    }
                }
                for (var i = 0; i < _self._data[0].length; i++) {
                    _self._data[0][i]["cellClassName"] = cellclass;
                }
                _self.destroyLoadingMessage();
                _self.createGrid();
                // _self.CreateColumnFilterBox();
                // _self.createApplyFilterButton();

            },
            cache: true
        });
    }
}