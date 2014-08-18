function PerformanceController() {
    var globaltheme = 'bootstrap';
    var layout = new LayoutController();
    layout.createLayout();
    var source = ["empty",
"empty",
"empty",
"empty",
"empty",
"empty",
"empty",
"empty",]
;

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
    var xaxisSelectorSource = ["GRPRef",
        "GRPcible",
        "TTRi",
        "CPM",
        "Coût de visite immédiate",
        "CPLi (Coût par lead immediat)",
        "CPOi (Cost per order instant)",
        "% Nouveaux visiteurs i",
        "% Bounce rate (v3)"
    ];
    $("#xaxisselector").jqxDropDownList({
        theme: globaltheme,
        source: xaxisSelectorSource,
        placeHolder: "Abscisses (Taux)",
        width: '90%',
        height: '25'
    });
    var yaxisSelectorSource = ["Total nombre de spots",
        "Total de contacts",
        "Budget brut",
        "Budget net",
        "Total de visites immédiates",
        "Total leads immediats",
    ];
    $("#yaxisselector").jqxDropDownList({
        theme: globaltheme,
        source: yaxisSelectorSource,
        placeHolder: "Ordonnées (Volume)",
        width: '90%',
        height: '25'
    });
    var regroupmentSource = ["Format",
        "Création",
        "Dayoftheweek > Daypart+DaypartMM > Ecran (Dayoftheweekdaypart)",
        "Daypart +DaypartMM > Ecran (daypart)",
        "Chaîne(s) > Daypart (chaine) + DaypartMM(chaine) > Ecran (chaine)",
        "ChaineDayofweek >Daypart +MM (chaineDayoftheweek) > Ecran",
        "Chainedaytype > Daypart + MM (chainedaytype)> Ecran",
        "Chaineecrandayoftheweek + chainedayoftheweek",
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