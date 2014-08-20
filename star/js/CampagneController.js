function CampagneController() {
    var globaltheme = 'bootstrap';
    var layout = new LayoutController();
    layout.createLayout();
    var source = ["Budget net",
        "Ecran / spot",
        "Chaines",
        "Contact",
        "Affichage Recherche Google",
        "Visites immédiates",
        "CPVI",
        "% nouveaux visiteurs immédiats",
        "Visites campagne",
        "CPVc",
        "Visites du site",
        "KPI personnalisé client",
        "Clic sur Google",
        "CTR",
        "Leads immédiats",
        "Ventes immédiates",
    ];


    $("#valueselector1").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "1ère valeur à afficher",
        width: '90%',
        height: '25'
    });
    $("#valueselector2").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "2ème valeur à afficher",
        width: '90%',
        height: '25'
    });
    $("#valueselector3").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "3ème valeur à afficher",
        width: '90%',
        height: '25'
    });
    $("#valueselector1").jqxDropDownList('selectItem', 'CPVI');
    $("#valueselector2").jqxDropDownList('selectItem', 'Ventes immédiates');
    $("#valueselector3").jqxDropDownList('selectItem', 'Budget net');
    $.ajax({
        type: 'GET',
        timeout: 10000,
        dataType: 'json',
        url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_filtre_default.php?client=Balsamik',
        async: true,
        success: function(d) {
            //console.log(d);
            $("#Chaîne").jqxDropDownList({
                theme: globaltheme,
                source: d["channel"],
                placeHolder: "Chaîne",
                checkboxes: true,
                width: '90%',
                height: '25'
            });
            $("#Version").jqxDropDownList({
                theme: globaltheme,
                source: d["version"],
                placeHolder: "Version pub / créa",
                checkboxes: true,
                width: '90%',
                height: '25'
            });
            $("#Format").jqxDropDownList({
                theme: globaltheme,
                source: d["format"],
                placeHolder: "Format",
                checkboxes: true,
                width: '90%',
                height: '25'
            });
            $("#Chaîne").jqxDropDownList('checkAll');
            $("#Version").jqxDropDownList('checkAll');
            $("#Format").jqxDropDownList('checkAll');

            //datepick settings
            var today = new Date();
            var sixmonthsago = new Date();
            sixmonthsago.setDate(today.getDate() - 180);
            $("#datepicker1").jqxDateTimeInput({
                theme: globaltheme,
                width: '90%',
                height: '25px',
                min: sixmonthsago,
                max: today,
                selectionMode: 'range'
            });
            var from = new Date(d["period"]["from"]);
            var to = new Date(d["period"]["to"]);
             $("#datepicker1").jqxDateTimeInput('setRange', from, to);
        },
        failure: function(err) {
            console.log("Error");
        },
        cache: true
    });

    var grid = new TreeGridController();
    grid.initialTreeGrid();

    var chart = new TimeSeriesController();
    chart.initialChart();
    $("#Valider").click(function() {
        var tableData = {
            "client": "Balsamik",
            "period": {
                "from": "",
                "to": ""
            },
            "filter": {
                "chaines": [],
                "format": [],
                "version": []
            }
        };
        var graphData = {
            "client": "Balsamik",
            "period": {
                "from": "",
                "to": ""
            },
            "value1": "",
            "value2": "",
            "value3": ""
        };
        var channel = $("#Chaîne").jqxDropDownList('getCheckedItems');
        var version = $("#Version").jqxDropDownList('getCheckedItems');
        var format = $("#Format").jqxDropDownList('getCheckedItems');
        for (var i = 0; i < channel.length; i++) {
            tableData["filter"]["chaines"].push(channel[i].label);
        };
        for (var i = 0; i < format.length; i++) {
            tableData["filter"]["format"].push(format[i].label);
        };
        for (var i = 0; i < version.length; i++) {
            tableData["filter"]["version"].push(version[i].label);
        };
        var selection = $("#datepicker1").jqxDateTimeInput('getRange');
        if (selection.from != null) {
            tableData["period"]["from"] = selection.from.toLocaleDateString();
            tableData["period"]["to"] = selection.to.toLocaleDateString();
            graphData["period"]["from"] = selection.from.toLocaleDateString();
            graphData["period"]["to"] = selection.to.toLocaleDateString();
        }
        //console.log(tableData);

        var value1 = $("#valueselector1").jqxDropDownList('getSelectedItem');
        var value2 = $("#valueselector2").jqxDropDownList('getSelectedItem');
        var value3 = $("#valueselector3").jqxDropDownList('getSelectedItem');
        graphData["value1"] = value1.label;
        graphData["value2"] = value2.label;
        graphData["value3"] = value3.label;
        console.log(graphData);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: tableData,
            url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne.php',
            async: true,
            success: function(d) {
                grid.updateTreeGrid(d);
                //console.log(d);
            },
            cache: false
        });
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: graphData,
            url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/api_campagne_graph_default.php',
            async: true,
            success: function(d) {
                chart.updateChart(d);
                console.log(d);
            },
            cache: false
        });
    });


}