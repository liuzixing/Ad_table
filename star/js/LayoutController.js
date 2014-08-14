function LayoutController() {
    this.globaltheme = 'bootstrap';
    var self = this;
    this.createLayout = function() {
        $('#splitContainer').jqxSplitter({
            height: 1000,
            width: "100%",
            orientation: 'vertical',
            theme: "layout-custom",
            panels: [{
                size: '13%'
            }, {}]
        });
        $('#splitter').jqxSplitter({
            width: '100%',
            height: '100%',
            theme: "layout-custom",
            orientation: 'horizontal',
            panels: [{

                size: "50%"
            }, {
                size: "50%"
            }]
        });
        $("#clientlogo").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%',
        });
        $("#options").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%',
        });
        $("#filters").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%'
        });
        $("#validation").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%'
        });
    }
}