<?php
class DBHelper {
	private static $db_connected = false;
	private static $db_sqlconnexion;
	private static $sqlresult;
	static public function dblib_db_connect() {
		if (self::$db_connected) {
			return true;
		}

		self::$db_sqlconnexion = mysql_connect("babel.mymedia.fr", "lmuser", "lmuser")
		 or die('Could not connect: '.mysql_error());
		self::$db_connected = mysql_select_db("leadsmonitor");
		return self::$db_connected;
	}

	static public function dblib_db_disconnect() {
		mysql_close(self::$db_sqlconnexion);
	}

	static public function Query($sqlrequest){
		self::dblib_db_connect();
		self::$sqlresult = mysql_query($sqlrequest);
		self::dblib_db_disconnect();
		return(self::$sqlresult );
	}

	static public function getQueryRowNumber(){
		return mysql_num_rows(self::$sqlresult);
	}

	static public function getRow(){
		return  mysql_fetch_assoc(self::$sqlresult);
	}
}
?>