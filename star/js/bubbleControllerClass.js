function BubbleController(){
    var self = this;
    this.sampleData = [
                    { City: 'New York', SalesQ1: 310500, SalesQ2: 210500, YoYGrowthQ1: 1.05, YoYGrowthQ2: 1.25 },
                    { City: 'London', SalesQ1: 120000, SalesQ2: 169000, YoYGrowthQ1: 1.15, YoYGrowthQ2: 0.95 },
                    { City: 'Paris', SalesQ1: 205000, SalesQ2: 275500, YoYGrowthQ1: 1.45, YoYGrowthQ2: 1.15 },
                    { City: 'Tokyo', SalesQ1: 187000, SalesQ2: 130100, YoYGrowthQ1: 0.45, YoYGrowthQ2: 0.55 },
                    { City: 'Berlin', SalesQ1: 187000, SalesQ2: 113000, YoYGrowthQ1: 1.65, YoYGrowthQ2: 1.05 },
                    { City: 'San Francisco', SalesQ1: 142000, SalesQ2: 102000, YoYGrowthQ1: 0.75, YoYGrowthQ2: 0.15 },
                    { City: 'Chicago', SalesQ1: 171000, SalesQ2: 124000, YoYGrowthQ1: 0.75, YoYGrowthQ2: 0.65 }
                ];
                // prepare jqxChart settings
    this.settings = {
                title: "bubble Graph",
                description: "(demo)",
                enableAnimations: true,
                showLegend: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: this.sampleData,
                xAxis:
                    {
                        dataField: 'City',
                        valuesOnTicks: false
                    },
                colorScheme: 'scheme05',
                seriesGroups:
                    [
                        {
                            type: 'bubble',
                            valueAxis:
                            {
                                unitInterval: 50000,
                                minValue: 50000,
                                maxValue: 350000,
                                description: 'Sales ($)',
                                formatSettings: { prefix: '$', thousandsSeparator: ',' }
                            },
                            series: [
                                    { dataField: 'SalesQ1', radiusDataField: 'YoYGrowthQ1', minRadius: 5, maxRadius: 15, displayText: 'Sales in Q1'},
                                    { dataField: 'SalesQ2', radiusDataField: 'YoYGrowthQ2', minRadius: 5, maxRadius: 15, displayText: 'Sales in Q2'}
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
    this.createBubbleChart = function(){
                self.createLoadingMessage
                $('#chart').jqxChart(this.settings);
                self.destroyLoadingMessage
            }
}

