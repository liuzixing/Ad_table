function PerformanceController() {
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
        theme: globaltheme,
        width: '90%',
        height: '25px',
        selectionMode: 'range'
    });
    $('#Comparaison').jqxSwitchButton({
        theme: globaltheme,
        height: 25,
        width: '40%',
        checked: false
    });
    $('#Comparaison').on('checked', function(event) {
        $("#datepicker2").jqxDateTimeInput({
            disabled: true
        });
    });
    $('#Comparaison').on('unchecked', function(event) {
        $("#datepicker2").jqxDateTimeInput({
            disabled: false
        });
    });
    $("#datepicker2").jqxDateTimeInput({
        theme: globaltheme,
        width: '90%',
        height: '25px',
        disabled: true,
        selectionMode: 'range'
    });
    var xaxisSelectorSource = [
        "Taux de recherche",
        "Coût par recherche",
        "Coût de visite immédiate ",
        "Coût de visite campagne ",
        "Coût par visite",
        "Coût par lead",
        "CPO campagne",
        "Taux de nouveaux visiteurs",
        "Taux de rebond"
    ];
    $("#xaxisselector").jqxDropDownList({
        theme: globaltheme,
        source: xaxisSelectorSource,
        placeHolder: "Abscisses (Taux)",
        width: '90%',
        height: '25'
    });
    var yaxisSelectorSource = [
        "Budget net",
        "Nombre total de spots",
        "Nombre total de vues ",
        "Nombre total d’affichage sur Google ",
        "Nombre total de clic vers le site client",
        "Nombre total de visites immédiates",
        "Nombre total de visiteurs immédiats",
        "Nombre total de visites campagne",
        "Nombre total de leads campagne",
        "Nombre total de commandes campagne"
    ];
    $("#yaxisselector").jqxDropDownList({
        theme: globaltheme,
        source: yaxisSelectorSource,
        placeHolder: "Ordonnées (Volume)",
        width: '90%',
        height: '25'
    });
    var regroupmentSource = [
        "Chaîne(s) > Daypart (chaine) + DaypartMM(chaine) > Ecran (chaine Daypart)",
        "ChaineDayofweek >Daypart +MM (chaineDayoftheweek) > Ecran",
        "Chainedaytype > Daypart + MM (chainedaytype)> Ecran",
        "Daypart +DaypartMM > Ecran (daypart)",
        "Dayoftheweek > Daypart+DaypartMM > Ecran (Dayoftheweekdaypart)",
        "Chaineecranweekday + chaineweekday"
    ];
    $("#regroupement").jqxDropDownList({
        theme: globaltheme,
        source: regroupmentSource,
        placeHolder: "Regroupement",
        width: '90%',
        height: '25'
    });
    //filters components
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
    $("#Catégorie").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Catégorie",
        checkboxes: true,
        width: '90%',
        height: '25'
    });
    $("#MMDaypart").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "MMDaypart",
        checkboxes: true,
        width: '90%',
        height: '25'
    });
    $("#Dayofweek").jqxDropDownList({
        theme: globaltheme,
        source: source,
        placeHolder: "Dayofweek",
        checkboxes: true,
        width: '90%',
        height: '25'
    });
    // $('#Optimisation').jqxSwitchButton({
    //     theme: globaltheme,
    //     height: 25,
    //     width: '40%',
    //     checked: false
    // });
    // $("#btn_default").jqxButton({
    //     theme: globaltheme,
    //     width: "40%"
    // });
    // $("#btn_validez").jqxButton({
    //     theme: globaltheme,
    //     width: "40%"
    // });
    $.getScript("../js/GridControllerClass.js", function() {
        var grid = new GridController();
        grid.initialGrid();
    });
    $.getScript("../js/bubbleControllerClass.js", function() {
        var bubble = new BubbleController();
        bubble.createBubbleChart();
    });
}