function CampagneController() {
    var globaltheme = 'bootstrap';
    $('#splitContainer').jqxSplitter({
        height: 800,
        theme: globaltheme,
        width: "100%",
        orientation: 'vertical',
        panels: [{
            collapsible: false,
            size: '20%'
        }, {
            size: '80%'
        }]
    });
    $('#splitter').jqxSplitter({
        width: '100%',
        theme: globaltheme,
        orientation: 'horizontal',
        panels: [{
            size: "50%"
        }]
    });
    $("#settingArea").jqxTabs({
        theme: globaltheme,
        height: '100%',
        width: '100%'
    });
    $("#graphArea").jqxTabs({
        theme: globaltheme,
        height: '100%',
        width: '100%'
    });
    $("#tableArea").jqxTabs({
        theme: globaltheme,
        height: '100%',
        width: '100%'
    });
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
    // Create a jqxDropDownList
    var dropdownlistsetting = {
        theme: globaltheme,
        source: source,
        width: '98%',
        height: '25'
    };

    $("#datepicker1").jqxDateTimeInput({
        width: '45%',
        height: '25px'
    });
    $("#datepicker2").jqxDateTimeInput({
        width: '45%',
        rtl: true,
        height: '25px'
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
    // $("#listbox").jqxListBox({theme: globaltheme,width: '98%', source: source, checkboxes: true, height: 250});
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
    $.getScript("../js/bubbleControllerClass.js", function() {
        var bubble = new BubbleController();
        bubble.createBubbleChart();
    });
}