<? error_reporting(E_ALL);
	date_default_timezone_set("Europe/Berlin");

    // INCLUDE FUNCTIONS
	include_once 'functions.php';
	
	// INCLUDE DB_CONNECT
	include_once 'dbc.php';
	
	// START SECURE SESSION
	session_start();
	
	// GET SELECT OPTIONS FOR RD_ID
	if(isset($_POST["bezeichnung"]) && !empty($_POST["bezeichnung"])) {
		$rd_type = mysqli_real_escape_string($mysqli, $_POST["bezeichnung"]);
		
		// UPDATE EVERY EMPTY RD_TYPE
		// SET UPDATE QUERIES
		$update_race_run = "UPDATE `_tkev_nfo_event` SET `type` = '" . $rd_type . "' WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
		$update_main_wpt = "UPDATE `_tkev_nfo_exam` SET `type` = '" . $rd_type . "' WHERE `eid` = '" . $_SESSION['uid'] . "'";
		$update_optiozme = "UPDATE `_tkev_acc_timekeeper` SET `type` = '" . $rd_type . "' WHERE `eid` = '" . $_SESSION['uid'] . "'";
				
		// TOTAL VARIABLE
		$pts = 0;
				
		// RUN QUERIES
		mysqli_query($mysqli, $update_race_run);
		if($update_race_run == true) {
			$pts++;
		}
		mysqli_query($mysqli, $update_main_wpt);
		if($update_main_wpt == true) {
			$pts++;
		}
		mysqli_query($mysqli, $update_optiozme);
		if($update_optiozme == true) {
			$pts++;
		}
			
		// IF QUERY SUCCESSFUL
		if($pts == 3) {
			echo 'Prüfungsbezeichnung wurde <strong>vollständig</strong> geändert!';
		} else {
			echo 'Prüfungsbezeichnung wurde <strong>unvollständig</strong> geändert!';
		}
	}
?>