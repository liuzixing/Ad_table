function TimeSeriesController() {
    var self = this;
    var data = [];
    var source = {};
    var dataAdapter = {};
    this.createLoadingMessage = function() {
        $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
        console.log("loading");
    }
    this.destroyLoadingMessage = function() {
        $("#chart").empty();
    }
    this.createChart = function() {
        self.source = {
            datatype: "json",
            datafields: self.data[0],
            localData: self.data[2],
        };
        self.dataAdapter = new $.jqx.dataAdapter(self.source, {
            loadError: function(xhr, status, error) {
                alert('Error loading "' + self.source.url + '" : ' + error);
            }
        });
        // prepare jqxChart settings
        self.settings = {
            title: "",
            description: " ",
            enableAnimations: true,
            showLegend: true,
            padding: {
                left: 20,
                top: 5,
                right: 25,
                bottom: 5
            },
            titlePadding: {
                left: 90,
                top: 0,
                right: 0,
                bottom: 10
            },
            source: self.dataAdapter,
            xAxis: {
                dataField: 'date',
                showTickMarks: true,
                tickMarksInterval: 1,
                tickMarksColor: '#888888',
                type: "date",
                showGridLines: false,
                //gridLinesInterval: 5,
                //gridLinesColor: '#888888',
                //axisSize: 'auto',
            },
            colorScheme: 'scheme02',
            seriesGroups: [{
                type: 'spline',
                valueAxis: {
                    unitInterval: 10,
                    displayValueAxis: false,
                    displayGridLines: false,
                    showGridLines: true
                },
                series: [self.data[1][0]]
            }, {
                type: 'spline',
                valueAxis: {
                    unitInterval: 10,
                    displayValueAxis: false,
                    displayGridLines: false,
                    showGridLines: true
                },
                series: [self.data[1][1]]
            }, {
                type: 'spline',
                valueAxis: {
                    unitInterval: 20,
                    displayValueAxis: false,
                    displayGridLines: false,
                    description: 'Index Value'
                },
                series: [self.data[1][2]]
            }]
        };
        console.log(self.settings);
        $('#chart').jqxChart(self.settings);
    }
    this.updateChart = function(d){
        self.data = d;
        self.destroyLoadingMessage();
                self.createChart();
    }
    // setup the chart
    this.initialChart = function() {
        self.createLoadingMessage();
        $.ajax({
            type: 'GET',
            timeout: 10000,
            dataType: 'json',
            url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne_graph_default.php?client=Balsamik',
            async: true,
            success: function(d) {
                self.data = d;
                console.log(self.data);
                self.destroyLoadingMessage();
                self.createChart();
            },
            failure: function(err) {
                console.log("Error");
            },
            cache: true
        });
    }
}