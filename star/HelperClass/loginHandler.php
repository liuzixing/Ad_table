 <?php

    function loginHandler($tag){
        session_start();
        // response Array
        $response = array("tag" =>
            $tag, "success" => 0, "error" => 0);
        if(isset($_POST["token"])){
            if(isset($_SESSION[$_POST["token"]])){
                $response = array("tag" =>
                    $tag, "success" => 1, "error" => 0,"token"=>$_POST["token"]);
                return $response;
            }else{
                $response = array("tag" =>
                    $tag, "success" => 0, "error" => "log in time out");
            }
            return $response;
        }
        require_once('/home/www/mymedia_fr/lib/dblib.php');
        if (!($con = db_connect_leadsv2_return())) die('DB Err');
        // Request type is check Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = mysql_query("SELECT * FROM Compte WHERE IDcompte = '$username'") or die(mysql_error());


        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            if ($result["password"] != $password){
                $response["error"] = "Incorrect password or username";
            }else{
                $salt = $result['salt'];
                $response["token"] = base64_encode(sha1($username . $salt, true) . $salt);
                $response["success"] = 1;
                $_SESSION[$response["token"]] = 1;
            }
        } else {
            // user not found
            $response["error"] = "Incorrect password or username";
        }
        return $response;

    }

?>