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

        /*require_once('/home/www/mymedia_fr/lib/dblib.php');
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
        }*/

		//ldap ----------------------------------
// connection à ldap
		$ldaphost = "37.59.24.151"; //inserer ici l'addresse du serveur LDAP
		$ldapBaseDN = "dc=leadsmonitor, dc=fr";
		$ldapport = 389; // Optional.

// Eléments d'authentification LDAP
		$username = $_POST['username'];
		$password = $_POST['password'];

// Connexion au serveur LDAP
		$ldapconn = ldap_connect($ldaphost, $ldapport)
		or die("Impossible de se connecter au serveur LDAP.");

// Option du LDAP passer à la version 3
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		$filter="(|(mail=$username*))";
		$justthese = array("ou", "cn");
		$ldapsearch = ldap_search($ldapconn, $ldapBaseDN, $filter, $justthese);
		$result = ldap_get_entries($ldapconn,$ldapsearch);


//chercher ou et cn de user

		for ($i=0; $i<$result["count"]; $i++)
		{
		$ou= $result[$i]["ou"][0];
		}

		for ($i=0; $i<$result["count"]; $i++)
		{
		$cn= $result[$i]["cn"][0];
		}

//les identifiants du ldap_bind
		$rootdn = "cn=".$cn.",ou=".$ou.",dc=leadsmonitor,dc=fr";
		$ldapbind = ldap_bind($ldapconn, $rootdn, $password);

		if ($ldapbind)
			{
				require_once('/home/www/mymedia_fr/lib/dblib.php');
				if (!($con = db_connect_leadsv2_return())) die('DB Err');
              //  $SQLstring = "SELECT * FROM Compte WHERE IDcompte = '$username'";
            $result = mysql_query("SELECT c.salt as salt, p.produit_name as client_name,p.setupStep as step FROM Compte as c, Produit as p WHERE c.IDcompte  = '$username' AND c.IDproduit = p.IDproduit ") or die(mysql_error());
				//$result = mysql_query("SELECT * FROM Compte WHERE IDcompte = '$username'") or die(mysql_error());
                                        $result = mysql_fetch_array($result);
				$salt = $result['salt'];
                $response["token"] = base64_encode(sha1($username . $salt, true) . $salt);
                $response["client_name"] = $result["client_name"];
                $response["success"] = 1;
                $response["step"] = intval($result["step"]);
                $_SESSION[$response["token"]] = array("mymedia_username"=>$username);
			}
			else
			{
				$response["error"] = "Incorrect password or username";
			}


	return $response;
    }

?>