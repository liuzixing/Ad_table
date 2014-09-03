function DashboardController() {
  var source = ["Adopteunmer.com",
    "abc.com",
    "cde.com",
    "xde.com",
    "asx.com",
  ];
  $("#clientselector").jqxDropDownList({
    theme: "bootstrap",
    source: source,
    placeHolder: "Adopteunmer.com",
    width: '200',
    height: '25'
  });

  $(".link_to_Performance").click(function() {
    console.log("ere");
    window.location = "../Performance";
  });
  $(".link_to_Concurrence").click(function() {
    console.log("ere");
    window.location = "../Concurrence";
  });
  $(".link_to_Campagne").click(function() {
    console.log("ere");
    window.location = "../Campagne";
  });
//Balsamik
  $.ajax({
    type: 'GET',
    timeout: 10000,
    dataType: 'json',
    url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/dashboard_perf.php?client=Balsamik',
    async: true,
    success: function(data) {
      for (var i = 0; i < data.length; i++) {
        for (key in data[i]) {
          $(".money:eq(" + i + ")").html((Math.round(data[i][key] * 100) / 100) + "€");
          $(".innerchannelCircle:eq(" + (i) + ")").attr("src", "../img/channel-logos/" + key + ".png");
          //console.log(data[i]);
        }
      };
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });
  //showroomprive
  $.ajax({
    type: 'GET',
    timeout: 10000,
    dataType: 'json',
    url: 'http://tyco.mymedia.fr/fatemeh/export_leadsmonitor/vague.php?client=Balsamik',
    async: true,
    success: function(data) {
      console.log("vague");

      //second row begin
      var dashboard_info = data["dashboard_info"];
      //progress bar
      var renderText = function(text) {
        return "<span class='jqx-rc-all' style='color: white; font-style: italic;'>" + text + "</span>";
      }
      $("#jqxProgressBar").jqxProgressBar({
        width: 250,
        height: 30,
        showText: true,
        theme: "bootstrap",
        renderText: renderText,
        value: dashboard_info["CAMPAGNE"]["time_progress"]
      });

      if (dashboard_info["CAMPAGNE"]["progress"] != "over") {
        dashboard_info["CAMPAGNE"]["progress"] = "en cours";
      } else {
        dashboard_info["CAMPAGNE"]["progress"] = "terminée";
      }
      dashboard_info["CAMPAGNE"]["percent_CbudgetBrut"] = dashboard_info["CAMPAGNE"]["percent_CbudgetBrut"] + "% consommé BUDGET NET";
      for (key in dashboard_info["CAMPAGNE"]) {
        $("#CAMPAGNE_" + key).html(dashboard_info["CAMPAGNE"][key]);
      }
      var concurrence = data["concurrent"];
      $("#campagne_nbconcurrent").html(concurrence["campagne"]["nbconcurrent"]);
      $("#campagne_nbspot").html(concurrence["campagne"]["nbspot"]);
      //second row end

      //channel ranking cells begin
      var performance = data["channel_performance"];
      for (var i = 0; i < performance.length; i++) {
        for (key in performance[i]) {
          $(".money:eq(" + i + ")").html((Math.round(performance[i][key] * 100) / 100) + "€");
          $(".innerchannelCircle:eq(" + (i) + ")").attr("src", "../img/channel-logos/" + key + ".png");
        }
      };
      //channel ranking cells end

      //last day cells begin
      if (dashboard_info["LASTDAY"] == null) {
        $("#last_day_table").fadeOut();
        $("#last_day_title").fadeOut();
      } else {
        for (key in dashboard_info["LASTDAY"]) {
          $("#LASTDAY_" + key).html(dashboard_info["LASTDAY"][key]);
        }
        $("#Lastday_nbconcurrent").html(concurrence["Lastday"]["nbconcurrent"]);
        $("#Lastday_nbspot").html(concurrence["Lastday"]["nbspot"]);
      }
      console.log(data);
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });

}