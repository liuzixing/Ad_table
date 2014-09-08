function LayoutController() {
    this.globaltheme = 'bootstrap';
    var self = this;
    this.createLayout = function() {
        $('#splitContainer').jqxSplitter({
            height: 8000,
            width: "100%",
            orientation: 'vertical',
            theme: "layout-custom",
            panels: [{
                size: '18%'
            }, {}]
        });
        $('#splitter').jqxSplitter({
            width: '100%',
            height: '100%',
            theme: "layout-custom",
            orientation: 'horizontal',
            panels: [{
                size: "500px"
            }, {
                // size: "55%"
            }]
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
        $(".clientCircle").attr("src","../img/"+getCookie("mymedia_client_name")+".png");
    }
}