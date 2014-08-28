function ZoomableTimeSeries(){
    var source =
            {
                datatype: "csv",
                datafields: [
                    { name: 'Date' },
                    { name: 'Open' },
                    { name: 'High' },
                    { name: 'Low' },
                    { name: 'Close' },
                    { name: 'Volume' },
                    { name: 'AdjClose' }
                    ],
                url: 'TSLA_stockprice.csv'
            };
            var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error); } });
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var toolTipCustomFormatFn = function (value, itemIndex, serie, group, categoryValue, categoryAxis) {
                var dataItem = dataAdapter.records[itemIndex];
                return '<DIV style="text-align:left"><b>Date: ' +
                        categoryValue.getDate() + '-' + months[categoryValue.getMonth()] + '-' + categoryValue.getFullYear() +
                        '</b><br />Open price: $' + dataItem.Open +
                        '</b><br />Close price: $' + dataItem.Close +
                        '</b><br />Daily volume: ' + dataItem.Volume +
                         '</DIV>';
            };
            // prepare jqxChart settings
            var settings = {
                title: "Tesla Motors Stock Price",
                description: "(June 2010 - March 2014)",
                enableAnimations: true,
                animationDuration: 1500,
                enableCrosshairs: true,
                padding: { left: 5, top: 5, right: 30, bottom: 5 },
                source: dataAdapter,
                xAxis:
                    {
                        dataField: 'Date',
                        minValue: new Date(2012, 0, 1),
                        maxValue: new Date(2013, 11, 31),
                        formatFunction: function (value) {
                            return value.getDate() + '-' + months[value.getMonth()] + '\'' + value.getFullYear().toString().substring(2);
                        },
                        type: 'date',
                        baseUnit: 'day',
                        rangeSelector: {
                            // Uncomment the line below to render the selector in a separate container
                            //renderTo: $('#selectorContainer'),
                            size: 120,
                            padding: { /*left: 0, right: 0,*/top: 30, bottom: 0 },
                            minValue: new Date(2010, 5, 1),
                            backgroundColor: 'white',
                            dataField: 'Close',
                            baseUnit: 'month',
                            showGridLines: false,
                            formatFunction: function (value) {
                                return months[value.getMonth()] + '\'' + value.getFullYear().toString().substring(2);
                            }
                        }
                    },
                colorScheme: 'scheme01',
                seriesGroups:
                    [
                        {
                            type: 'line',
                            toolTipFormatFunction: toolTipCustomFormatFn,
                            valueAxis:
                            {
                                description: 'Price per share [USD]<br><br>'
                            },
                            series: [
                                { dataField: 'Close', displayText: 'Close Price', lineWidth: 1, lineWidthSelected: 1 }
                            ]
                        }
                    ]
            };
            $('#chartContainer').jqxChart(settings);
}