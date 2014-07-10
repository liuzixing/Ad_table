<?php
class DBHelper {
	public static $db_connected = false;
	public static $db_sqlconnexion;

	static public function dblib_db_connect() {
		if (self::$db_connected) {return true;
		}

		self::$db_sqlconnexion = mysql_connect("babel.mymedia.fr", "lmuser", "lmuser")
		 or die('Could not connect: '.mysql_error());
		self::$db_connected = mysql_select_db("leadsmonitor");
		return self::$db_connected;
	}

	static public function dblib_db_disconnect() {
		mysql_close(self::$db_sqlconnexion);
	}
}
?>