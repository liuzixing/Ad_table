function LayoutController() {
    this.globaltheme = 'bootstrap';
    var self = this;
    this.createLayout = function() {
        $('#splitContainer').jqxSplitter({
            height: 800,
            theme: self.globaltheme,
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
            height: '100%',
            theme: self.globaltheme,
            orientation: 'horizontal',
            panels: [{
                collapsible: false,
                size: "50%"
            }, {
                size: "50%"
            }]
        });
        $("#settingArea").jqxTabs({
            theme: self.globaltheme,
            height: '100%',
            width: '100%'
        });
    }
}