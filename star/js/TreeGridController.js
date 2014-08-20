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
    this.collapseSetting = [{
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
        columns: ["Status Audience","CPM","GRP cible","Affinité"]
    }, {
        collapsed: false,
        group: 4,
        columns: ["Type Ap","Emission Avant","Type Av"]
    }, {
        collapsed: false,
        group: 5,
        columns: ["CTR"]
    }];
    this.setGroupTitleToMinusStyle = function() {
        for (var i = 0; i < self.collapseSetting.length; i++) {
            $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").html("<div style='overflow: hidden; text-overflow: ellipsis; text-align: center; margin-left: 4px; margin-right: 4px; margin-bottom: 8px; margin-top: 8px;'><span style='text-overflow: ellipsis; cursor: default;'>" + $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").text() + "</span>   <img src='../img/blank.png' class='sprite  sprite-minus_table' /></div>");
        }
    }

    this.setGroupTitleStyle = function() {
        for (var i = 0; i < self.collapseSetting.length; i++) {
            if (self.collapseSetting[i]["collapsed"]) {
                $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").html("<div style='overflow: hidden; text-overflow: ellipsis; text-align: center; margin-left: 4px; margin-right: 4px; margin-bottom: 8px; margin-top: 8px;'><span style='text-overflow: ellipsis; cursor: default;'>" + $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").text() + "</span>   <img src='../img/blank.png' class='sprite  sprite-plus_table' /></div>");
            } else {
                $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").html("<div style='overflow: hidden; text-overflow: ellipsis; text-align: center; margin-left: 4px; margin-right: 4px; margin-bottom: 8px; margin-top: 8px;'><span style='text-overflow: ellipsis; cursor: default;'>" + $("#treeGrid .jqx-grid-columngroup-header:eq(" + self.collapseSetting[i]["group"] + ")").text() + "</span>   <img src='../img/blank.png' class='sprite  sprite-minus_table' /></div>");
            }
        }
    }
    this.updateTreeGrid = function(d) {
        self.data[2] = d[2];
        self.source.localData = self.data[2];
        self.dataAdapter = new $.jqx.dataAdapter(self.source, {
            loadComplete: function() {}
        });
        // update data in  jqxTreeGrid.
        $("#treeGrid").jqxTreeGrid('beginUpdate');
        $("#treeGrid").jqxTreeGrid('updateBoundData');
        $("#treeGrid").jqxTreeGrid('endUpdate');
        self.attachColumnGroupClickEvent();
        self.setGroupTitleStyle();
    }
    this.createTreeGrid = function() {
        self.source = {
            dataType: "json",
            dataFields: self.data[1],
            hierarchy: {
                root: "children"
            },
            localData: self.data[2],
            id: "id"
        };
        self.dataAdapter = new $.jqx.dataAdapter(self.source, {
            loadComplete: function() {}
        });
        // create jqxTreeGrid.
        $("#treeGrid").jqxTreeGrid({
            source: self.dataAdapter,
            selectionMode: 'none',
            sortable: false,
            pageable: true,
            width: 1600,
            enablehover: true,
            altRows: true,
            theme: 'mymedia-table',
            pageSize: 50,
            pagerPosition: 'top',
            columnsResize: true,
            ready: function() {
                $("#treeGrid").jqxTreeGrid('expandRow', '3321');
            },
            columns: self.data[0],
            columnGroups: self.data[3]
        });
        self.attachColumnGroupClickEvent();
        self.setGroupTitleStyle();
    }

    this.groupecrancollapsed = false;
    this.groupEcranObserver = function(index) {
        $("#treeGrid").jqxTreeGrid('beginUpdate');
        //console.log(index);
        if (self.collapseSetting[index]["collapsed"]) {
            self.collapseSetting[index]["collapsed"] = false;
            for (var i = 0; i < self.collapseSetting[index]["columns"].length; i++) {
                $("#treeGrid").jqxTreeGrid('showColumn', self.collapseSetting[index]["columns"][i]);
            }
        } else {
            self.collapseSetting[index]["collapsed"] = true;
            console.log(self.collapseSetting[index]["columns"]);
            console.log(self.collapseSetting[index]["columns"].length);
            for (var i = 0; i < self.collapseSetting[index]["columns"].length; i++) {
                $("#treeGrid").jqxTreeGrid('hideColumn', self.collapseSetting[index]["columns"][i]);
            }
        }
        $("#treeGrid").jqxTreeGrid('endUpdate');

        self.setGroupTitleStyle();
        self.attachColumnGroupClickEvent();
    }

    this.attachColumnGroupClickEvent = function() {
        //console.log(self.collapseSetting.length);

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
    this.initialTreeGrid = function() {
        self.createExportButton();
        self.createLoadingMessage();
        $.ajax({
            type: 'GET',
            timeout: 10000,
            dataType: 'json',
            url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne.php?client=Balsamik',
            async: true,
            success: function(d) {
                self.data = d;
                //console.log(self.data);
                self.destroyLoadingMessage();
                self.createTreeGrid();

            },
            failure: function(err) {
                console.log("Error");
            },
            cache: true
        });
    }
}