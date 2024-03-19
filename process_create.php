<?php
	//	Starte Session
	session_start();

	// USER CAN MAKE EVENT
	if(isset($_POST['create'])) {
		//	Binde Functions ein
		include_once('includes/backend/functions.php');
		
		//	Prüfe immer auf aktiven Login
		if(!isset($_SESSION['uid']) OR empty($_SESSION['uid']) OR $_SESSION['uid'] == "") {
			header("Location: process_logout.php");
		} else {	
			//	Binde DB Connect ein
			require_once('includes/backend/dbc.php');
		
			// MAX SIZE 200KB
			$max_file_size = 1024 * 200;
			
			// VALID EXTENSIONS
			$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
			
			// THUMBNAIL SIZES
			$sizes =	array(
							100 => 100, 
							150 => 150, 
							250 => 250
						);
			
			if($_FILES['logo']['size'] < $max_file_size ) {
				// GET FILE EXTENSION
				$ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
				if(in_array($ext, $valid_exts)) {
					// RESIZE IMAGE
					foreach($sizes as $w => $h) {
						$files[] = resize($w, $h);
					}
				
					// PREPARE USER INPUT FOR DB
					// REWRITE POST VARIABLES
					$event			= cleanInput($_POST['eventname']);
					$event_owner	= cleanInput($_POST['eventhandler']);
					$reference		= cleanInput($_POST['reference']);
					$bezeichnung	= cleanInput($_POST['bezeichnung']);
					$t_calc			= cleanInput($_POST['zeitenberechnung']);
					$wperiod		= explode(':', cleanInput($_POST['karenzzeit']));
					$waiting_period = (3600 * intval($wperiod[0])) + (60 * intval($wperiod[1]));
					$wperiod		= $waiting_period;
					
					$start			= cleanInput($_POST['start']);
					$end			= cleanInput($_POST['end']);
					
					// SQL INJECTION DEFENCE
					$image = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
					$image_name = addslashes($_FILES['logo']['name']);
	
					// FORMAT EVENT VARIABLES
					$event			= titleCaseEvent($event);
					$event_owner	= titleCaseEventOwner($event_owner);
					
					// CONVERT DATES
					$start = convert_to_db($start);
					$end = convert_to_db($end);
					
					//	Prüfe auf Ersteller-Typ des Benutzers (type = AW oder VA)
					if($_SESSION['utype'] == 0) {
						$utype = "aw";
					} elseif($_SESSION['utype'] == 1) {
						$utype = "va";
					}
					
					// INSERT SANITIZED VARIABLES
					$insert =	"
								INSERT INTO
									_tkev_nfo_event(
										`id`,
										`eid`,
										`title`,
										`organizer`,
										`image_path_100`,
										`image_path_150`,
										`image_path_250`,
										`type`,
										`start`,
										`finish`,
										`wperiod`,
										`reference`,
										`calculation`,
										`active`
									)
								VALUES (
									NULL,
									'" . mysqli_real_escape_string($mysqli, utf8_decode($_SESSION['uid'])) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($event)) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($event_owner)) . "',
									'" . $files[0] . "',
									'" . $files[1] . "',
									'" . $files[2] . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($bezeichnung)) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($start)) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($end)) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($wperiod)) . "',
									'" . mysqli_real_escape_string($mysqli, utf8_decode($reference)) . "',
									'".mysqli_real_escape_string($mysqli, utf8_decode($t_calc))."',
									'1'
								)";
					mysqli_query($mysqli, $insert);
					
					// REDIRECT AFTER INSERT TRY
					if(mysqli_affected_rows($mysqli) == 1) {
						header('Location: /msdn/make_event_success.php');
						ob_end_flush(); 
					} else {
						header('Location: /msdn/make_event_fail.php');
						ob_end_flush(); 
					}
				} else {
					echo	'
							<script>
								$(document).ready(function() {
									$("#dialog-confirm").dialog({
										autoOpen: true,
										resizable: false,
										height: "auto",
										width: 400,
										modal: true,
										buttons: {
											"Verstanden": function() {
												$(this).dialog("close");
											}
										}
									}).bind("clickoutside", function(e) {
										$target = $(e.target);
										if (!$target.filter(".hint").length
											&& !$target.filter(".hintclickicon").length) {
											$field_hint.dialog("close");
										}
									});
									
									$("#results").submit(function() {
										$("#dialog-confirm").modal("show");
									});
								});
							</script>
							<div id="dialog-confirm" title="Logo größer als erlaubt">
								<p align="justify">
									<span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
									Bitte halten Sie sich an die vorgegebene Größe des Logos!
								</p>
							</div>
							';
				}
			} else {
				echo	'
						<script>
							$(document).ready(function(){
								$("#dialog-confirm").dialog({
									autoOpen: true,
									resizable: false,
									height: "auto",
									width: 400,
									modal: true,
									buttons: {
										"Verstanden": function(){
											$(this).dialog("close");
										}
									}
								}).bind("clickoutside", function(e) {
									$target = $(e.target);
									if (!$target.filter(".hint").length
											&& !$target.filter(".hintclickicon").length) {
										$field_hint.dialog("close");
									}
								});
								
								$("#results").submit(function(){
									$("#dialog-confirm").modal("show");
								});
							});
						</script>
						<div id="dialog-confirm" title="Unbekanntes Format">
							<p align="justify">
								<span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
								Dieses Format wird nicht unterstützt!<br /><br /><p style="text-align: center;"><u>Unterstützte Formate: jpeg, jpg, png, gif</u></p>
							</p>
						</div>
						';
			}
		}
	} else {
		header("Location: index.php");
	}
?>