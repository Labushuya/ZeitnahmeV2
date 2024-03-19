<? error_reporting(E_ALL);
	date_default_timezone_set("Europe/Berlin");

    // INCLUDE FUNCTIONS
	include_once 'functions.php';
	
	// INCLUDE DB_CONNECT
	include_once 'dbc.php';
	
	// START SECURE SESSION
	session_start();
	
	// GET SELECT OPTIONS FOR RD_ID
	if(isset($_POST["rid"]) && !empty($_POST["rid"])) {
		// GET ROUND DESIGNATION
		$rid = mysqli_real_escape_string($mysqli, utf8_encode($_POST['rid']));
									
		// SANITIZE AND EXPLODE TO RD_TYPE (GP, SP, WP) AND RD_ID (1, 2, n-1)
		if(strpos($rid, "WP") !== false) {
			$split = explode("WP", $rid);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
		} elseif(strpos($rid, "SP") !== false) {
			$split = explode("SP", $rid);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
		} elseif(strpos($rid, "GP") !== false) {
			$split = explode("GP", $rid);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
	    }
		
		//	Suche nach Runde für Anzahl Positionen
		$select_rds = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `rid` = '" . $mz_id_round . "' AND `active` = '1' ORDER BY `rid` ASC";
		$result_rds = mysqli_query($mysqli, $select_rds);
		$numrow_rds = mysqli_num_rows($result_rds);
			
		if($numrow_rds > 0) {
			$getrow_rds = mysqli_fetch_assoc($result_rds);
			
			for($h = 0; $h < $getrow_rds['positions']; $h++) {
				echo	'
						<div class="6u$ 12u$(xsmall) appended">
							<div class="select-wrapper">
								<select name="mz_id[]" class="rid_pos">
									<option class="allocate_pos" value="allocate_pos">Position zuweisen</option>
						';
				if(($getrow_rds['positions'] - 2) > 0) {
					echo '			<option class="Start" value="Start">Start</option>';
					
					for($i = 0; $i < ($getrow_rds['positions'] - 2); $i++) {
						$j = $i + 1;
						
							echo '	<option class="ZZ' . $j . '" value="ZZ' . $j . '">Zwischenzeit ' . $j . '</option>';
					}
					
					echo '			<option class="Ziel" value="Ziel">Ziel</option>';
				} elseif(($getrow_rds['positions'] - 2) == 0) {
					echo '			<option class="Start" value="Start">Start</option>';
					echo '			<option class="Ziel" value="Ziel">Ziel</option>';
				}
				
				echo	'		
								</select>
							</div>
						</div>
						';
			}
		}
	}
?>