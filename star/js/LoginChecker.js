function LoginChecker() {
    var token = getCookie("mymedia_token");
    var user = getCookie("mymedia_username");
    if (token) {
        var requestData = {
            "token": token,
            "tag": "valider"
        };
        var res = false;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            scriptCharset: "utf-8",
            data: requestData,
            url: "../login_server.php",
            async: false,
            success: function(d) {
                if (d["success"] == 1) {
                    console.log("session success");
                } else {
                    window.location = "../";
                    console.log(d["session error"]);
                }
            },
            cache: true
        });
    } else {
        window.location = "../";
    }
}