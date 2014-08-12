function TimeSeriesController(){
    var self = this;
    this.source =
            {
                datatype: "tab",
                datafields: [
                    { name: 'Year' },
                    { name: 'HPI' },
                    { name: 'BuildCost' },
                    { name: 'Population' },
                    { name: 'Rate' }
                ],
                url: 'homeprices.txt'
            };
            this.dataAdapter = new $.jqx.dataAdapter(self.source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + self.source.url + '" : ' + error); } });
                // prepare jqxChart settings
    this.settings = {
                title: "time series demo",
                description: " ",
                enableAnimations: true,
                showLegend: true,
                padding: { left: 20, top: 5, right: 25, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: self.dataAdapter,
                xAxis:
                    {
                        dataField: 'Year',
                        showTickMarks: true,
                        tickMarksInterval: 1,
                        tickMarksColor: '#888888',
                        unitInterval: 5,
                        showGridLines: false,
                        //gridLinesInterval: 5,
                        //gridLinesColor: '#888888',
                        //axisSize: 'auto',
                        minValue: 1947,
                        maxValue: 2012
                    },
                colorScheme: 'scheme02',
                seriesGroups:
                    [
                        {
                            type: 'line',
                            valueAxis:
                            {
                                unitInterval: 10,
                                displayValueAxis: false,
                                displayGridLines: false,
                                showGridLines: true
                            },
                            series: [
                                    { dataField: 'Population', displayText: 'Population' }
                                ]
                        },
                        {
                            type: 'spline',
                            valueAxis:
                            {
                                unitInterval: 20,
                                displayValueAxis: false,
                                displayGridLines: false,
                                description: 'Index Value'
                            },
                            series: [
                                    { dataField: 'HPI', displayText: 'Real Home Price Index' },
                                    { dataField: 'BuildCost', displayText: 'Building Cost Index' }
                                ]
                        }
                    ]
            };
    this.createLoadingMessage = function(){
        $("#chart").html("<img src='../img/ajax-loader.gif' alt='loading' />");
    }
    this.destroyLoadingMessage = function(){
        $("#chart").empty();
    }
            // setup the chart
    this.createChart = function(){
                self.createLoadingMessage
                $('#chart').jqxChart(this.settings);
                self.destroyLoadingMessage
            }
}

