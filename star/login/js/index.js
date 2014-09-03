function valider() {
    // console.log($("#uName").val());
    // console.log($("#passKey").val());
    // console.log(CryptoJS.SHA1($("#passKey").val()).toString());
    // console.log(getCookie("username"));

    $("#loading").css('visibility', 'visible');
    var requestData = {
        "username":$("#uName").val(),
        "password":CryptoJS.SHA1($("#passKey").val()).toString(),
        "tag":"login"
    };
    console.log(requestData);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        scriptCharset: "utf-8",
        data: requestData,
        url: "../server.php",
        async: true,
        success: function(d) {
            console.log("valider");
            console.log(d);
            $("#loading").css('visibility', 'hidden');
            if(d["success"] == 1){
                setCookie("mymedia_username", $("#uName").val(), 1);
                setCookie("mymedia_token",d["token"], 1);
                window.location = "../Dashboard";
            }else{
                setCookie("mymedia_username", "", 0);
                setCookie("mymedia_token","", 0);
                console.log(d["error"]);
            }
        },
        cache: true
    });

    return false;
}

$(document).ready(function() {
    $('#toggle-login').click(function() {
        $('#login').toggle();
    });

});