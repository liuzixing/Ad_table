function DashboardController() {
    var globaltheme = 'bootstrap';
    var data = [
                  {
                      laptops:
                      [
                          { img: '../img/ajax-loader.gif', price: 2999},
                          { img: '../img/ajax-loader.gif', price: 1299},
                          { img: '../img/ajax-loader.gif', price: 2199},
                          { img: '../img/ajax-loader.gif', price: 1499},
                          { img: '../img/ajax-loader.gif', price: 1499},
                      ]
                  },
                  {
                      laptops:
                      [
                          { img: '../img/ajax-loader.gif', price: 1899},
                          { img: '../img/ajax-loader.gif', price: 1799},
                          { img: '../img/ajax-loader.gif', price: 2499},
                          { img: '../img/ajax-loader.gif', price: 1699},
                          { img: '../img/ajax-loader.gif', price: 1599}
                      ]
                  }
        ];

        var source =
        {
            localData: data,
            dataType: "array"
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
        var itemsInCart = 0;

        $("#datatable").jqxDataTable(
        {
            width: "100%",
            source: dataAdapter,
            theme: globaltheme,
            pagerButtonsCount: 5,
            enableHover: false,
            selectionMode: 'none',
            rendered: function () {

            },
            columns: [
                  {
                      text: 'realtime', align: 'left', dataField: 'model',
                      // row - row's index.
                      // column - column's data field.
                      // value - cell's value.
                      // rowData - rendered row's object.
                      cellsRenderer: function (row, column, value, rowData) {
                          var laptops = rowData.laptops;
                          var container = "<div>";
                          for (var i = 0; i < laptops.length; i++) {
                              var laptop = laptops[i];
                              var item = "<div style='float: left; width: 20%; overflow: hidden; white-space: nowrap; height: 180px;'>";
                              var image = "<div style='margin: 5px; margin-bottom: 3px;'>";
                              var imgurl = laptop.img;
                              var img = '<img width=160 height=120 style="display: block;" src="' + imgurl + '"/>';
                              image += img;
                              image += "</div>";
                              var info = "<div style='margin: 5px; margin-left: 20px; margin-bottom: 3px;'>";
                              info += "<div style='font-size: 20px'>Price: " + laptop.price + "€</div>";
                              info += "</div>";
                              item += image;
                              item += info;
                              item += "</div>";
                              container += item;
                          }
                          container += "</div>";
                          return container;
                      }
                  }
            ]
        });

}