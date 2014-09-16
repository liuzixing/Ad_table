function LayoutController() {
    this.globaltheme = 'bootstrap';
    var self = this;
    this.createLayout = function() {
        //for campagne,performance,concurrence pages
        self.createBasicLayout("500px");
        $("#filters").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%'
        });
    }
    this.createBasicLayout = function(top_area_height){
        $('#splitContainer').jqxSplitter({
            height: 1400,
            width: "100%",
            orientation: 'vertical',
            theme: "layout-custom",
            panels: [{
                size: '15%'
            }, {}]
        });
        $('#splitter').jqxSplitter({
            width: '100%',
            height: '100%',
            theme: "layout-custom",
            orientation: 'horizontal',
            panels: [{
                size: top_area_height
            }, {
                // size: "55%"
            }]
        });
        $("#options").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%',
        });
        $("#validation").jqxExpander({
            theme: "expander-custom",
            showArrow: false,
            width: '100%'
        });
        $(".clientCircle").attr("src","../img/"+getCookie("mymedia_client_name")+".png");
        $('.client-website').html(getCookie("mymedia_client_name"));
    }
}