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
    this.createLoadingMessage = function(){
        $("#jqxgrid").html("<img src='../img/ajax-loader.gif' alt='loading' />");
    }
    this.destroyLoadingMessage = function(){
        $("#jqxgrid").empty();
    }
    this.initialGrid = function() {
        //_self.createExportButton();
        _self.createLoadingMessage();
        $.ajax({
            dataType: 'json',
            url: "../server.php",
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