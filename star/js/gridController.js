function gridController(server_url) {
    $.getScript("../GridControllerClass.js", function() {
        var grid = new GridController();
        grid.initialGrid();
    });
}