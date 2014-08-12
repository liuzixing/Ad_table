function LayoutController() {
    this.globaltheme = 'bootstrap';
    var self = this;
    this.createLayout = function() {
        $('#splitContainer').jqxSplitter({
            height: 800,
            width: "100%",
            orientation: 'vertical',
            panels: [{
                size: '250'
            }, {
            }]
        });
        $('#splitter').jqxSplitter({
            width: '100%',
            height: '100%',
            orientation: 'horizontal',
            panels: [{

                size: "60%"
            }, {
                size: "40%"
            }]
        });
        $("#clientlogo").jqxExpander({
            theme: "mymedia",
            showArrow: false,
            width: '100%',
        });
        $("#options").jqxExpander({
            theme: "mymedia",
            showArrow: false,
            width: '100%',
        });
        $("#filters").jqxExpander({
            theme: "mymedia",
            showArrow: false,
            width: '100%'
        });
        $("#validation").jqxExpander({
            theme: "mymedia",
            showArrow: false,
            width: '100%'
        });
        // $("#settingArea").jqxTabs({
        //     theme: self.globaltheme,
        //     height: '100%',
        //     width: '100%'
        // });
    }
}