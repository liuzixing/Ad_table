function CampagneController() {
    var globaltheme = 'bootstrap';
    var layout = new LayoutController();
    layout.createLayout();
    var source = ["Budget net",
        "Ecran / spot",
        "Chaînes",
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

    $("#Chaîne").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Chaîne",
        checkboxes: true,
        width: '90%',
        height: '25'
    });
    $("#Version").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Version pub / créa",
        checkboxes: true,
        width: '90%',
        height: '25'
    });
    $("#Format").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Format",
        checkboxes: true,
        width: '90%',
        height: '25'
    });

    $.getScript("../js/GridControllerClass.js", function() {
        var grid = new GridController();
        grid.initialGrid();
    });
    var chart = new TimeSeriesController();
    chart.createChart();

}