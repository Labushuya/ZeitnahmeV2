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
		if($_POST['bezeichnung'] == "GP" OR $_POST['bezeichnung'] == "SP" OR $_POST['bezeichnung'] == "WP") {
			$rd_type = mysqli_real_escape_string($mysqli, $_POST["bezeichnung"]);
	
			//	Suche nach Rundenbezeichnung für Änderung
			$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
			$result_rdtype = mysqli_query($mysqli, $select_rdtype);
			$numrow_rdtype = mysqli_num_rows($result_rdtype);
			$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
			
			if($numrow_rdtype > 0) {
				echo '<option value="' . $getrow_rdtype['type'] . '" selected="selected" disabled="disabled">Ändern auf ..</option>';
				
				if($getrow_rdtype['type'] == "GP") {
					echo '<option value="SP">SP</option>';
					echo '<option value="WP">WP</option>';
				} elseif($getrow_rdtype['type'] == "SP") {
					echo '<option value="GP">GP</option>';
					echo '<option value="WP">WP</option>';
				} elseif($getrow_rdtype['type'] == "WP") {
					echo '<option value="GP">GP</option>';
					echo '<option value="SP">SP</option>';
				}			
			} else {
				echo '<option value="" selected="selected" disabled="disabled">Prüfung anlegen!</option>';
			}
		} elseif(is_numeric($_POST['bezeichnung'])) {
			echo "yeah";
			
			$rid = mysqli_real_escape_string($mysqli, $_POST["bezeichnung"]);
			
			//	Suche nach Rundenbezeichnung für Änderung
			$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
			$result_rdtype = mysqli_query($mysqli, $select_rdtype);
			$numrow_rdtype = mysqli_num_rows($result_rdtype);
			$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
			
			//	Suche nach Runden für Änderung
			$select_rds = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1' ORDER BY `rid` ASC";
			$result_rds = mysqli_query($mysqli, $select_rds);
			$numrow_rds = mysqli_num_rows($result_rds);
			
			if($numrow_rds > 0) {
				echo '<option value="" selected="selected" disabled="disabled">Bitte wählen</option>';
				
				while($getrow_rds = mysqli_fetch_assoc($result_rds)) {
					echo '<option value="' . $getrow_rds['rid'] . '">' . $getrow_rdtype['type'] . $getrow_rds['rid'] . '</option>';
				}		
			} else {
				echo '<option value="" selected="selected" disabled="disabled">Prüfung anlegen!</option>';
			}
		}	
	}
?>