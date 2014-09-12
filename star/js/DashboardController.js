function DashboardController() {
  var client_name = getCookie("mymedia_client_name"),
    realtimegraph = new RealTimeController(),
    dashboard_info_url = "http://tyco.mymedia.fr/api/dashboard.php",
    source = [client_name],
    default_date, codeCleaner = new jqxHelperClass();

  realtimegraph.InitialGraph(client_name);

  $(".clientCircle").attr("src", "../img/" + getCookie("mymedia_client_name") + ".png");

  if (source.length > 1) {
    codeCleaner.initialSideBarDropDownList("clientselector", source, false);
    // $("#clientselector").jqxDropDownList({
    //   theme: "bootstrap",
    //   source: source,
    //   width: '200',
    //   height: '25'
    // });
    $("#clientselector").jqxDropDownList('selectIndex', 0);
  } else {
    $("#clientselector").html(client_name);
  }
  $(".link_to_Performance").click(function() {
    window.location = "../Performance";
  });
  $(".link_to_Concurrence").click(function() {
    window.location = "../Concurrence";
  });
  $(".link_to_Concurrence_oneday").click(function() {
    setCookie("default_date", default_date, 1);
    window.location = "../Concurrence";
  });
  $(".link_to_Campagne_with_Contact").click(function() {
    setCookie("default_value_1", "Budget net", 1);
    setCookie("default_value_2", "Contact", 1);
    setCookie("default_value_3", "Visites immediates", 1);
    window.location = "../Campagne";
  });
  $(".link_to_Campagne_with_Contact_oneday").click(function() {
    setCookie("default_value_1", "Budget net", 1);
    setCookie("default_value_2", "Contact", 1);
    setCookie("default_value_3", "Visites immediates", 1);
    setCookie("default_date", default_date, 1);
    console.log(default_date);
    window.location = "../Campagne";
  });
  $(".link_to_Campagne_with_CPVc").click(function() {
    setCookie("default_value_1", "Budget net", 1);
    setCookie("default_value_2", "CPVc", 1);
    setCookie("default_value_3", "Visites immediates", 1);
    window.location = "../Campagne";
  });
  $(".link_to_Campagne_with_CPVc_oneday").click(function() {
    setCookie("default_value_1", "Budget net", 1);
    setCookie("default_value_2", "CPVc", 1);
    setCookie("default_value_3", "Visites immediates", 1);
    setCookie("default_date", default_date, 1);
    console.log(default_date);
    window.location = "../Campagne";
  });
  $(".link_to_Campagne").click(function() {
    //setCookie("default_date", default_date, 1);
    window.location = "../Campagne";
  });
  $(".link_to_Campagne_oneday").click(function() {
    setCookie("default_date", default_date, 1);
    window.location = "../Campagne";
  });


  //get cells data
  var c_days, total_days;
  $.ajax({
    type: 'GET',
    timeout: 10000,
    dataType: 'json',
    url: dashboard_info_url + '?client=' + client_name,
    async: true,
    success: function(data) {
      //campagne cell begin
      var dashboard_info = data["dashboard_info"];
      c_days = dashboard_info["CAMPAGNE"]["c_days"];
      total_days = dashboard_info["CAMPAGNE"]["total_days"];
            //progress bar
      var renderText = function(text) {
        return "<span class='jqx-rc-all' style='color: white;font-weight: bold;font-size:16px'>" + c_days + "/" + total_days + " jours</span>";
      }
      $("#jqxProgressBar").jqxProgressBar({
        width: 250,
        height: 30,
        showText: true,
        theme: "propressbar-custom",
        renderText: renderText,
        value: dashboard_info["CAMPAGNE"]["time_progress"]
      });
            //progress bar end

            //change english key to french key
      if (dashboard_info["CAMPAGNE"]["progress"] != "over") {
        dashboard_info["CAMPAGNE"]["progress"] = "en cours";
      } else {
        dashboard_info["CAMPAGNE"]["progress"] = "terminée";
      }
      dashboard_info["CAMPAGNE"]["percent_CbudgetBrut"] = Math.round(dashboard_info["CAMPAGNE"]["percent_CbudgetBrut"] * 100) / 100 + "%";
            //change english key to french key end

            //process every number seperated by space
      for (key in dashboard_info["CAMPAGNE"]) {
        if (key != "date_start" && key != "date_end") {
          $("#CAMPAGNE_" + key).html(codeCleaner.getSeperatedNumber(dashboard_info["CAMPAGNE"][key], " "));
        } else {
          $("#CAMPAGNE_" + key).html(dashboard_info["CAMPAGNE"][key]);
        }
      }
            //process end

      var concurrence = data["concurrent"];
      $("#campagne_nbconcurrent").html(concurrence["campagne"]["nbconcurrent"]);
      $("#campagne_nbspot").html(concurrence["campagne"]["nbspot"]);
      //campagne cell end

      //channel ranking cells begin
      var performance = data["channel_performance"];
      for (var i = 0; i < performance.length; i++) {
        for (key in performance[i]) {
          $(".money:eq(" + i + ")").html((Math.round(performance[i][key] * 100) / 100) + "€ CPVi");
          $(".innerchannelCircle:eq(" + (i) + ")").attr("src", "../img/channel-logos/" + key + ".png");
        }
      };
        //deal with the missing ranking channel
      for (var i = performance.length; i < 6; i++) {
        $(".money:eq(" + performance.length + ")").parent().empty();
      }
      //channel ranking cells end

      //last day cells begin
      if (dashboard_info["LASTDAY"] == null) {
        $("#last_day_table").fadeOut();
        $("#last_day_title").fadeOut();
      } else {
        for (key in dashboard_info["LASTDAY"]) {
          if (key != "date") {
            $("#LASTDAY_" + key).html(codeCleaner.getSeperatedNumber(dashboard_info["LASTDAY"][key], " "));
          } else {
            $("#LASTDAY_" + key).html(dashboard_info["LASTDAY"][key]);
          }
        }
        default_date = dashboard_info["LASTDAY"]["date"];
        $("#Lastday_nbconcurrent").html(concurrence["Lastday"]["nbconcurrent"]);
        $("#Lastday_nbspot").html(concurrence["Lastday"]["nbspot"]);

      }
      //last day cells end
      console.log(data);
    },
    failure: function(err) {
      console.log("Error");
    },
    cache: true
  });
}