<?php
	error_reporting(E_ALL);
    
	// INCLUDE FUNCTIONS
	include_once 'functions.php';
	
	// INCLUDE DB_CONNECT
	include_once 'dbc.php';
	
	// START SECURE SESSION
	session_start();
	
	// GET SELECT OPTIONS FOR RD_ID
	if(isset($_POST["rid"]) && !empty($_POST["rid"])) {
	    // GET ROUND DESIGNATION
		$rd_designation = mysqli_real_escape_string($mysqli, utf8_encode($_POST['rid']));
									
		// SANITIZE AND EXPLODE TO RD_TYPE (GP, SP, WP) AND RD_ID (1, 2, n-1)
		if(strpos($rd_designation, "WP") !== false) {
			$split = explode("WP", $rd_designation);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
		} elseif(strpos($rd_designation, "SP") !== false) {
			$split = explode("SP", $rd_designation);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
		} elseif(strpos($rd_designation, "GP") !== false) {
			$split = explode("GP", $rd_designation);
			$mz_id_type = $split[0];
			$mz_id_round = $split[1];
	    }
		
		// CHECK WHETHER HAS REGULAR TIME INPUT OR ONLY DRIVING TIME (SEE ADDRD FOR INFO)
		$select_main_wptable = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `rid` = '" . $mz_id_round . "'";
		$result_main_wptable = mysqli_query($mysqli, $select_main_wptable);
		$getrow_main_wptable = mysqli_fetch_assoc($result_main_wptable);
		
		// IF REGULAR TIME INPUT (E. G. START AND GOAL)
		if($getrow_main_wptable['mode'] == 1) {
			// GRAB ALL POST AND BUILD QUERY
			$select = "SELECT * FROM `_tkev_nfo_exam` WHERE `rid` = " . $mz_id_round . " AND `eid` = " . $_SESSION['uid'] . " ORDER BY `rid` DESC";
			$result = mysqli_query($mysqli, $select);
				
			// COUNT TOTAL NUMBER OF ROWS
			$numrow = mysqli_num_rows($result);
			
			// DISPLAY POSITIONS LIST
			if($numrow > 0){
				echo '<option class="allocate_pos" value="">Position zuweisen</option>';
				while($spalte = mysqli_fetch_assoc($result)) {
					if(($spalte['positions'] - 2) > 0) {
						echo '<option class="Start" value="Start">Start</option>';
						for($i = 0; $i < ($spalte['positions'] - 2); $i++) {
							$j = $i + 1;
							echo '<option class="ZZ' . $j . '" value="ZZ' . $j . '">Zwischenzeit ' . $j . '</option>';
						}
						echo '<option class="Ziel" value="Ziel">Ziel</option>';
					} elseif(($spalte['positions'] - 2) == 0) {
						echo '<option class="Start" value="Start">Start</option>';
						echo '<option class="Ziel" value="Ziel">Ziel</option>';
					}
				}
			} else {
				echo '<option>Nicht verfügbar</option>';
			}
		// ELSE IRREGULAR TIME INPUT (E. G. DRIVING TIME ONLY)
		} elseif($getrow_main_wptable['mode'] == 2) {
			// GRAB ALL POST AND BUILD QUERY
			$select = "SELECT * FROM `_tkev_nfo_exam` WHERE `rid` = " . $mz_id_round . " AND `eid` = " . $_SESSION['uid'] . " ORDER BY `rid` DESC";
			$result = mysqli_query($mysqli, $select);
				
			// COUNT TOTAL NUMBER OF ROWS
			$numrow = mysqli_num_rows($result);
			
			// DISPLAY POSITIONS LIST
			if($numrow > 0){
				echo '<option class="allocate_pos" value="">Position zuweisen</option>';
				echo '<option class="Sprint" value="Sprint">Sprint</option>';
			} else {
				echo '<option>Nicht verfügbar</option>';
			}
			
			echo	'
						<script>
							$(".rid_pos_1_2").attr("disabled", "disabled");
							$(".rid_pos_1_3").attr("disabled", "disabled");
							$(".rid_pos_1_4").attr("disabled", "disabled");
							$(".rid_pos_1_5").attr("disabled", "disabled");
						</script>
					';
		}
    }
?>