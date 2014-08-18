function DashboardController() {
  var source = ["Adopteunmer.com",
        "Adopteunmer.com",
        "Adopteunmer.com",
        "Adopteunmer.com",
        "Adopteunmer.com",
    ];
  $("#clientselector").jqxDropDownList({
        theme: "bootstrap",
        source: source,
        placeHolder: "Adopteunmer.com",
        width: '200',
        height: '25'
    });

}