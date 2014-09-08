function valider() {
    $("#loading").css('visibility', 'visible');
    var requestData = {
        "username": $("#uName").val(),
        "password": CryptoJS.SHA1($("#passKey").val()).toString(),
        "tag": "login"
    };
    console.log(requestData);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        scriptCharset: "utf-8",
        data: requestData,
        url: "login_server.php",
        async: true,
        success: function(d) {
            console.log("valider");
            console.log(d);
            $("#loading").css('visibility', 'hidden');
            if (d["success"] == 1) {
                setCookie("mymedia_username", $("#uName").val(), 1);
                setCookie("mymedia_token", d["token"], 1);
                setCookie("mymedia_client_name", d["client_name"], 1);
                console.log(window.location);
                if (d["step"] < 9) {
                    window.location.href = "setup/setup.php?token="+d["token"];
                } else {
                    window.location = "Dashboard";
                }
                $("#message_container").html('<div id="display-success"><img src="img/correct.png" alt="Success" style="float: left;"/>Your message was sent successfully.</div>');
            } else {
                setCookie("mymedia_username", "", 0);
                setCookie("mymedia_token", "", 0);
                setCookie("mymedia_client_name", "", 0);
                $("#message_container").html('<div id="display-error"><img src="img/error.png" alt="Error"  style="float: left;"/>L'+"'e-mail ou le mot de passe est incorrect.</div>");
                console.log(d["error"]);
            }
        },
        cache: true
    });
    return false;
}

$(document).ready(function() {
    // $('#toggle-login').click(function() {
    //     $('#login').toggle();
    // });
});