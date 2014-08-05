function CampagneController() {
    var globaltheme = 'bootstrap';
    var layout = new LayoutController();
    layout.createLayout();

    var source = [
        "Budget net",
        "Total affichage sur Google",
        "Coût par recherche",
        "CTR",
        "Nombre total de visites immédiates",
        "Coût de la visite immédiate",
        "Nombre total de visites du site",
        "Nombre total de visite campagne ",
        "Coût de la visite campagne",
        "% de nouveaux visiteurs immédiats",
        "Nombre total de leads immédiats",
        "Coût au lead immédiat",
        "Nombre total de ventes immédiates",
        "CPA",
        "CPO",
        "KPI personnalisé client",
        "Nombre total de ventes",
    ];


    $("#datepicker1").jqxDateTimeInput({
        theme:globaltheme,
        width: '98%',
        height: '25px',
        selectionMode: 'range'
    });
    $("#valueselector1").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "1ère valeur à afficher",
        width: '98%',
        height: '25'
    });
    $("#valueselector2").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "2ème valeur à afficher",
        width: '98%',
        height: '25'
    });
    $("#valueselector3").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "3ème valeur à afficher",
        width: '98%',
        height: '25'
    });

    $("#Chaîne").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Chaîne",
        checkboxes: true,
        width: '98%',
        height: '25'
    });
    $("#Version").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Version pub / créa",
        checkboxes: true,
        width: '98%',
        height: '25'
    });
    $("#Format").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Format",
        checkboxes: true,
        width: '98%',
        height: '25'
    });
    $('#Optimisation').jqxSwitchButton({
        theme:globaltheme,
        height: 25,
        width: '40%',
        checked: false
    });

    $("#btn_default").jqxButton({
        theme: globaltheme,
        width: "40%"
    });
    $("#btn_validez").jqxButton({
        theme: globaltheme,
        width: "40%"
    });
    $.getScript("../js/GridControllerClass.js", function() {
        var grid = new GridController();
        grid.initialGrid();
    });
    $.getScript("../js/TimeSeriesController.js", function() {
        var chart = new TimeSeriesController();
        chart.createChart();
    });
}